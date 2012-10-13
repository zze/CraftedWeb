<?php
/* ___           __ _           _ __    __     _
  / __\ __ __ _ / _| |_ ___  __| / / /\ \ \___| |__
 / / | '__/ _` | |_| __/ _ \/ _` \ \/  \/ / _ \ '_ \
/ /__| | | (_| |  _| ||  __/ (_| |\  /\  /  __/ |_) |
\____/_|  \__,_|_|  \__\___|\__,_| \/  \/ \___|_.__/

		-[ Created by ©Nomsoft
		  `-[ Original core by Anthony (Aka. CraftedDev)

				-CraftedWeb Generation II-
			 __                           __ _
		  /\ \ \___  _ __ ___  ___  ___  / _| |_
		 /  \/ / _ \| '_ ` _ \/ __|/ _ \| |_| __|
		/ /\  / (_) | | | | | \__ \ (_) |  _| |_
		\_\ \/ \___/|_| |_| |_|___/\___/|_|  \__|	- www.Nomsoftware.com -
                  The policy of Nomsoftware states: Releasing our software
                  or any other files are protected. You cannot re-release
                  anywhere unless you were given permission.
                  © Nomsoftware 'Nomsoft' 2011-2012. All rights reserved.  */

session_start();
define('INIT_SITE', TRUE);
require('../configuration.php');
require('../misc/connect.php');
require('../classes/account.php');
require('../classes/character.php');
require('../classes/shop.php');

connect::connectToDB();


if($_POST['action'] == 'removeFromCart')
{
	unset($_SESSION[$_POST['cart']][$_POST['entry']]);
	return;
}

if($_POST['action'] == 'addShopitem')
{
   $entry = (int)preg_replace("/[^0-9]/", "", $_POST['entry']);
   $shop =  mysql_real_escape_string($_POST['shop']);

   if(isset($_SESSION[$_POST['cart']][$entry]))
		$_SESSION[$_POST['cart']][$entry]['quantity']++;
   else
   {
	connect::selectDB('webdb');

	$result = mysql_query('SELECT entry, price FROM shopitems WHERE entry="'.$entry.'" AND in_shop="'.$shop.'"');
	if(mysql_num_rows($result) != 0)
	{
		$row = mysql_fetch_array($result);
		$_SESSION[$_POST['cart']][$row['entry']] = array('quantity' => 1, 'price' => $row['price']);
	}
  }
  return;
}

if($_POST['action'] == 'clear')
{
	unset($_SESSION['donateCart']);
	unset($_SESSION['voteCart']);
    return;
}

if($_POST['action'] == 'getMinicart')
{	$curr = ($_POST['cart'] == 'donateCart' ? $GLOBALS['donation']['coins_name'] : 'Vote Points');

	if(!isset($_SESSION[$_POST['cart']]))
	{
		echo "<b>Show Cart:</b> 0 Items (0 ".$curr.")";
		exit;
	}

    $entrys = array_keys($_SESSION[$_POST['cart']]);
    if (count($entrys) <= 0)
    {
        echo "<b>Show Cart:</b> 0 Items (0 ".$curr.")";
        exit;
    }

    $num        = 0;
    $totalPrice = 0;
    connect::selectDB('webdb');
    $shop_filt = mysql_real_escape_string(substr($_POST['cart'], 0, -4));

    // Generate List
    $query = "SELECT entry, price FROM shopitems WHERE in_shop = '{$shop_filt}' AND entry IN (";
    $query .= implode(', ', $entrys);
    $query .= ")";

    if ($result = mysql_query($query))
    {
        while($row = mysql_fetch_assoc($result))
        {
            $item = $_SESSION[$_POST['cart']][$row['entry']];
            if ($item)
            {
                $num = $num + $item['quantity'];
                $totalPrice = $totalPrice + ($item['quantity'] * $row['price']);
                unset($item);
            }
        }
    }

    echo "<b>Show Cart:</b> {$num} Items ({$totalPrice} {$curr})";
    return;
}

if($_POST['action'] == 'saveQuantity')
{
    // Prevent sql injection by only allowing numbers
    $qty = (int)preg_replace("/[^0-9]/", "", $_POST['quantity']);
	if($qty <= 0)
		unset($_SESSION[$_POST['cart']][$_POST['entry']]);
	else
	    $_SESSION[$_POST['cart']][$_POST['entry']]['quantity'] = $qty;
    return;
}

if($_POST['action']=='checkout')
{
	$totalPrice = 0;

	$values = explode('*', $_POST['values']);
    $character = character::getCharname($values[0],$values[1]);
    $accountID = account::getAccountID($_SESSION['cw_user']);
    $host      = $GLOBALS['realms'][$values[1]]['host'];
    $rank_user = $GLOBALS['realms'][$values[1]]['rank_user'];
    $rank_pass = $GLOBALS['realms'][$values[1]]['rank_pass'];
    $ra_port   = $GLOBALS['realms'][$values[1]]['ra_port'];

	connect::selectDB('webdb');
	require('../misc/ra.php');

    if(isset($_SESSION['donateCart']))
    {
        #####Donation Cart
        $entrys = array_keys($_SESSION['donateCart']);
        if (count($entrys) > 0)
        {
            // Array of valid items
            $items = array();

            // Generate List
            $query = "SELECT entry, price FROM shopitems WHERE in_shop = 'donate' AND entry IN (";
            $query .= implode(', ', $entrys);
            $query .= ")";
            if ($result = mysql_query($query))
            {
                while($row = mysql_fetch_assoc($result))
                {
                    $item = $_SESSION['donateCart'][$row['entry']];
                    if ($item)
                    {
                        // Update Price
                        $item['price'] = $row['price'];
                        $item['totalPrice'] = $row['price'] * $item['quantity'];
                        $totalPrice = $totalPrice + $item['totalPrice'];

                        // Valid Item!
                        $items[$row['entry']] = $item;
                        unset($item);
                    }
                }
            }
            if(account::hasDP($_SESSION['cw_user'], $totalPrice) == FALSE)
                die("You do not have enough {$GLOBALS['donation']['coins_name']}!");

            foreach ($items as $entry => $info)
            {
                $num = $info['quantity'];
                while ($num > 0)
                {
                    $qty = $num > 12 ? 12 : $num;
                    $command = "send items ".$character." \"Your requested item\" \"Thanks for supporting us!\" ".$entry.":".$qty." ";

                    if (sendRA($command, $rank_user, $rank_pass, $host, $ra_port))
                    {
                        shop::logItem("donate", $entry, $values[0], $accountID, $values[1], $qty);
                        account::deductDP($accountID, $info['price'] * $qty);
                    }

                    $num = $num - $qty;
                }
            }
        }
        unset($_SESSION['donateCart']);
    }
   ######

   if(isset($_SESSION['voteCart']))
   {
	 #####Donation Cart
	 foreach($_SESSION['voteCart'] as $entry => $value)
	 {
		$result = mysql_query("SELECT price FROM shopitems WHERE entry='".$entry."' AND in_shop='vote'");
		$row = mysql_fetch_assoc($result);

		$add = $row['price'] * $_SESSION['voteCart'][$entry]['quantity'];

		$totalPrice = $totalPrice + $add;
	  }

	  if(account::hasVP($_SESSION['cw_user'], $totalPrice) == FALSE)
		  die("You do not have enough Vote Points!");

	  foreach($_SESSION['voteCart'] as $entry => $value)
	  {
		  if($_SESSION['voteCart'][$entry]['quantity'] > 12)
		  {
			$num = $_SESSION['voteCart'][$entry]['quantity'];

			while($num > 0)
			{
				if($num > 12)
				$command = "send items ".character::getCharname($values[0],$values[1])." \"Your requested item\" \"Thanks for supporting us!\" ".$entry.":12 ";
				else
					$command = "send items ".character::getCharname($values[0],$values[1])." \"Your requested item\" \"Thanks for supporting us!\" ".$entry.":".$num." ";
				 shop::logItem("vote",$entry,$values[0],account::getAccountID($_SESSION['cw_user']),$values[1],$num);
		         sendRA($command,$rank_user,$rank_pass,$host,$ra_port);
					$num = $num - 12;
				}

		  }
		  else
		  {
		    $command = "send items ".character::getCharname($values[0],$values[1])." \"Your requested item\" \"Thanks for supporting us!\" ".$entry.":".$_SESSION['voteCart'][$entry]['quantity']." ";
			shop::logItem("vote",$entry,$values[0],account::getAccountID($_SESSION['cw_user']),$values[1],$_SESSION['voteCart'][$entry]['quantity']);
		    sendRA($command,$rank_user,$rank_pass,$host,$ra_port);
		  }
	  }
	  account::deductVP(account::getAccountID($_SESSION['cw_user']), $totalPrice);
	  unset($_SESSION['voteCart']);
   }
   ######
   echo TRUE;
}

if($_POST['action'] == 'removeItem')
{
	if(account::isGM($_SESSION['cw_user']) == FALSE)
    	exit;

	$entry = (int)preg_replace("/[^0-9]/", "", $_POST['entry']);
	$shop = mysql_real_escape_string($_POST['shop']);

	connect::selectDB('webdb');
	mysql_query("DELETE FROM shopitems WHERE entry='".$entry."' AND in_shop='".$shop."'");
    return;
}

if($_POST['action'] == 'editItem')
{
	if(account::isGM($_SESSION['cw_user'])==FALSE)
    	exit();

	$entry = (int)preg_replace("/[^0-9]/", "", $_POST['entry']);
	$shop  = mysql_real_escape_string($_POST['shop']);
	$price = (int)preg_replace("/[^0-9]/", "", $_POST['price']);

	connect::selectDB('webdb');

	if($price >= 0)
		mysql_query("UPDATE shopitems SET price='".$price."' WHERE entry='".$entry."' AND in_shop='".$shop."'");
    return;
}
?>
<?php
#   ___           __ _           _ __    __     _     
#  / __\ __ __ _ / _| |_ ___  __| / / /\ \ \___| |__  
# / / | '__/ _` | |_| __/ _ \/ _` \ \/  \/ / _ \ '_ \ 
#/ /__| | | (_| |  _| ||  __/ (_| |\  /\  /  __/ |_) |
#\____/_|  \__,_|_|  \__\___|\__,_| \/  \/ \___|_.__/ 
#
#		-[ Created by �Nomsoft
#		  `-[ Original core by Anthony (Aka. CraftedDev)
#
#				-CraftedWeb Generation II-                  
#			 __                           __ _   							   
#		  /\ \ \___  _ __ ___  ___  ___  / _| |_ 							   
#		 /  \/ / _ \| '_ ` _ \/ __|/ _ \| |_| __|							   
#		/ /\  / (_) | | | | | \__ \ (_) |  _| |_ 							   
#		\_\ \/ \___/|_| |_| |_|___/\___/|_|  \__|	- www.Nomsoftware.com -	   
#                  The policy of Nomsoftware states: Releasing our software   
#                  or any other files are protected. You cannot re-release    
#                  anywhere unless you were given permission.                 
#                  � Nomsoftware 'Nomsoft' 2011-2012. All rights reserved.    
 
define('INIT_SITE', TRUE);
require('../configuration.php');
require('connect.php');

$send = 'cmd=_notify-validate';

 foreach ($_POST as $key => $value)
 {
     if(get_magic_quotes_gpc() == 1)
         $value = urlencode(stripslashes($value));
     else
         $value = urlencode($value);
		 
     $send .= "&$key=$value";
 }
 
 $head .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
 $head .= "Content-Type: application/x-www-form-urlencoded\r\n";
 $head .= 'Content-Length: '.strlen($send)."\r\n\r\n";
 $fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
 
 connect::selectDB('webdb');

 if ($fp !== false)
 {
    fwrite($fp, $head.$send);
    $resp = stream_get_contents($fp);
	
    $resp = end(explode("\n", $resp));
	 
	$item_number = mysql_real_escape_string($_POST['item_number']);
	$item_name = mysql_real_escape_string($item_number['0']);
	$mc_gross = mysql_real_escape_string($_POST['mc_gross']);
	$txn_id = mysql_real_escape_string($_POST['txn_id']);
	$payment_date = mysql_real_escape_string($_POST['payment_date']);
	$first_name = mysql_real_escape_string($_POST['first_name']);
	$last_name = mysql_real_escape_string($_POST['last_name']);
	$payment_type = mysql_real_escape_string($_POST['payment_type']);
	$payer_email = mysql_real_escape_string($_POST['payer_email']);
	$address_city = mysql_real_escape_string($_POST['address_city']);
	$address_country = mysql_real_escape_string($_POST['address_country']);
	$custom = mysql_real_escape_string($_POST['custom']);
	$mc_fee = mysql_real_escape_string($_POST['mc_fee']);
	$fecha = date("Y-m-d");
	$payment_status = mysql_real_escape_string($_POST['payment_status']);
	$reciever = mysql_real_escape_string($_POST['receiver_email']);		 
	
if ($resp == 'VERIFIED')
{
	if ($reciever!=$GLOBALS['donation']['paypal_email'])
		exit();
			
	mysql_query("INSERT INTO payments_log(userid,paymentstatus,buyer_email,firstname,lastname,city,country,mc_gross,mc_fee,itemname,paymenttype,
	paymentdate,txnid,pendingreason,reasoncode,datecreation) values ('".$custom."','".$payment_status."','".$payer_email."',
	'".$first_name."','".$last_name."','".$address_city."','".$address_country."','".$mc_gross."',
	'".$mc_fee."','".$item_name."','".$payment_type."','".$payment_date."','".$txn_id."','".$pending_reason."',
	'".$reason_code."','".$fecha."')");
				
	$to = $payer_email;
	$subject = $GLOBALS['donation']['emailResponse'];
	$message = 'Hello '.$first_name.'
	We would like to inform you that the recent payment you did was successfull.
	
	If you require further assistance, please contact us via the forums.
	------------------------------------------
	Payment email: '.$payer_email.'
	Payment amount: '.$mc_gross.'
	Buyer name: '.$first_name.' '.$last_name.'
	Payment date: '.$payment_date.'
	Account ID: '.$custom.'
	------------------------------------------
	This payment is saved in our logs.
	
	Thank you, the Management.
	';
	$headers = 'From: '.$GLOBALS['default_email'].'' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
	
	if ($GLOBALS['donation']['emailResponse']==true) 
	{
		mail($to, $subject, $message, $headers); 
		if ($GLOBALS['donation']['sendResponseCopy']==true)
			mail($GLOBALS['donation']['copyTo'], $subject, $message, $headers); 
	}

	$res = fgets ($fp, 1024);
	if($payment_status=="Completed")
	{
		mysql_query("INSERT INTO payments_log(userid,paymentstatus,buyer_email,firstname,lastname,mc_gross,paymentdate,datecreation) 
		 ('".$custom."','".$mc_gross."','".$payer_email."','".$first_name."','".$last_name."','".$mc_gross."','".$payment_date."','".$fecha."')");
		
		if($GLOBALS['donation']['donationType'] == 2)
		{
			for ($row = 0; $row < count($GLOBALS['donationList']); $row++)
			{
				$coins = $mc_gross;
				if($coins == $GLOBALS['donationList'][$row][2])
					mysql_query("UPDATE account_data SET dp=dp + ".$GLOBALS['donationList'][$row][1]." WHERE id='".$custom."'");
			}
		}
		elseif($GLOBALS['donation']['donationType'] == 1)
		{
			$coins = ceil($mc_gross);
			mysql_query("UPDATE account_data SET dp=dp + ".$coins." WHERE id='".$custom."'");
		}
				
 }
}
else if ($resp == 'INVALID')
{
		 mail($GLOBALS['donation']['copyTo'],"INVALID Donation","A payment was invalid. Information is shown below: <br/>
		  User ID : ".$custom."
		  Buyer Email: ".$payer_email."
		  Amount: ".$mc_gross." USD
		  Date: ".$payment_date."
		  First name: ".$first_name."
		  Last name: ".$last_name."
		  ","From: ".$GLOBALS['donation']['responseFrom']."");  
		  
		  mail($payer_email,"Hello there. Unfortunately, the latest payment you did was invalid. Please contact us for more information. 
		  
		  Best regards.
		  The Management");
	
		 mysql_query("INSERT INTO payments_log(userid,paymentstatus,buyer_email,firstname,lastname,mc_gross,paymentdate,datecreation) 
		 VALUES ('".$custom."','".$payment_status." - INVALID','".$payer_email."','".$first_name."','".$last_name."','".$mc_gross."','".$payment_date."','".$fecha."')");
    }
 }

fclose ($fp); 
 
?> 
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
?>
<?php

ini_set('display_errors', 1); ini_set('log_errors', 1); ini_set('error_log', dirname(__FILE__) . '/error_log.txt'); error_reporting(E_ALL);

if(isset($_POST['submit'])) 
{
	
	require('../config.php');
	mysql_connect($host, $user, $pass) or die(mysql_error());
			
	mysql_select_db($db);

	$myusername = $_POST['username'];
	
	$mypassword = $_POST['password'];

	$myusername = mysql_real_escape_string($myusername);
	
	$mypassword = mysql_real_escape_string($mypassword);

	$result = mysql_query("SELECT * FROM users WHERE username='" . $myusername . "' AND password='" . sha1($mypassword) . "'") or die(mysql_error());

	$r = mysql_fetch_array($result);
	
	$uid = $r['id'];

	if(mysql_num_rows($result) == 1)
	{
		setcookie("craftedloggedin", 1, 0);
		
		setcookie("myusername", $myusername, 0);
		
		setcookie("uid", $uid, 0);
		
		if(isset($_COOKIE['login_fail'])) { setcookie("login_fail",FALSE); }
		
		header("Location: home.php");
	}
	else
	{
	
		setcookie("login_fail", 1, time()+5);
		
		header("Location: index.php");
		
	
	}
}
else
{
	header("Location: index.php");
}
?>
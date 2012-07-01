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
		setcookie("moxxieloggedin", 1, 0);
		
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
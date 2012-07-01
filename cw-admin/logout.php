<?php
session_start();
if(isset($_COOKIE['moxxieloggedin']) == 1){
setcookie("moxxieloggedin",FALSE);
setcookie("myusername",FALSE);
setcookie("uid",FALSE);
session_destroy();
header("Location: index.php");
}
?>

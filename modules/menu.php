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
 
connect::selectDB('webdb');
if (!isset($_SESSION['cw_user'])) 
	$sql = "WHERE shownWhen = 'always' OR shownWhen = 'notlogged'"; 
else 
	$sql = "WHERE shownWhen = 'always' OR shownWhen = 'logged'";
			 		
 $getMenuLinks = mysql_query("SELECT * FROM site_links ".$sql." ORDER BY position ASC");
 if (mysql_num_rows($getMenuLinks)==0) 
 {
	 buildError("<b>Template error:</b> No menu links was found in the CraftedWeb database!",NULL);
	 echo "<br/>No menu links was found!";
 }
		 
 while($row = mysql_fetch_assoc($getMenuLinks)) 
 {
	 $curr = substr($row['url'],3);
	 if ($_GET['p']==$curr)
			 echo '<li><a href="'.$row['url'].'" class="current">'.$row['title'].'</a></li>';
	 else
		 echo '<li><a href="'.$row['url'].'">'.$row['title'].'</a></li>';
 }
?>
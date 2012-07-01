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

class traffic
{
	var $month;
	var $year;
	
	public static function unique($month,$year)
	{
		$result = mysql_query("SELECT ip FROM visits WHERE month='".$month."' AND year='".$year."'");
		$unique = array();
		while($r = mysql_fetch_array($result))
		{	
			array_push($unique, $r['ip']);	
		}

		$n = array_unique($unique);
		
		echo count($n);
	}
	
	public static function visits($month,$year)
	{
		$result = mysql_query("SELECT ip FROM visits WHERE month='".$month."' AND year='".$year."'");
		$c = mysql_num_rows($result);
		
		echo $c;
	}
	
	private function pageunique($page)
	{
		if(isset($_GET['month']))
		{
			$query = "SELECT ip FROM visits WHERE month='".$_GET['month']."' AND year='".date('Y')."' AND page='".$page."'";
		}
		elseif(isset($_GET['all']) && $_GET['all'] == "true")
		{
			$query = "SELECT ip FROM visits WHERE year='".date('Y')."' AND page='".$page."'";
		}
		else
		{
			$query = "SELECT ip FROM visits WHERE month='".date('n')."' AND year='".date('Y')."' AND page='".$page."'";
		}
		$result = mysql_query($query);
		$unique = array();
		while($r = mysql_fetch_array($result))
		{	
			array_push($unique, $r['ip']);	
		}

		$n = array_unique($unique);
		
		echo count($n);
	}
	
	private function pagevisits($page)
	{
		if(isset($_GET['month']))
		{
			$query = "SELECT ip FROM visits WHERE month='".$_GET['month']."' AND year='".date('Y')."' AND page='".$page."'";
		}
		elseif(isset($_GET['all']) && $_GET['all'] == "true")
		{
			$query = "SELECT ip FROM visits WHERE year='".date('Y')."' AND page='".$page."'";
		}
		else
		{
			$query = "SELECT ip FROM visits WHERE month='".date('n')."' AND year='".date('Y')."' AND page='".$page."'";
		}
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
		
		echo $count;
	}
	
	public static function pagetraffic()
	{
		if(isset($_GET['month']))
		{
			$query = "SELECT page FROM visits WHERE month='".$_GET['month']."' AND year='".date('Y')."'";
		}
		elseif(isset($_GET['all']) && $_GET['all'] == "true")
		{
			$query = "SELECT page FROM visits WHERE year='".date('Y')."'";
		}
		else
		{
			$query = "SELECT page FROM visits WHERE month='".date('n')."' AND year='".date('Y')."'";
		}
		$result = mysql_query($query);
		
		$array = array();
		
		while($r = mysql_fetch_array($result))
		{	
			array_push($array, $r['page']);	
		}
		
		$array = array_unique($array);
		$c = count($array);
		
		sort($array);
		
		//print_r($array);
		
		
		if($c != 0)
		{
		$i = 0;
			for($i=0; $i <= $c-1; $i++)
			{
				echo"
				<tr>
					<td><a href='#'>".$array[$i]."</a></td>
					<td>"; traffic::pagevisits($array[$i]); echo"</td>          
					<td>"; traffic::pageunique($array[$i]); echo"</td> 
				</tr>
				";	
			}
		}
		else
		{
			echo"
				<tr>
					<td>Sorry, there is no data to show for the selected period.</td>
					<td>&nbsp;</td>          
					<td>&nbsp;</td> 
				</tr>
				";		
		}
	}
	
	public static function chooseMonth()
	{
		$result = mysql_query("SELECT month FROM visits ORDER BY month");
		$array = array();
		while($r = mysql_fetch_array($result))
		{	
			array_push($array, $r['month']);	
		}

		$array = array_unique($array);
		
		$c = count($array);
		sort($array);
		
		$months = array(
			"1" => "January",
			"2" => "February",
			"3" => "March",
			"4" => "April",
			"5" => "May",
			"6" => "June",
			"7" => "July",
			"8" => "August",
			"9" => "September",
			"10" => "October",
			"11" => "November",
			"12" => "December"
		);
		
		//print_r($array);
		
		$i = 0;
		for($i=0; $i <= $c-1; $i++)
		{
			echo"<a href='?month=".$array[$i]."'>".$months[$array[$i]]."</a> | ";
		}
		echo "<a href='?all=true'>All</a><br /><br />";
		
		echo"Showing traffic report for: ";
		if(isset($_GET['month']))
		{
			echo $months[$_GET['month']];
		}
		elseif(isset($_GET['all']) && $_GET['all'] == "true")
		{
			echo "the entire year";
		}
		else
		{
			echo $months[date('n')];
		}
	}
	
}

class page
{
	var $id;
	var $title;
	var $text;
	var $img;
	
	public static function getPageList()
	{
		$result = mysql_query("SELECT id,name FROM pages");
		
		while($r = mysql_fetch_assoc($result))
		{
		echo"
			<tr>
				<td><a href='?edit=".$r['id']."'>".$r['name']."</a></td>
				<td class='action'>
					<a href='?edit=".$r['id']."' class='ico ico-edit'>Edit</a>
				</td>
			</tr>
		";
		}
	}
	
	public static function getPageContent($id)
	{
		$result = mysql_query("SELECT text FROM pages WHERE id='".$id."'");
		$r = mysql_fetch_assoc($result);
		
		echo $r['text'];
	}
	
	public static function getPageTitle($id)
	{
		$result = mysql_query("SELECT title FROM pages WHERE id='".$id."'");
		$r = mysql_fetch_assoc($result);
		
		echo $r['title'];
	}
	
	public static function getPageImg($id)
	{
		$result = mysql_query("SELECT img FROM pages WHERE id='".$id."'");
		$r = mysql_fetch_assoc($result);
		
		echo "<img src='.".$r['img']."' />";
	}
	
	public static function savePage($title,$text,$img)
	{
		if (($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/png"))
		{
			$uploaddir = '../images/';
			$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
			
			echo '<pre>';
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) 
			{
				echo "File is valid, and was successfully uploaded.\n";
			} 
			
			else 
			{
				echo "Possible file upload attack!\n";
			}
		}
		else
		{
			
		}
	}
}

?>
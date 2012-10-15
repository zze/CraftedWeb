<?php 
    session_start();
	$step = (int)$_GET['st']; 
	$steps = array(
	1 => 'Database Connection & General Info',
	2 => 'Configuration File',
	3 => 'Create database & Write configuration file',
	4 => 'Updates',
	5 => 'Adding your first realm',
	6 => 'Finished');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	<title>CraftedWeb Installer</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="install.css" type="text/css" media="screen" />
</head>
<body>
</center>
<div id="main_box">
	<h1>Installation &raquo; Step <?php echo $step; ?> (<?php echo $steps[$step]; ?>)</h1>

	<div id="content">
    	<?php include( './steps/' . $step . '.php' )?>
        
        <div id="info">
        	
        </div>
	</div>
</div>
&copy 2011-2012 <a href="http://nomsoftware.com/">Nomsoft</a>
</center>
</body>
</html>
<script type="text/javascript" src="scripts.js"></script>
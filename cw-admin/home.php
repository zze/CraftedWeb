<?php
/* ___           __ _           _ __    __     _     
  / __\ __ __ _ / _| |_ ___  __| / / /\ \ \___| |__  
 / / | '__/ _` | |_| __/ _ \/ _` \ \/  \/ / _ \ '_ \ 
/ /__| | | (_| |  _| ||  __/ (_| |\  /\  /  __/ |_) |
\____/_|  \__,_|_|  \__\___|\__,_| \/  \/ \___|_.__/ 

		-[ Created by �Nomsoft
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
                  � Nomsoftware 'Nomsoft' 2011-2012. All rights reserved.  */
?>
<?php
if(isset($_COOKIE['craftedloggedin']) && $_COOKIE['craftedloggedin'] == 1)
{
	require("../config.php");
	include("./classes/loader.php");
	loadClass('db');
	loadClass('traffic');
	loadClass('website');
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name='robots' content='all, follow' />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>CraftedWeb ACP</title>   
    <link href="public/css/default.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="public/css/blue.css" rel="stylesheet" type="text/css" media="screen" /> <!-- color skin: blue / red / green / dark -->
    <link href="public/css/datePicker.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="public/css/wysiwyg.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="public/css/fancybox-1.3.1.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="public/css/visualize.css" rel="stylesheet" type="text/css" media="screen" />
    
    <script type="text/javascript" src="public/js/jquery-1.4.2.min.js"></script>   
    <script type="text/javascript" src="public/js/jquery.dimensions.min.js"></script>
    
    <!-- // Tabs // -->
    <script type="text/javascript" src="public/js/ui.core.js"></script>
    <script type="text/javascript" src="public/js/jquery.ui.tabs.min.js"></script>

    <!-- // Table drag and drop rows // -->
    <script type="text/javascript" src="public/js/tablednd.js"></script>

    <!-- // Date Picker // -->
    <script type="text/javascript" src="public/js/date.js"></script>
    <!--[if IE]><script type="text/javascript" src="public/js/jquery.bgiframe.js"></script><![endif]-->
    <script type="text/javascript" src="public/js/jquery.datePicker.js"></script>

    <!-- // Wysiwyg // -->
    <script type="text/javascript" src="public/js/jquery.wysiwyg.js"></script>

    <!-- // Graphs // -->
    <script type="text/javascript" src="public/js/excanvas.js"></script>
    <script type="text/javascript" src="public/js/jquery.visualize.js"></script>

    <!-- // Fancybox // -->
  	<script type="text/javascript" src="public/js/jquery.fancybox-1.3.1.js"></script>

    <!-- // File upload // --> 
    <script type="text/javascript" src="public/js/jquery.filestyle.js"></script>
    
    <script type="text/javascript" src="public/js/init.js"></script>
  </head>   
  <body>
  <div id="main">
    <!-- #header -->
    <div id="header"> 
      <!-- #logo --> 
      <div id="logo">
        <a href="index.html" title="Go to Homepage"><span>CraftedWeb ACP</span></a>
      </div>
      <!-- /#logo -->
      <!-- #user -->                        
      <div id="user">
        <h2>Welcome: <?php echo $_COOKIE['myusername']; ?></h2>
        <a style="float:right" href="logout.php">logout</a>
      </div>
      <!-- /#user -->  
    </div>
    <!-- /header -->
    <!-- #content -->
    <div id="content">

        <!-- breadcrumbs -->
        <div class="breadcrumbs">
          <ul>
            <li class="home">Dashboard</li>
          </ul>
        </div>
        <!-- /breadcrumbs -->

        <!-- box -->
        <div class="box">
          <div class="headlines">
            <h2><span>Traffic graph</span></h2>
            <a href="#help" class="help"></a>
          </div>
          <!-- table -->
          <?php
	
		  
		  ?>
          <table class="chart none" id="line">
            	<thead>
            		<tr>
            			<td></td>
            			<th scope="col">Jan</th>
            			<th scope="col">Feb</th>
            			<th scope="col">Mar</th>
            			<th scope="col">Apr</th>
            			<th scope="col">May</th>
            			<th scope="col">Jun</th>
                  		<th scope="col">Jul</th>
                  		<th scope="col">Aug</th>
                  		<th scope="col">Sep</th>
                  		<th scope="col">Oct</th>
                  		<th scope="col">Nov</th>
                  		<th scope="col">Dec</th>
            		</tr>
            	</thead>
            	<tbody>
            		<tr>
            			<th scope="row">visitors</th>
            			<td><?php traffic::visits('1',date('Y')); ?></td>
            			<td><?php traffic::visits('2',date('Y')); ?></td>
            			<td><?php traffic::visits('3',date('Y')); ?></td>
                        <td><?php traffic::visits('4',date('Y')); ?></td>
                        <td><?php traffic::visits('5',date('Y')); ?></td>
                        <td><?php traffic::visits('6',date('Y')); ?></td>
                        <td><?php traffic::visits('7',date('Y')); ?></td>
                        <td><?php traffic::visits('8',date('Y')); ?></td>
                        <td><?php traffic::visits('9',date('Y')); ?></td>
                        <td><?php traffic::visits('10',date('Y')); ?></td>
                        <td><?php traffic::visits('11',date('Y')); ?></td>
                        <td><?php traffic::visits('12',date('Y')); ?></td>
            		</tr>
                	<tr>
            			<th scope="row">unique visitors</th>
            			<td><?php traffic::unique('1',date('Y')); ?></td>
            			<td><?php traffic::unique('2',date('Y')); ?></td>
            			<td><?php traffic::unique('3',date('Y')); ?></td>
                        <td><?php traffic::unique('4',date('Y')); ?></td>
                        <td><?php traffic::unique('5',date('Y')); ?></td>
                        <td><?php traffic::unique('6',date('Y')); ?></td>
                        <td><?php traffic::unique('7',date('Y')); ?></td>
                        <td><?php traffic::unique('8',date('Y')); ?></td>
                        <td><?php traffic::unique('9',date('Y')); ?></td>
                        <td><?php traffic::unique('10',date('Y')); ?></td>
                        <td><?php traffic::unique('11',date('Y')); ?></td>
                        <td><?php traffic::unique('12',date('Y')); ?></td>
                        
            		</tr>	
            	</tbody>
            </table>
          <!-- /table -->
       </div>
       <!-- /box -->
       
       <!-- box -->
        <div class="box">
          <div class="headlines">
            <h2><span>Detaild traffic</span></h2>
            <a href="#help" class="help"></a>
          </div>
          <p>Select month: <?php traffic::chooseMonth(); ?></p>
          <!-- table -->
          <table class="tab tab-drag">
            <tr class="top nodrop nodrag">
              <th>Page</th>
              <th>Visitors</th>          
              <th>Unique visitors</th>
            </tr>
            
            <?php traffic::pagetraffic(); ?>
            
          </table>
          <!-- /table -->
       </div>
       <!-- /box -->
       
    </div>
    <!-- /#content -->
    <!-- #sidebar -->
    <div id="sidebar">

        <!-- mainmenu -->
        <ul id="floatMenu" class="mainmenu">
          <li class="first active"><a class="link" href="home.php">Dashboard</a></li>
          <li><a href="pages.php" class="link">Pages</a></li>
          <li><a href="hope-page.php" class="link">Home page</a></li>
          <li><a href="menu.php" class="link">Menu</a></li>
          <li><a href="users.php" class="link">Users</a></li>
          <li class="last"><a href="jobb.php" class="link">Jobb</a></li>
        </ul>
        <!-- /.mainmenu -->

    </div>
    <!-- /#sidebar -->
    <!-- #footer -->
    <div id="footer">
      <p>&copy; 2011-2012 <a href="http://forums.nomsoftware.com">Nomsoft</a> | <a href="#main">Top</a></p>
    </div>
    <!-- /#footer -->
	
  <!-- MODAL WINDOW -->
	<div id="modal" class="modal-window">
				
		<h2>Example modal window</h2>

    <!-- Warning form message -->            
    <div class="form-message warning">
      <p>On the page the following error occurred.</p>
    </div>

		<p>Suspendisse et ante vitae turpis vestibulum fermentum nec nec elit. Suspendisse ullamcorper lacus in arcu mollis fringilla porta mi placerat. Ut at elit non diam tristique scelerisque. </p>

	</div>

  <!-- HELP WINDOW -->
	<div id="help" class="modal-window">
				
		<h2>Example help window</h2>

		<p>Suspendisse et ante vitae turpis vestibulum fermentum nec nec elit. Suspendisse ullamcorper lacus in arcu mollis fringilla porta mi placerat. Ut at elit non diam tristique scelerisque. </p>

    <ul class="list list-square">
      <li><strong>Lorem ipsum</strong>  dolor sit amet</li>
      <li><strong>consectetur adipiscing</strong> elit phasellus et risus</li> 
      <li><strong>Maecenas non</strong> nunc proin eleifend viverra sapien</li>
    </ul>
  
	</div>
	
	
  </div>
  <!-- /#main --> 
  </body>
</html>
<?php
}
else
{
	header("Location: index.php");
}
?>
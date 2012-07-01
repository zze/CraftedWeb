<?php
if(isset($_COOKIE['moxxieloggedin']) && $_COOKIE['moxxieloggedin'] == 1)
{
	require("../config.php");
	include("classes.php");
	mysql_connect($host, $user, $pass) or die(mysql_error());
	mysql_select_db($db) or die(mysql_error());
	mysql_query("SET NAMES UTF8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name='robots' content='all, follow' />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width">
    <title>Moxxie admin</title>   
    <link href="public/css/default.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="public/css/blue.css" rel="stylesheet" type="text/css" media="screen" /> <!-- color skin: blue / red / green / dark -->
    <link href="public/css/datePicker.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="public/css/wysiwyg.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="public/css/fancybox-1.3.1.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="public/css/visualize.css" rel="stylesheet" type="text/css" media="screen" />
    
    <script type="text/javascript" src="public/js/jquery-1.7.min.js"></script>   
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

    <!-- // Graphs // -->
    <script type="text/javascript" src="public/js/excanvas.js"></script>
    <script type="text/javascript" src="public/js/jquery.visualize.js"></script>

    <!-- // Fancybox // -->
  	<script type="text/javascript" src="public/js/jquery.fancybox-1.3.1.js"></script>

    <!-- // File upload // --> 
    <script type="text/javascript" src="public/js/jquery.filestyle.js"></script>
    
    <script type="text/javascript" src="public/js/init.js"></script>
    
    <!--//  Redactor // -->
    
    <link rel="stylesheet" href="./redactor/redactor/css/redactor.css" />
    		
	<script src="./redactor/redactor/redactor.js"></script>
	
	<script type="text/javascript">
	
	</script>
    
  </head>   
  <body>
  <div id="main">
    <!-- #header -->
    <div id="header"> 
      <!-- #logo --> 
      <div id="logo">
        <a href="index.html" title="Go to Homepage"><span>Great Admin</span></a>
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
            <li class="home"><a href="home.php">Dashboard</a></li>
            <li>Pages</li>
          </ul>
        </div>
        <!-- /breadcrumbs -->
		<?php
		if(!isset($_GET['edit']))
		{
		?>
        <!-- box -->
        <div class="box">
          <div class="headlines">
            <h2><span>Pages</span></h2>
			<a href="#help" class="help"></a>
          </div>
          <!-- table -->
          <table class="tab tab-drag">
            <tr class="top nodrop nodrag">
              <th>Pages</th>
              <th class="action">Action</th>
            </tr>
            <?php page::getPageList(); ?>
          </table>
          <!-- /table -->
       </div>
       <!-- /box -->
       <?php
		}
		else
		{
		?>
        <!-- box -->
        <div class="box">
          <div class="headlines">
            <h2><span>Edit Page</span></h2>
			<a href="#help" class="help"></a>
          </div>
			<div class="box-content">
            <form class="formBox" method="post" action="">
            	<fieldset>
                	<?php
					if(isset($_POST['submit']))
					{
					
					?>
                	<div class="form-message correct">
              			<p>Page saved successfully!</p>
            		</div>
                    <?php
					}
					?>
                	<div class="clearfix">
                  		<div class="lab"><label for="input-col">Title</label></div>
    		          	<div class="con" style="width:300px; float:left; margin-left:12px;"><input type="text" class="input" value="<?php page::getPageTitle($_GET['edit']); ?>" name="title" id="input-col" /></div>
    		        </div>
                    <div class="clearfix checkbox">
                    	<div class="lab"><label for="textarea-two">Text</label></div>
                        <div class="con"><div class="redactor_wrapper"><textarea id="redactor" name="content" style="width: 100%; height: 300px;"><?php page::getPageContent($_GET['edit']); ?></textarea></div></div>
                        
                    </div>
                    <div class="clearfix checkbox">
                  		<div class="lab">Image</div>
    		          	<div class="con"><?php page::getPageImg($_GET['edit']); ?></div>
    		        </div>
                    <div class="clearfix file">
                      <div class="lab"><label for="file">Upload file</label></div>
                      <div class="con"><input type="file" name="img" class="upload-file" id="file" /> 	
                      <div style="clear:both"></div>
                        By uploading a new image, you will owerwrite the current one!
                      </div>
                    </div> 
                    <div class="btn-submit"><!-- Submit form -->
                  		<input type="submit" name="submit" value="Submit form" class="button" />
                  		or <a href="" class="cancel">Cancel</a>
                	</div>
                </fieldset>    
        	</form>      
            </div>          
       </div>
       <!-- /box -->
         
        <?php
		}
		?>
       
    </div>
    <!-- /#content -->
    <!-- #sidebar -->
    <div id="sidebar">

        <!-- mainmenu -->
        <ul id="floatMenu" class="mainmenu">
          <li class="first"><a class="link" href="home.php">Dashboard</a></li>
          <li class="active"><a href="pages.php" class="link">Pages</a></li>
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
      <p>© 2010 Great Admin | <a href="#main">Top</a></p>
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
				
		<h2>Pages</h2>
		How to edit a page:<br /><br />
        <ul class="list list-square">
          <li>Press the pen icon in the action column to the far right.</li>
          <li><strong>OR</strong> click on the page name.</li> 
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
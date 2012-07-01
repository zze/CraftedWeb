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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name='robots' content='all, follow' />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>CraftedWeb ACP</title>   
    <link href="public/css/login.css" rel="stylesheet" type="text/css" />
    <link href="public/css/login-blue.css" rel="stylesheet" type="text/css" />  <!-- color skin: blue / red / green / dark -->
  </head>
  <body>
  <div id="main">
    <div id="content">
      <div id="login">
        
        <div id="logo"><span>CraftedWeb ACP</span></div>
                
        <form method="post" action="login-exec.php" id="form-login" class="formBox">
          <fieldset>
            <div class="form-col">
                <label for="username" class="lab">Username <span class="warning"></span></label>
                <input type="text" name="username" class="input" id="username" />
            </div>
            <div class="form-col form-col-right">
                <label for="password" class="lab">Password <span class="warning"></span></label>
                <input type="password" name="password" class="input" id="password" />
            </div>
            <div class="form-col form-col-check">
            <?php
				if(isset($_COOKIE['login_fail']))
				{
					echo "<font color='#FF0000'>Wrong username or password!</font>";
				}
			?>
              
            </div>
            <div class="form-col form-col-right"> 
              <input type="submit" name="submit" value="Login" class="submit" />
            </div>                 
          </fieldset>
        </form>
        
      </div>
    </div><!-- /content -->    
  </div><!-- /main -->
  </body>
</html>
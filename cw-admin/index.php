<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name='robots' content='all, follow' />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>Great admin</title>   
    <link href="public/css/login.css" rel="stylesheet" type="text/css" />
    <link href="public/css/login-blue.css" rel="stylesheet" type="text/css" />  <!-- color skin: blue / red / green / dark -->
  </head>
  <body>
  <div id="main">
    <div id="content">
      <div id="login">
        
        <div id="logo"><span>Great Admin</span></div>
                
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
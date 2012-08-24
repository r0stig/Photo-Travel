<?php
require_once('class/Authentication.php');


$error = false;

if (isset($_POST['username'] ) ) {
	$auth = new Authentication();
	if ( Authentication::validateUser($_POST['username'], $_POST['password'])) {
		header('location: index.php');
	} else {
		$error = true;
	}
}
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
	Authentication::logoutUser();
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Login..</title>
        
		<style>
		#loginBox {
			width: 500px;
			margin-left: auto;
			margin-right: auto;
		}
		</style>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
        <script src="js/bootstrap.js" type="text/javascript"></script>

    </head>
    <body>        
        <div id="loginBox">          

          <form class="well" method="post">
            <fieldset>
                <legend>Photo Travel login</legend>
				<p>
					<a href="index.php">Back to Photo Travel</a>
				</p>
				<?php if ($error): ?>
					<div class="alert alert-danger">Wrong username or password</div>
				<?php endif; ?>
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span><input name="username" type="text" class="span3" placeholder="Användarnamn...">
                </div>
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span><input name="password" type="password" class="span3" placeholder="Lösenord...">
                </div>
				<!--
                <div class="btn-group pull-right">
                  <button class="btn">Har du nyckel?</button>
                  <button class="btn">Glömt lösenord?</button>
                </div>
				-->
                <div>
                    <input type="submit" class="btn btn-primary" value="Logga in">
                </div>
            </fieldset>
          </form>

        </div>

    </body>
</html>

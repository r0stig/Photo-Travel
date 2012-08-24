<?php
require_once('class/DBAL.php');
require_once('development/loader.php');
require_once('class/Authentication.php');

$db = DBAL::getInstance();
?>
<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.tagit.css" />
	<link rel="stylesheet" type="text/css" href="css/tagit.ui-zendesk.css" />
	<title>Photo Travel</title>
    <style type="text/css">
      html { 
        height: 100%;
        font-face: Verdana, San-Serif, Tahoma;
        font-size: 11px;
      }
      body { height: 100%; margin: 0; padding: 0 }
      #map_canvas { height:500px; }
	  #singlePictureContainer {
	  height: 500px;
	  overflow: auto;
	  }
	  footer {
		text-align: center;
	  }
    </style>
    <script type="text/javascript">
        BASE_API_URL = 'http://localhost/html5/googlemaps/online-svn/trunk/api/';
        BASE_URL = 'http://localhost/html5/googlemaps/online-svn/trunk/';
		USER_ID = <?php echo Authentication::getSignedUserID(); ?>;
    </script>
	
	<!-- maybe minify libs aswell? -->
	<script type="text/javascript" src="js/libs/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/libs/jquery.iframe-transport.js"></script>
	<script type="text/javascript" src="js/libs/jquery-ui-1.8.22.custom.min.js"></script>
	<script type="text/javascript" src="js/libs/tag-it.js"></script>
	<script type="text/javascript" src="js/libs/underscore-min.js"></script>
	<script type="text/javascript" src="js/libs/backbone-min.js"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAPJ4AnTVVdpxwsdzdFzjs-7BwDUbWzuyk&sensor=false"></script>
	

	<?php echo $templates; ?>
	
	<script type="text/javascript" src="js/build.js"></script>
	<?php #echo file_get_contents("development/scripts.html"); ?>
    
  </head>
  <body>
    <div id="wrapper" class="container">
        <header id="header" class="span12">
            <div id="nav" class="navbar">
                <div class="navbar-inner">
                    <div class="container">
						<a href="#" class="brand">Photo Travel</a>
						<ul class="nav">
							<?php if (Authentication::getSignedUserID() !== -1): ?>
								<li>
									<a href="#management">Management</a>
								</li>
								<li class="divider-vertical"></li>
								<li>
									<a href="login.php?action=logout">Log out</a>
								</li>
							<?php else: ?>
								<li>
									<a href="login.php">Login</a>
								</li>
							<?php endif; ?>
							
						</ul>
                    </div>
                </div>
            </div>
        </header>
		
		<div id="container" class="span12"></div>
		<footer class="span12">
			Copyright &copy; r0stig 2012
		</footer>
    </div>
  
  </body>
</html>
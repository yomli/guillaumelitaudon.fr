<!DOCTYPE html>
<html>
	<head>
		<title>La Dive Bouteille - Connexion</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="<?php echo image_path('', 'favicon.png'); ?>" /><link rel="apple-touch-icon-precomposed" href="<?php echo image_path('', 'favicon-touch.png'); ?>" />
		<?php foreach($_['cssfiles'] as $cssfile): ?>
			<link rel="stylesheet" href="<?php echo $cssfile; ?>" type="text/css" media="screen" />
		<?php endforeach; ?>
		<link href="themes/responsive/core/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
		</script>
		<script type="text/javascript">
			var oc_webroot = '<?php echo OC::$WEBROOT; ?>';
			var oc_appswebroot = '<?php echo OC::$APPSWEBROOT; ?>';
			var oc_current_user = '<?php echo OC_User::getUser() ?>';
		</script>
		<?php foreach($_['jsfiles'] as $jsfile): ?>
			<script type="text/javascript" src="<?php echo $jsfile; ?>"></script>
		<?php endforeach; ?>
		<?php foreach($_['headers'] as $header): ?>
			<?php
				echo '<'.$header['tag'].' ';
				foreach($header['attributes'] as $name=>$value){
					echo "$name='$value' ";
				};
				echo '/>';
			?>
		<?php endforeach; ?>
		    <style>
      @import url(http://fonts.googleapis.com/css?family=Jacques+Francois);
      @import url(http://fonts.googleapis.com/css?family=IM+Fell+English+SC&text=La%20Dive%20Bouteille);
      #owncloud { font-family: 'IM Fell English SC', serif; line-height:40px;font-size:4em;
      margin:20px 5px; color:#555;} .jacques { font-family: 'Jacques Francois', serif; color:#555;}
      nav { margin-top:65px; height:50%;} #copyright { margin-left:25px;}
	  .navbar-inner, .navbar, .navbar-fixed-top, .container-fluid { background-color:#fff; }
	  .navbar .nav > .active > a { background:#555; } .navbar .nav > li > a:hover { background:#555; }
	  .navbar .nav > li > a { color:#555;} #body-login #login #header {height:5em; background-color:#fff; background-image:none; border:none; box-shadow:0 1px 3px rgba(0, 0, 0, 0.25), 0 -1px 0 rgba(0, 0, 0, 0.1) inset;} #content {margin-top:70px;} #content #controls {margin-top:65px;}
	  #new, .file_upload_filename, input[type="submit"], input[type="submit"]:hover { color:#fff; font-weight:normal; padding:2px 5px 3px 5px; margin-top:5px; background: none repeat scroll 0 0 #0074CC; -webkit-border-radius:0;-moz-border-radius:0;border-radius:0;border-color:#ccc;border-color:rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25); *background-color:#05c;background-image:-ms-linear-gradient(top,#08c,#05c);background-image:-webkit-gradient(linear,0 0,0 100%,from(#08c),to(#05c));background-image:-webkit-linear-gradient(top,#08c,#05c);background-image:-o-linear-gradient(top,#08c,#05c);background-image:-moz-linear-gradient(top,#08c,#05c);background-image:linear-gradient(top,#08c,#05c);background-repeat:repeat-x;border-color:#05c #05c #003580;border-color:rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);filter:progid:dximagetransform.microsoft.gradient(startColorstr='#0088cc',endColorstr='#0055cc',GradientType=0);filter:progid:dximagetransform.microsoft.gradient(enabled=false)} .file_upload_wrapper{margin-top:5px;} .file_upload_filename{ padding-right:8px; padding-bottom:2px;} #settings {bottom:8.5em;} 
	  .searchbox2 { position:absolute; top:5px; right:20px;} #login {background-color:#fff; border-bottom-color:#fff;} .infield {position:relative; top:-0.6em;} #login-form {position:relative; top:5em;} #body-login { background-color:#fff;} #submit {margin-right:20px;}
		</style>
	</head>

	<body id="body-login">
		<div id="login">
			<header id="header">
		<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
		<div class="container-fluid">
          <a href="<?php echo link_to('', 'index.php'); ?>" title="" id="owncloud" class="brand">La Dive Bouteille</a>
          <ul class="nav">
            <li>
              <a class="jacques" href="../index.html">
                Accueil
              </a>
            </li>
            <li class="active">
              <a class="jacques" href="<?php echo link_to('', 'index.php'); ?>?logout=true">
                Connexion
              </a>
            </li>
            <li>
              <a class="jacques" href="../contact.html">
                Contact
              </a>
            </li>
          </ul>
        </div>
			</div>
			</div>
		</header>
			<?php echo $_['content']; ?>
		</div>
		<hr>
		<div id="copyright" class="jacques">
        <p>
          <span class="st">
            © La Dive Bouteille 2012 - <a href="../mentions.html">Mentions légales</a>
          </span>
        </p>
      </div>
	</body>
</html>

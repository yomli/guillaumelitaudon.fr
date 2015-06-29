<?php include("admin/cm-admin.php"); ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="fr" class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="fr" class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="fr" class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="fr" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="fr"> <!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<title>Chez Madeleine
		<?php if(isset($_GET["page"])){
				switch($_GET["page"]){
					case "restaurant" :
						echo " - Le restaurant";
						break;
					case "menu" :
						echo " - Le menu";
						break;
					case "contact" :
						echo " - Nous contacter";
						break;
					case "mentions-legales" :
						echo " - Mentions légales";
						break;
					default :
						break;
				}
		}?>
		</title>
		
		<link rel="stylesheet" type="text/css" href="theme/styles/screen.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="theme/styles/print.css" media="print" />
		<link rel="shortcut icon" href="theme/images/favicon.ico">
		<link rel="shortcut icon" type="image/x-icon" href="theme/images/favicon.png" />
		<link rel="apple-touch-icon" href="theme/images/favicon.png" />
		<link type="text/plain" rel="author" href="humans.txt" />
		
		<meta name="viewport" content="width=device-width" />
		<meta name="description" content="<?php echo $cm->cm_description;?>" />
		<meta name="keywords" content="<?php echo $cm->cm_keywords;?>" />
		
		<!--[if lte IE 8]>
			<script src="theme/iefix/html5.js"></script>
		<![endif]--> 
		<!--[if IE]>
			<script src="theme/iefix/textshadow.js"></script>		
		<![endif]-->
		
		<?php if($cm->isLogged()){ ?>
			<script src="admin/scripts/jquery-min.js"></script>
			<script src="admin/scripts/jquery-ui.js"></script>
			<link rel="stylesheet" type="text/css" href="admin/scripts/jquery-ui.css"/>
			<script src="admin/tinymce/tiny_mce.js"></script>
			<script src="admin/scripts/tinymceconfigsave.js"></script>
			<style>
				.mceExternalToolbar {
					position:fixed !important;
					top:33% !important;
					z-index:1000 !important;	
					text-shadow: 0px 0px 0px #000 !important;
				}
				.mceExternalToolbar a {
					color:#000 !important;
				}
				.mceExternalToolbar table {
					border-spacing: 0 !important;
					margin:0 !important;
				}
				.mceExternalToolbar td, .mceExternalToolbar tr {
					border:solid 0px #000 !important;
				}		
			</style>
		<?php } ?>
		
		<script>
		var topdistant = false;
		function getScrollY() {
			var scrOfY = 0; //, scrOfX = 0;
				if( typeof( window.pageYOffset ) == 'number' ) {
					scrOfY = window.pageYOffset; //scrOfX = window.pageXOffset;
				} else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
					scrOfY = document.body.scrollTop; //scrOfX = document.body.scrollLeft;
				} else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
					scrOfY = document.documentElement.scrollTop; //scrOfX = document.documentElement.scrollLeft;
				}
			return scrOfY;
		}
		function topDistanceCrosses(distance){
			if (getScrollY() > distance && !topdistant) {
				topdistant = true;
				document.getElementById("top").style.display="inline";
				return 1 ; // going down
			}
			else if(getScrollY() < distance && topdistant ) {
				topdistant = false;
				document.getElementById("top").style.display="none";
				return 2; // going up
			}
			else {
				return 0; // nothing happens
			}
		}
		
		</script>
		
	</head>
	
	<body onload="topDistanceCrosses(window.screen.availHeight)" onscroll="topDistanceCrosses(window.screen.availHeight)">
		<?php if($cm->isLogged()){ ?>
				<div id="admin">
					<ul>
						<li class="first"><a href="index.php?config" title="Configuration">Configuration</a></li>
						<li class="second"><a href="index.php?aide" title="Aide">Aide</a></li>
						<li class="third"><a href="index.php?logout" title="Déconnexion">Déconnexion</a></li>
					</ul>
				</div>
		<?php } ?>
		<header>
			<div id="banner">
				<h1><a href="index.php" title="Chez Madeleine">Chez Madeleine</a></h1>
				<h2><?php echo $cm->cm_title;?></h2>
			</div>
			
			<nav>
				<ul>
					<li class="first"><a href="index.php?page=restaurant" title="">Le restaurant</a></li>
					<li class="second"><a href="index.php?page=menu" title="">Le menu</a></li>
					<li class="third"><a href="index.php?page=contact" title="">Nous contacter</a></li>
				</ul>
			</nav>		
		</header>
		
		<div id="wrapper">
			<div id="page">
				
					<?php 
						if(isset($_GET["page"])){
							$url = "pages/";
							switch($_GET["page"]){
								case "restaurant" :
									$url .= "lerestaurant.php";
									echo "<h3>Le restaurant</h3><div id='content' class='editable'>";
									break;
								case "menu" :
									$url .= "lemenu.php";
									echo "<h3>Le menu</h3><div id='content' class='editable'>";
									break;
								case "contact" :
									$url .= "nouscontacter.php";
									echo "<h3>Nous contacter</h3><div id='content' class='editable'>";
									break;
								case "mentions-legales" :
									$url .= "mentionslegales.php";
									echo "<h3>Mentions légales</h3><div id='content-admin' class='editable'>";
									break;
								default :
									break;
							}
							include($url);
						}
						elseif(isset($_GET["admin"]) && !$cm->isLogged()){
							include("admin/login.php");
						}
						elseif(isset($_GET["config"]) && $cm->isLogged()){

							if(isset($_POST["save"])){
								$datas = $cmc->save();
								if(!$cmc->write($datas))
									die("Impossible d'écrire dans " . $cmc->file);

								header("Location: " . $cm->getUrl());
								echo '<div id="content-admin"><p style="margin-top:25px;">Changements enregistrés</p><br /><p><a href="index.php?config" title="">Revenir à la page de configuration</a><br /><a href="index.php?config" title="">Se déconnecter</a></p>';
								exit();
							}

							include("admin/config.php");
						}
						elseif(isset($_GET["aide"]) && $cm->isLogged()){
							include("admin/help.php");
						}
						else {
							echo '<h3>Le restaurant</h3><div id="content-admin">'; 
							include("pages/lerestaurant.php"); 
						}
					?>
				</div>
			</div>
		
			
			<footer>
				<p>
					© Restaurant Chez Madeleine - 22, Boulevard Carnot 41700 Cour-Cheverny - <a href="index.php?page=mentions-legales" title="">Mentions légales</a>
					<?php if(!$cm->isLogged()){ ?> - <a href="index.php?admin" title="">Administration</a><?php } else { ?> - <a href="index.php?logout" title="">Déconnexion</a><?php } ?>
				</p>
			</footer>
		</div>
		<a href="#banner" title="" class="hidemobile" id="top">Retour en haut</a>
	</body>
</html>
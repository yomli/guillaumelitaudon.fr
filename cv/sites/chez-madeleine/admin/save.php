<?php
@session_start();
if(!empty($_SESSION['logged'])){

define("CM_PAGES", "../pages/");

$page = (isset($_POST["page"])) ? $_POST["page"] : "" ;
$content = (isset($_POST["content"])) ? $_POST["content"] : "" ;

switch($page){
	case "restaurant" :
		$page = "lerestaurant";
		break;
	case "menu" :
		$page = "lemenu";
		break;
	case "contact" :
		$page = "nouscontacter";
		break;
	case "mentions-legales" :
		$page = "mentionslegales";
		break;
	default :
		break;
}

if(!empty($page))
	$page = CM_PAGES . $page . ".php";

if((file_exists($page)) && !empty($page) && !empty($content)) {
	if(!$file = fopen($page, w)){
		echo "Echec de l'ouverture du fichier " . $page;
		exit;
	}
	else {
		fputs($file, $content);
		fclose($file);
	}
	
}
else {
	echo "Erreur lors de la lecture des donn&eacute;es";
	exit;
}


}


?>
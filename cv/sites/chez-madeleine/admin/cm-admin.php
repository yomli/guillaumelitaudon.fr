<?php

if (phpversion() < 5)
{
    die("Argh vous n'avez pas PHP 5 ! Installez-le maintenant !");
}

error_reporting(E_ALL);

// Contre les mauvaises configurations
if (get_magic_quotes_gpc())
{
    foreach ($_POST as $k=>$v)
    {
        $_POST[$k] = stripslashes($v);
    }
}

// Quelques constantes
define("CM_ROOT", "./");
define("CM_ADMIN", CM_ROOT . "admin/");
define("CM_DATAS", CM_ADMIN . "datas/");

include(CM_ADMIN . "cm-core.php");
include(CM_ADMIN . "cm-config.php");

$cm = new chezMadeleine;
$cmc = new chezMadeleineConfig;

if(file_exists(CM_DATAS . "userconfig.php"))
    require_once CM_DATAS . "userconfig.php";    


if(!defined("FROM_EXTERNAL") || !FROM_EXTERNAL){

	if(isset($_GET["logout"])){
        $cm->logout();
        header("Location: " . $cm->getUrl());
        exit;
    }
	
	elseif(isset($_GET["login"])){
        if($cm->login($_POST["login"], $_POST["password"])){
            header("Location: " . $cm->getUrl() );
            exit;
        }
        die("Connexion échouée !");
    }
	
	
	
}

?>
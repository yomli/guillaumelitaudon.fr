<?php
if(!defined('PLX_ROOT')) exit;

if(!empty($_POST)) {
  foreach ($_POST as $key=>$val){
    $plxPlugin->setParam($key, $val, 'string');
  }
  $plxPlugin->saveParams();
  header('Location: parametres_plugin.php?p=advancedsearch');
  exit;
}
$params = $plxPlugin->getParams();
?>

<style type="text/css">
form{
margin-top:20px;
display:table;
width:100%;
}
form div{
width:100%;
display:table-row;
}
form div label{
display:table-cell;
text-align:right;
width:50%;
padding-right:5px;
padding-top:10px;
}
form div input{
display:table-cell;
}
form div textarea{
display:table-cell;
width:100%;
height:80px;
}
</style>
<h2><?php echo $plxPlugin->getInfo("title") ?></h2>
<p><?php echo $plxPlugin->getInfo("description") ?></p>

<form action="parametres_plugin.php?p=advancedsearch" method="post">
<div><label for="i_url">Url de la page de recherche</label><input type="text" name="url" id="i_url" size=15 value="<?php echo (isset($params['url']))?$params['url']['value']:'advsearch'; ?>"></div>
<div><label for="i_template">Template de la page de recherche</label><input type="text" name="template" id="i_template" size=15 value="<?php echo (isset($params['template']))?$params['template']['value']:'static.php'; ?>"></div>
<div><label for="i_title">Titre de la page de recherche</label><input type="text" name="title" id="i_title" size=15 value="<?php echo (isset($params['title']))?$params['title']['value']:'Recherche'; ?>"></div>
<div><label for="i_maxtag">Nombre max de tags affichés</label><input type="text" name="maxtag" id="i_maxtag" size=5 value="<?php echo (isset($params['maxtag']))?$params['maxtag']['value']:'50'; ?>"></div>
<div><label for="i_yearfrom">Année du premier article (ou laisser vide)</label><input type="text" name="yearfrom" id="i_yearfrom" size=4 value="<?php echo (isset($params['yearfrom']))?$params['yearfrom']['value']:''; ?>"></div>
<div><label for="i_yearto">Année du dernier article (laisser vide)</label><input type="text" name="yearto" id="i_yearto" size=4 value="<?php echo (isset($params['yearto']))?$params['yearto']['value']:''; ?>"></div>
<div><label for="i_tpl">Template HTML pour l'affichage du résultat</label><textarea name="ajax_return_tpl" id="i_tpl"><?php echo (isset($params['ajax_return_tpl']))?plxUtils::strCheck($params['ajax_return_tpl']['value']):''; ?></textarea></div>
<div><label for="i_tpl_alt">Template alternatif (si chapo ou vignette vide)</label><textarea name="ajax_return_tpl_alt" id="i_tpl_alt"><?php echo (isset($params['ajax_return_tpl_alt']))?plxUtils::strCheck($params['ajax_return_tpl_alt']['value']):''; ?></textarea></div>
<br />
<input type="submit" name="submit" value="Enregistrer" />
</form>
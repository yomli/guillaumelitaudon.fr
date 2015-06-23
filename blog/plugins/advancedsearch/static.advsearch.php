<?php
// Recoit la requete AJAX et renvoie la liste des réponses en JSON
if(!defined('PLX_ROOT')) exit;

eval($this->callHook('advsearch_display'));
//$this->plxMotor->plxPlugins->aPlugins["advancedsearch"]->advsearch_display();

if (isset($_REQUEST["q"])){
?>
<script type="text/javascript">
window.onload = function() {
add_search('sp-text','<?php echo addslashes($_REQUEST["q"]) ?>','<?php echo addslashes($_REQUEST["q"]) ?>');
}
</script>
<?php
} //if (isset($_REQUEST["q"]))
?>
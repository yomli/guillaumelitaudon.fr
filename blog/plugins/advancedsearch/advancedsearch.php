<?php
/**
 * Plugin Advanced Search
 * v1.3 07/05/2015
 * Changelog :
 * 1.3  : Elimination d'un bug javascript (url en dur)
 *        Compatibilité améliorée avec les sites profonds  
 * 1.2  : Gestion de templates pour l'affichage des résultats
 *        Prise en charge vignettes et chapo
 *        Synergie avec plugin vignette de rockyhorror   
 * 1.1  : Synergie avec plugin catags
 *        Fix security issue  
 * 1.02 : Display AJAX error
 *        Display loading animation
 *        Fix IE8 issue
 *        Minify JS  
 **/
if(!defined('PLX_ROOT')) exit;

class advancedsearch extends plxPlugin {

  protected $url = 'search'; // URL par défaut de la recherche avancée
  protected $template = 'static.php'; // template pour la page de recherche
  protected $title = 'Recherche'; // Titre de la page de recherche
  protected $max_tags = 50; // Nombre de tags maximums affichés pour les recherches
  protected $year_from = false; //Année du premier post. Vous pouvez hardcoder pour éviter la recherche
  protected $year_to = false; // Année en cours par défaut. Vous pouvez modifier la valeur
  private $ajax_return_tpl = '<div>#art_date : <a href="#art_url">#art_title</a></div>';
  private $ajax_return_tpl_alt = '';
  private $ajax_tpl = false;
  private $used = false; // devient true pour les pages ou le template de recherche est affiché

  /**
   * Constructeur de la classe
   * @param  default_lang  langue par défaut
   * @return  stdio
   **/
  public function __construct($default_lang) {
    parent::__construct($default_lang);

    $var=$this->getParam('url');
    $this->url = empty($var)?$this->url:$var;
    $var=$this->getParam('template');
    $this->template = empty($var)?$this->template:$var;
    $var=$this->getParam('title');
    $this->title = empty($var)?$this->title:$var;
    $var=$this->getParam('maxtag');
    $this->max_tags = empty($var)?$this->max_tags:$var;
    $var=$this->getParam('yearfrom');
    $this->year_from = empty($var)?$this->year_from:$var;
    $var=$this->getParam('yearto');
    $this->year_to = empty($var)?$this->year_to:$var;

    if (!$this->year_to || empty($this->year_to))
      $this->year_to = date('Y');

    $var=$this->getParam('ajax_return_tpl');
    $this->ajax_return_tpl = empty($var)?$this->ajax_return_tpl:$var;
    $var=$this->getParam('ajax_return_tpl_alt');
    $this->ajax_return_tpl_alt = empty($var)?$this->ajax_return_tpl_alt:$var;
    
    $this->setConfigProfil(PROFIL_ADMIN);
    
    # Ajouts des hooks
    $this->addHook('advsearch_display', 'advsearch_display');
    $this->addHook('quick_display', 'quick_display');
    $this->addHook('ThemeEndBody', 'ThemeEndBody');
    $this->addHook('plxMotorPreChauffageBegin', 'plxMotorPreChauffageBegin');
    $this->addHook('plxShowConstruct', 'plxShowConstruct');
  }

// Méthode utilisée à l'activation du plugin
  public function onActivate() {
    $plxMotor = plxMotor::getInstance();
     
# On crée le template ajax (simple appel de contenu, sans décor)
      $this->ajax_tpl = $plxMotor->aConf['racine_themes'].$plxMotor->style.'/ajax.php';
      if (!is_file($this->ajax_tpl)) {
        file_put_contents(PLX_ROOT.$this->ajax_tpl, '<?php $plxShow->staticContent(); ?>');
      }
      $this->setParam('ajax_tpl',$this->ajax_tpl,'string');
      $this->setParam('ajax_return_tpl',$this->ajax_return_tpl,'string');
      $this->saveParams();
    } //function onActivate

// Méthode de traitement du hook plxShowConstruct qui détermine l'url de l'ajax
    public function plxShowConstruct() {

      if (!is_file($this->ajax_tpl))
        plxUtils::write('<?php $plxShow->staticContent(); ?>', PLX_ROOT.$this->getParam('ajax_tpl'));

    # infos sur la page statique
        echo '<?php    
        $array = array();
        if($this->plxMotor->mode=="ajax_advsearch") {
          $array[$this->plxMotor->cible] = array(
            "name"    => "ajax",
            "menu"    => "",
            "url"    => "ajax",
            "readable"  => 1,
            "active"  => 1,
            "group"    => ""
          );
        }'.(($this->url)?'elseif($this->plxMotor->mode=="'.$this->url.'"){
          $array[$this->plxMotor->cible] = array(
            "name"    => "'.$this->title.'",
            "menu"    => "",
            "url"    => "advsearch",
            "readable"  => 1,
            "active"  => 1,
            "group"    => ""
          );
        }':'').' //if($this->plxMotor->mode=="advsearch"
        $this->plxMotor->aStats = array_merge($this->plxMotor->aStats, $array);
        ?>';
    } //function plxShowConstruct

// Méthode de traitement du hook plxMotorPreChauffageBegin qui détermine le template ajax
    public function plxMotorPreChauffageBegin() {
      echo '<?php 
      if($this->get && preg_match("/^ajax_advsearch\/?/",$this->get)) {
        $this->mode = "ajax_advsearch";
        $this->cible = "../../plugins/advancedsearch/static";
        $this->template = "ajax.php";
        return true;
      }
      if($this->get && preg_match("/^'.$this->url.'\/?/",$this->get)) {
        $this->mode = "'.$this->url.'";
        $this->cible = "../../plugins/advancedsearch/static";
        $this->template = "'.$this->template.'";
        return true;
      }
      ?>';
    } //function plxMotorPreChauffageBegin
  
// Méthode qui importe le js si nécessaire
  public function ThemeEndBody() {
    if ($this->used){
      echo "\t".'<script type="text/javascript" src="'.PLX_PLUGINS.'advancedsearch/js/advsearch-min.js"></script>'."\n";
    }
  } //function ThemeEndBody
  
// Méthode qui affiche la recherche avancée
  public function advsearch_display() {
    $this->used = true;
    $plxMotor = plxMotor::getInstance();

// Recherche date du plus vieux post si non renseigné
    if(!$this->year_from || empty($this->year_from)){
      $plxGlob_arts = clone $plxMotor->plxGlob_arts;
      $motif = '/^[0-9]{4}.(?:[0-9]|home|,)*(?:'.$plxMotor->activeCats.'|home)(?:[0-9]|home|,)*.[0-9]{3}.[0-9]{12}.[a-z0-9-]+.xml$/';
      if($aFiles = $plxGlob_arts->query($motif,'art','rsort',0,false,'before')) {
        foreach($aFiles as $v) { # On parcourt tous les fichiers
          $art = $plxMotor->parseArticle(PLX_ROOT.$plxMotor->aConf['racine_articles'].$v);
          $art = substr($art["date"],0,4);
          if(!$this->year_from || $this->year_from > $art) $this->year_from = $art;
        }
      }
    }
    
// Construction de la liste des tags
if($plxMotor->aTags) {
$datetime = date('YmdHi');
$alphasort=array();
$tags_liste=array();
# On liste les tags sans créer de doublon
			foreach($plxMotor->aTags as $idart => $tag) {
				if(isset($plxMotor->activeArts[$idart]) AND $tag['date']<=$datetime AND $tag['active']) {
					if($tags = array_map('trim', explode(',', $tag['tags']))) {
						foreach($tags as $tag) {
							if($tag!='') {
								$t = plxUtils::title2url($tag);
								if(!isset($tags_liste['_'.$tag])) {
									$tags_liste['_'.$tag]=array('name'=>$tag,'url'=>$t,'count'=>1);
								}
								else
									$tags_liste['_'.$tag]['count']++;
								if(!in_array($t, $alphasort)) 
									$alphasort[] = $t; # pour le tri alpha
							}
						}
					}
				}
			}
// Si plugin catags actif
if (isset($plxMotor->plxPlugins->aPlugins["catags"])){
$tagcat = $plxMotor->plxPlugins->aPlugins["catags"]->getCaTags();
$catag = $plxMotor->plxPlugins->aPlugins["catags"]->getParams();
			# tri des tags
      if($alphasort) array_multisort($alphasort, SORT_ASC, $tags_liste);
// construction de la liste des tags
      $tags_liste_new = array(' '=>array());

      foreach($tags_liste as $tag)
        if (!isset($tagcat[$tag["name"]]))
          $tags_liste_new[' '][] = $tag["name"];
        
      foreach($catag as $cat=>$tags){
        $tags_liste_new[$cat] = explode(',',$tags["value"]);
        // nettoyage
        foreach($tags_liste_new[$cat] as $k=>$v){
          $tags_liste_new[$cat][$k] = trim($v);
          if (empty($tags_liste_new[$cat][$k])) unset($tags_liste_new[$cat][$k]);
        }
      }
      
 			# limite sur le nombre de tags à afficher
			if($this->max_tags!='') $tags_liste_new[' ']=array_slice($tags_liste_new[' '], 0, intval($this->max_tags), true);

// Si pas de plugin catags
}else{
			# limite sur le nombre de tags à afficher
			if($this->max_tags!='') $tags_liste=array_slice($tags_liste, 0, intval($this->max_tags), true);
			# tri des tags
      if($alphasort) array_multisort($alphasort, SORT_ASC, $tags_liste);
      
      $tags_liste_new = array(' '=>array());
      foreach($tags_liste as $tag)
        $tags_liste_new[' '][] = $tag["name"];
}
$tags_liste = $tags_liste_new;
}
$mois = array('01'=>'Janvier','02'=>'Février','03'=>'Mars','04'=>'Avril','05'=>'Mai','06'=>'Juin','07'=>'Juillet','08'=>'Aout','09'=>'Septembre','10'=>'Octobre','11'=>'Novembre','12'=>'Décembre');
$option_jan_dec = '';
foreach($mois as $k=>$v)
  $option_jan_dec .= "<option value='$k'>$v</option>";

for($i=$this->year_from;$i<=$this->year_to;$i++)
  $option_years .= "<option value='$i'>$i</option>";
?>

<div id=searchpool><legend>Liste des critères disponibles</legend><?php
foreach($tags_liste as $cat=>$tags){
?><div class="sp-tags" id="sp-tags<?php echo ($cat==' ')?'':'-'.str_replace(' ','_',$cat); ?>"><?php echo ($cat==' ')?'Mots clés':$cat; ?> : <?php

foreach($tags as $tag){
?><span><?php echo ucfirst($tag); ?></span><?php 
}
?></div><?php } ?>
  <div id="sp-cats" class="sp-tags">Catégories :<?php
foreach($plxMotor->aCats as $key=>$cat){
?><span catid="<?php echo $key; ?>"><?php echo ucfirst($cat["name"]); ?></span><?php 
}
?></div>

<div id=sp-date>Article publié entre <select name="sp-date-from" id="sp-date-from"><?php echo $option_jan_dec; ?></select><select name="sp-date-from-y" id="sp-date-from-y"><?php echo $option_years; ?></select>
 et <select name="sp-date-to" id="sp-date-to"><?php echo $option_jan_dec; ?></select><select name="sp-date-to-y" id="sp-date-to-y"><?php echo $option_years; ?></select>
<button id="btn_add_date">Ajouter</button>
</div>
<div id=sp-text>Contenant : <input type=text id="sp-text-i"><button id="btn_add_text">Ajouter</button></div>
</div>
<div id="searchlist"><legend>Liste des critères actifs</legend></div>
<div id="searchresult"><legend>Liste des <span id="searchresultnb"></span> résultats</legend><div id="searchresultbox"></div><div id="searchresultend"></div></div>
<?php
} //function advsearch
// Méthode qui affiche la recherche rapide
  public function quick_display() {
echo '<form name="quick_search" class="quick_search" method="POST" action="index.php?'.$this->url.'">
<input type="text" value="Entrez votre recherche..." name="q" onfocus="this.className=\'focus\';this.value=\'\';" onblur="this.className=\'\';this.value=\'Entrez votre recherche...\'">
</form>';
  } //function quick_display

  public function get_templates(){
    return array($this->ajax_return_tpl,$this->ajax_return_tpl_alt);
  } //function get_template
} //class advancedsearch
?>

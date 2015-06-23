<?php
// Recoit la requete AJAX et renvoie la liste des réponses en JSON
if(!defined('PLX_ROOT')) exit;
// http://brunchparisien.fr/ajax_advsearch&q=%5B%7B%22cat%22:%22sp-tags%22,%22labels%22:%5B%222%20cuill%C3%A8res%22,%22samedi%22,%22dimanche%22%5D,%22values%22:%5B%222%20cuill%C3%A8res%22,%22samedi%22,%22dimanche%22%5D%7D%5D
// %5B%7B%22cat%22:%22sp-tags%22,%22labels%22:%5B%222%20cuill%C3%A8res%22,%22samedi%22,null%5D,%22values%22:%5B%222%20cuill%C3%A8res%22,%22samedi%22,null%5D%7D,%7B%22cat%22:%22sp-cats%22,%22labels%22:%5B%22Brunch%22%5D,%22values%22:%5B%22001%22%5D%7D,%7B%22cat%22:%22sp-date%22,%22labels%22:%5B%22de%20Janvier%202013%20%C3%A0%20D%C3%A9cembre%202014%22%5D,%22values%22:%5B%22201301-201412%22%5D%7D,%7B%22cat%22:%22sp-text%22,%22labels%22:%5B%22albert%22%5D,%22values%22:%5B%22albert%22%5D%7D%5D
header("Cache-Control: no-cache");
header("Pragma: nocache");

$plxMotor = $this->plxMotor; //::getInstance();

$recherche = (isset($_REQUEST['q']))?json_decode($_REQUEST['q']):false;
//print_r($recherche);

if (!$recherche) return '';

$tpls = $plxMotor->plxPlugins->aPlugins['advancedsearch']->get_templates();
        $tpl_vignette = (strpos($tpls[0],"#art_vignette")!==false);
        $tpl_chapo = (strpos($tpls[0],"#art_chapo")!==false);

$results = array( array("tpl"=>$tpls[0]) );

// recherche dans les articles
	$plxGlob_arts = clone $plxMotor->plxGlob_arts;
	$motif = '/^[0-9]{4}.(?:[0-9]|home|,)*(?:'.$plxMotor->activeCats.'|home)(?:[0-9]|home|,)*.[0-9]{3}.[0-9]{12}.[a-z0-9-]+.xml$/';
	if($aFiles = $plxGlob_arts->query($motif,'art','rsort',0,false,'before')) {
		foreach($aFiles as $v) { # On parcourt tous les fichiers
			$art = $plxMotor->parseArticle(PLX_ROOT.$plxMotor->aConf['racine_articles'].$v);
			$tags = array_map("trim", explode(',', strtolower($art['tags'])));
			$searchstring = strtolower(plxUtils::strRevCheck($art['title'].$art['chapo'].$art['content']).$tags);
			$searchstring = plxUtils::unSlash($searchstring);
      $artmonth = substr($art["date"],0,6); //201411021906
			foreach($recherche as $recherche_et) {
			  if (!$recherche_et) continue;

        $searchok = false;
        foreach($recherche_et->values as $recherche_ou){
          if (!$recherche_ou) continue;
          switch(substr($recherche_et->cat,0,7)){
            case 'sp-tags':
                if (array_search( strtolower($recherche_ou) , $tags )!==false){
                  $searchok =true;
                  break 2; //exit foreach($recherche_et->values
                }
              break; // exit switch
            case 'sp-cats':
                if (strpos($art["categorie"],$recherche_ou) !== false){
                  $searchok =true;
                  break 2; //exit foreach($recherche_et->values
                }
              break; // exit switch
            case 'sp-date':
                $recherche_ou = explode("-",$recherche_ou);
                if ($recherche_ou[0] <= $artmonth and $recherche_ou[1] >= $artmonth){
                  $searchok =true;
                  break 2; //exit foreach($recherche_et->values        
                }
              break; // exit switch
            case 'sp-text':
                if (strpos($searchstring,strtolower($recherche_ou)) !== false){
                  $searchok =true;
                  break 2; //exit foreach($recherche_et->values
                }
              break; // exit switch
          } //switch($recherche_et->cat
        } //foreach($recherche_et->values

        // Si 1 param ET n'est pas valide => on sort, l'article n'est pas valide
        if (!$searchok)
          break; //exit foreach($recherche

			} //foreach($recherche
			if($searchok) {
//données de base
			  $line = array( "url"=>$plxMotor->urlRewrite('?article'.intval($art['numero']).'/'.$art['url']),
                            "title"=>plxUtils::strCheck($art['title']),
                            "date"=>plxDate::formatDate($art['date'], '#num_day/#num_month/#num_year(4)')
                      );
//ajout vignette seulement si nécessaire
			  if ($tpl_vignette){
  			  $vignette="";
  			  if (isset($art['vignette'])){
          $vignette = $art['vignette'];
          } else{
          // rechercher une image avec data-class="vignette"
            preg_match('`<img[^>]+data-class="vignette"[^>]+src="([^"]+)"|<img[^>]+src="([^"]+)"[^>]+data-class="vignette"`',$art['chapo'].$art['content'],$matches);
            if (isset($matches[1])){
              $vignette = empty($matches[2])?$matches[1]:$matches[2];
            }else{
          // prendre la premiere image du chapo ou de l'article
              preg_match('`<img[^>]+src="([^"]+)"`',$art['chapo'].$art['content'],$matches);
              if (isset($matches[1])){
                $vignette = $matches[1];
              }
            }
          }
          $line["vignette"] = $vignette;
          if (empty($vignette) && !empty($tpls[1])) $line["tpl"] = $tpls[1];
        }
//ajout chapo seulement si nécessaire
        if ($tpl_chapo){
          $line["chapo"] = $art['chapo'];
          if (empty($chapo) && !empty($tpls[1])) $line["tpl"] = $tpls[1];
        }
        $results[] = $line;
			}
		} //foreach($aFiles
	} //if($aFiles

//print_r($results);
echo json_encode($results);


exit();
?>
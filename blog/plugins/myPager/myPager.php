<?php
if (!defined('PLX_ROOT')) exit;

define('TABPAGER1', "\t\t\t\t");
define('TABPAGER2', "\t\t\t");

class myPager extends plxPlugin {

	private $usingShowArticlesHook = false;
	private $direct_page = false;
	private $articles_navigator = true;
	private $tag_cible = '';

	public function __construct($default_lang) {

		# appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);

		# droits pour accéder à la page config.php du plugin
		$this->setConfigProfil(PROFIL_ADMIN);

		$this->articles_navigator = (intval($this->getParam('articles_navigator')) > 0);

		// Pour le panneau de config
		$this->addHook('AdminTopEndHead', 'AdminTopEndHead');
		// Pour le mode public
		$this->addHook('plxShowPluginsCss', 'plxShowPluginsCss');
		// pour des pages de chapôs d'articles
		$this->addHook('plxShowPagination', 'plxShowPagination');
		// pour une page d'article, ajoute le navigateur d'articles
		if ($this->articles_navigator) {
			$this->addHook('IndexBegin', 'IndexBegin');
			$this->addHook('ThemeEndBody', 'ThemeEndBody');
			$this->addHook('showArticlesBar', 'showArticlesBar');
		}
	}

	// add css rules for config.php
	public function AdminTopEndHead($params) {
		global $plugin;

		if (($plugin == __CLASS__) and (basename($_SERVER['SCRIPT_NAME'], '.php') == 'parametres_plugin')) {
			define('MYFORM_ID', '#form_'.__CLASS__); // pour config.php ?>
	<style>
		<?php echo MYFORM_ID; ?> {width: 500px; padding: 2px; background-color: AliceBlue; border-radius: 10px; border: 1px solid LightSteelBlue;}
		<?php echo MYFORM_ID; ?> p {margin: 10px 5px;}
		<?php echo MYFORM_ID; ?> code {margin: 0.5em 1em; padding: 0.2em 1em; background-color: lightGray; color: Green; width: 100%; font-size: 10pt;}
		<?php echo MYFORM_ID; ?> label {display: inline-block; width: 300px; text-align: right; padding-right: 5px;}
	</style>
<?php
		}
	}

	// appelé par /themes/mon_theme/header.php
	public function plxShowPluginsCss($params) {
		global $plxMotor;

		switch ($plxMotor->mode) {
			case 'home' :
			case 'tags' :
			case 'archives' :
			case 'categorie' :
				if ($this->articles_navigator) { ?>
	<style type="text/css">
		#pagination a {display: inline-block; width: 2em; margin: 0 2px; line-height: 1.2em; text-decoration: none; color: Blue;		background-color: AliceBlue; border-radius: 10px; border: 1px solid LightSteelBlue; }
		#pagination a:hover {background-color: LightSkyBlue; color: Blue;}
		#pagination span {margin: 0 10px;}
		/* #pagination span:before, #pagination span:after {content: '...';} */
		#pagination a.activePage {background-color: RoyalBlue; color: White;}
	</style>
<?php				if ($this->direct_page) {
						$msgError = $this->getLang(L_MYPAGER_NUMBER_ERROR); ?>
	<script type="text/javascript">
		<!--
		function myPager(aForm) {
			var direct_pageInput = aForm.direct_page;
			var lastPageId = document.getElementById('last-page');
			var pattern = /^(.*page)(\d+)/;
			if (direct_pageInput && lastPageId) {
				var match1 = lastPageId.href.match(pattern);
				if (match1 && (match1.length == 3)) {
					var pageNu = parseInt(direct_pageInput.value);
					var lastPage = parseInt(match1[2]);
					if (/\d+/.test(pageNu) && (pageNu > 1) && (pageNu <= lastPage)) {
						document.location = match1[1] + pageNu;
					}
					else {
						direct_pageInput.focus();
						alert('<?php echo $msgError; ?>' + match1[2]);
					}
				}
			}
			else
				console.log('Input with direct_page name or node with "last-page" id not found');
			return false;
		}
		// -->
	</script>
<?php				}
				}
				break;
			case 'article' : ?>
	<style type="text/css">
		#articlesNavigator {padding: 2px; background-color: GhostWhite; border: 1px solid LightSteelBlue; text-align: center;}
		#articlesNavigator a {display: inline-block; width: 2em; margin: 0 2px; line-height: 1.2em; text-decoration: none; color: Blue;		background-color: AliceBlue; border-radius: 10px; border: 1px solid LightSteelBlue; }
		#articlesNavigator a:hover {background-color: LightSkyBlue; color: Blue;}
		#articlesNavigator select {margin: 0 0.4em; width: 250px;}
		#articlesNavigator span {font-style : italic;}
	</style>
	<script type="text/javascript">
		function callArticle(filename) {
			document.location = filename;
			return false;
		}
	</script>
<?php
				break;
		}
	}

	private function urlPage($numero) {
		global $plxMotor;

		$result = $plxMotor->get;
		if ($result) { // On vient d'une page autre que celle de l'accueil index.php
			if (preg_match('/(\/?page[0-9]+)$/', $result, $matches))
				$result  = str_replace($matches[1], '', $result);
			if ($numero > 1) {
				if (strlen($result) > 0)
					 // Affichage d'une partie des articles selon que mode est dans (categorie, tags, archives)
					$result .= '/page';
				else
					// Affichage de tous les articles
					$result = 'page';
				$result .= $numero;
			}
		}
		elseif ($numero > 1)
			$result = 'page'.$numero;
		if ($result)
			// On affiche autre chose que la page d'accueil index.php
			$result = '?'.$result;
		return $plxMotor->urlRewrite($result);
	}

	// display buttons for selecting page at home page and so on
	public function plxShowPagination($params) {
		// appelé par home.php, categorie.php, tags.php, archives.php dans /themes/mon_theme/ via $plxShow->pagination()
		global $plxMotor;

		define('ACTIVE_PAGE', ' class="activePage"');

		$n = intval($this->getParam('delta'));
		$delta = ($n > 1) ? $n : 3; // nbre de boutons supplémentaires de chaque côté du bouton central en dehors des 2 boutons extrêmes
		$byPage = $plxMotor->bypage;
		$articlesCount = $plxMotor->plxGlob_arts->count;
		$totalPages = ceil($articlesCount / $byPage);

		$pageCC = $plxMotor->page;
		$code = '';
		if ($totalPages > 1) {
			$code = (intval($this->getParam('display_page')) > 0) ? $this->lang('L_MYPAGER_PAGE') : '';
			$active = ($pageCC == 1) ? ACTIVE_PAGE : '';
			$n = intval($this->getParam('buttons'));
			if ($pageCC > 1) {
				$prevPage = $pageCC - 1;
				$onclick = '';
			}
			else {
				$prevPage = 1;
				$onclick = ' onclick="alert(\''.$this->getLang('L_MYPAGER_FIRST_PAGE').'\'); return false;"';
			}
			$buttons = (intval($this->getParam('buttons')) > 0);
			if ($buttons)
				$code .= '<a href="'.$this->urlPage(1).'"'.$active.$onclick.'>&lt;&lt;</a>'; // page n°1
			$code .= '<a href="'.$this->urlPage($prevPage).'"'.$onclick.'>&lt;</a>'; // recule d'une page
			$code .= '<a href="'.$this->urlPage(1).'"'.$active.'>1</a>'."\n"; // page n°1
			if ($totalPages > 2) { // pages intermédiaires
				$code .= TABPAGER1.'<span>';
				// ------ début boutons centraux
				if ($pageCC < 2 + $delta) {
					$iMin = 2;
					$iMax = ($totalPages > 2 * $delta + 3) ? $iMin + 2 * $delta + 1 : $totalPages;
				}
				elseif ($pageCC > $totalPages - $delta - 1) {
					$iMax = $totalPages ;
					$iMin = ($iMax > 2 * $delta + 2) ? $iMax - 2 * $delta - 1: 2;
				}
				else {
					$iMax = $pageCC + $delta + 1;
					$iMin = $pageCC - $delta;
				}
				for ($i = $iMin; $i < $iMax; $i++) {
					$active = ($pageCC == $i) ? ACTIVE_PAGE : '';
				$code .= '<a href="'.$this->urlPage($i).'"'.$active.'>'.$i.'</a>';
				}
				// ------ fin boutons centraux
				$code .= '</span>'."\n";
			}
			$active = ($pageCC == $totalPages) ? ACTIVE_PAGE : '';
			// Mark the last page link for retrieving url to direct access at any page except page #1
			$code .= TABPAGER1.'<a id="last-page" href="'.$this->urlPage($totalPages).'"'.$active.'>'.$totalPages.'</a>'; // last page
			if ($pageCC < $totalPages - 1) {
				$nextPage = $pageCC + 1;
				$onclick = '';
			}
			else {
				$nextPage = $totalPages;
				$onclick = ' onclick="alert(\''.$this->getLang('L_MYPAGER_LAST_PAGE').'\'); return false;"';
			}
			$code .= '<a href="'.$this->urlPage($nextPage).'"'.$onclick.'>&gt;</a>'; // one page forward
			if ($buttons) // somebody request a ">>" button to direct access at the last page
				$code .= '<a href="'.$this->urlPage($totalPages).'"'.$active.$onclick.'>&gt;&gt;</a>'; // last page
			$code .= "\n";
			if ($this->direct_page) {
				$code .=
					TABPAGER1.'<form onsubmit="return myPager(this);">'."\n\t".
					TABPAGER1.'<label for="id_direct_page">'.$this->getLang('L_MYPAGER_DIRECT_PAGE_LABEL').'</label>'."\n\t".
					TABPAGER1.'<input id="id_direct_page" name="direct_page" size="2" maxlength="3" />'."\n\t".
					TABPAGER1.'<input type="submit" value="Ok" />'."\n".
					TABPAGER1."</form>\n";
			}
		}
		$code .= '<?php return true; ?>';
		echo $code;
	}

	/*****************************************************************************************************/
	/* The following functions are used to display a navigator for articles when an article is displayed */
	/*****************************************************************************************************/

	// When displaying chapôs in home page, store the mode and the cible for the future
	public function IndexBegin($params) {
		global $plxMotor;

		if (in_array($plxMotor->mode, array('categorie', 'tags', 'home', 'archives'))) {
			$_SESSION['myPagerMode'] = $plxMotor->mode;
			$_SESSION['myPagerCible'] = ($plxMotor->mode == 'tags') ? $plxMotor->cibleName : $plxMotor->cible;
		}
	}

	// stop playing! Retrieve mode and cible and catch the right articles.
	private function filter_tags($element) {
		return (preg_match('/\b('.$this->tag_cible.')\b/i', $element['tags']) > 0);
	}

	protected function getArticles() {
		global $plxShow, $aTag;

		$mode = $_SESSION['myPagerMode'];
		$cible = $_SESSION['myPagerCible'];
		if ($mode != 'categorie')
			$activeCats = '('.str_replace('|', '|,?', $plxShow->plxMotor->activeCats).')';
		// motif come from plxMotor->prechauffage()
		// http://pluxopolis.net/article10/pluxml-comprendre-le-nom-des-fichiers-xml-des-articles
		switch ($mode) {
			case 'categorie' :
				$caption = $plxShow->getLang('CATEGORIES').' : '.$plxShow->plxMotor->aCats[$cible]['name'];
				// $motif = '/^[0-9]{4}.(?:[0-9]|home|,)*(?:'.$cible.')(?:[0-9]|home|,)*.[0-9]{3}.[0-9]{12}.[a-z0-9-]+.xml$/';
				$motif = '/(^\d{4})\.((,?home|,?\d{3})*,?'.$cible.'(,?home|,?\d{3})*)\.(\d{3})\.(\d{12})\.([\w-]+)\.xml$/i';
				break;
			case 'tags' :
				$caption = $plxShow->getLang('TAGS').' : '.$cible;
				if (false and (version_compare(phpversion(), '5.3') >= 0)) {
					// requires phpversion >= 5.3
					// $myCallback = function($element) use($cible) { return (preg_match('/\b('.$cible.')\b/i', $element['tags']) > 0); };
					// $articlesId = array_keys(array_filter($plxShow->plxMotor->aTags, $myCallback));
				}
				else {
					$this->tag_cible = $cible;
					$articlesId = array_keys(array_filter($plxShow->plxMotor->aTags, array(__CLASS__, 'filter_tags')));
				}
				$motif = '/('.implode('|', $articlesId).')\.('.$activeCats.'+)\.\d{3}\.\d{12}\.([\w-]+)\.xml$/i';
				break;
			case 'archives' :
				$caption = plxDate::formatDate($cible, $plxShow->getLang('ARCHIVES').' : #month #num_year(4)');
				//$motif = '/^[0-9]{4}.(?:[0-9]|home|,)*(?:'.$this->activeCats.'|home)(?:[0-9]|home|,)*.[0-9]{3}.'.$search.'[0-9]{4}.[a-z0-9-]+.xml$/';
				$motif = '/(^\d{4})\.('.$activeCats.'+)\.(\d{3})\.('.$cible.'\d{6})\.([\w-]+)\.xml$/i';
				break;
			case 'author' : // not use
				$caption = 'author';
				$motif = '/(^\d{4})\.('.$activeCats.'+)\.'.$cible.'\.(\d{12})\.([\w-]+)\.xml$/i';
				break;
			case 'home' : // not using
				$caption = '';
				$motif = '/(^\d{4})\.('.$activeCats.'+)\.(\d{3})\.(\d{12})\.([\w-]+)\.xml$/i';
				break;
			default :
				$caption = '';
				$motif = false;
				break;
		}
		if ($motif)
			$articles = $plxShow->plxMotor->plxGlob_arts->query($motif , 'art');
		else
			$articles = false;
		return array($articles, $caption);
	}

	private function urlArticle($filename) {
		global $plxMotor;

		$n = preg_match('/^(\d{4})\..*\.([\w-]+)\.xml$/i', $filename, $matches);
		$id = intval($matches[1]);
		$url = $matches[2];
		$result = $plxMotor->urlRewrite('?article'.$id.'/'.$url);
		return $result;
	}

	private function getArticle($filename) {
		global $plxMotor;

		return $article = $plxMotor->parseArticle(PLX_ROOT.$plxMotor->aConf['racine_articles'].$filename);
	}

	private function buildLinkArticle($filename, $caption=false) {
		$article = $this->getArticle($filename);
		$n = ($caption === false) ? '' : $caption;
		return '<a href="'.$this->urlArticle($filename).'" title="'.$article['title'].'">'.$n.'</a>'."\n";
	}

	// build the user interface after catching the right articles with getArticles() function
	private function articlesNavigator() {
		global $plxShow;

		if ($plxShow->mode() == 'article') {
			list($articles, $caption) = $this->getArticles();
			$articlesCount = count($articles);
			$values = array_values($articles);
			// build a select list
			$buf = TABPAGER2.'<select onchange="return callArticle(this.value);">'."\n";
			$n = false;
			for ($i = 0; $i<count($values); $i++) {
				$v = $values[$i];
				if (substr($v, 0, 4) == $plxShow->plxMotor->cible) {
					$n = $i;
					$selected = ' selected';
				}
				else
					$selected = '';
				$article = $this->getArticle($v);
				$buf .= TABPAGER2."\t".'<option value="'.$this->urlArticle($v).'"'.$selected.'>'.$article['title'].'</option>'."\n";
			}
			$buf .= TABPAGER2."</select>\n";
			// So, merge buttons and select list
			$code = '';
			$code .= TABPAGER2.$caption.' (<span>'.$articlesCount.' articles</span>) : '."\n";
			// Firstly, 2 buttons
			$v = $values[0];
			$code .= TABPAGER2.$this->buildLinkArticle($v, '&lt;&lt;');
			if ($n !== false) {
				$m = ($n > 0) ? $n-1 : 0;
				$v = $values[$m];
				$code .= TABPAGER2.$this->buildLinkArticle($v, '&lt;');
			}
			// Now, the select list
			$code .= $buf;
			// Lastly, 2 more buttons
			if ($n !== false) {
				$m = ($n < count($values) - 1)? $n + 1 : count($values) - 1;
				$v = $values[$m];
				$code .= TABPAGER2.$this->buildLinkArticle($v, '&gt;');
			}
			$v = $values[count($values)-1];
			$code .= TABPAGER2.$this->buildLinkArticle($v, '&gt;&gt;');
		}
		else
			$code = '';
		return $code;
	}

	// What do we do , display at the bottom of the page or wait for the showArticlesBar hook
	public function ThemeEndBody($params) {
		global $plxShow;

		if (!$this->usingShowArticlesHook and ($plxShow->mode() == 'article')) { ?>
	<style type="text/css">
		#bottomNavBar {position: fixed; left: 50px; right: 50px; bottom: 5px; padding: 0 40px; margin:0;}
		#articlesNavigator {width: 65%; margin: 0;}
	</style>
	<div id="bottomNavBar">
		<p id="articlesNavigator">
<?php echo $this->articlesNavigator(); ?>
		</p>
	</div>
<?php
		}

	}

	public function showArticlesBar($params) {
		$this->usingShowArticlesHook = true;
		echo "\t\t\t".'<p id="articlesNavigator">'."\n".$this->articlesNavigator()."\t\t\t</p>\n";
	}

}
?>

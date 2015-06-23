<?php

if(!defined('PLX_ROOT')) exit;

/*
 * Plugin pour CodeMirror
 * http://codemirror.net/
 * */

class codemirror extends plxPlugin {

	public $lib; // used by config.php
	private $script_name;
	private $stylesheets = array('display/fullscreen', 'fold/foldgutter', 'hint/show-hint', 'dialog/dialog');
	private $modes = array('xml', 'javascript', 'css', 'htmlmixed', 'markdown', 'clike', 'php');
	private $addons = array(
		false=>array(
			'edit/matchbrackets', 'edit/matchtags', 'edit/closebrackets', 'edit/closetag', 'display/fullscreen',
			'fold/foldcode', 'fold/foldgutter', 'fold/xml-fold', 'fold/comment-fold', 'fold/markdown-fold',
			'dialog/dialog', 'selection/active-line.js', 'search/searchcursor.js', 'search/search.js',
			'hint/show-hint', 'hint/css-hint', 'hint/html-hint', 'hint/javascript-hint', 'hint/xml-hint'
			),
		true=>array('runmode/runmode'));

	public function __construct($default_lang) {
		# appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);

		# droits pour accéder à la page config.php du plugin
		$this->setConfigProfil(PROFIL_ADMIN);

		$this->lib = PLX_PLUGINS.__CLASS__.'/codemirror';
		$this->script_name = basename(strtolower($_SERVER['SCRIPT_NAME']),'.php');
		$this->addHook('AdminTopEndHead', 'AdminTopEndHead');
		$this->addHook('AdminSettingsEdittplTop', 'AdminSettingsEdittplTop');
		$this->addHook('AdminSettingsEdittplFoot', 'AdminArticleFoot');
		$this->addHook('AdminArticleFoot', 'AdminArticleFoot');
		$this->addHook('AdminStaticFoot', 'AdminArticleFoot');
		$this->addHook('plxShowPluginsCss', 'plxShowPluginsCss');
		$this->addHook('ThemeEndBody', 'ThemeEndBody');
		}

	private function themes() {
		$result = array();
		foreach (scandir($this->lib.'/theme') as $fn)
			if (substr($fn, -4) == '.css')
				array_push($result, substr($fn, 0, -4));
		return $result;
	}

	public function printMinifyJS_Code_urls() {
		define('URL_BASE', 'http://codemirror.net/');
		$value = URL_BASE.'lib/codemirror.js'; ?>
		<input type="hidden" name="code_url" value="<?php echo $value; ?>" />
<?php
		foreach ($this->modes as $mode) {
			$value = URL_BASE.'mode/'.$mode.'/'.$mode.'.js'; ?>
		<input type="hidden" name="code_url" value="<?php echo $value; ?>" />
<?php	}
		foreach ($this->addons as $k=>$v) {
			foreach ($v as $f=>$w) {
				$value = URL_BASE.'addon/'.$w.'.js'; ?>
		<input type="hidden" name="code_url" value="<?php echo $value; ?>" />
<?php		}
		}
	}

	public function printSelectThemes($onchange='', $name='theme') {

		$onChange1 = (!empty($onchange)) ? ' onchange="'.$onchange.'"' : '';
?>
			<select id="id_<?php echo $name; ?>" name="<?php echo $name; ?>"<?php echo($onChange1); ?>>
				<option value="">default</option>
<?php
	$theme = $this->getParam('theme');
	foreach($this->themes() as $t) {
		$selected = ($t == $theme) ? ' selected' : ''; ?>
				<option value="<?php echo $t; ?>"<?php echo $selected; ?>><?php echo ucfirst($t); ?></option>
<?php } ?>
			</select>
<?php
	}

	public function print_demo_url() {
		return $this->lib.'/demo/theme.html';
	}

	private function setContext($colorize=false) {
		$theme = $this->getParam('theme');
		// $minifyJS = (empty()) ? false : $this->getParam('minify_js');
		$minifyJS = $this->getParam('minify_js');
?>
	<link rel="stylesheet" href="<?php echo $this->lib; ?>/lib/codemirror.css" />
<?php	if (!empty($theme)) {
			$href = $this->lib.'/theme/'.$theme.'.css'; ?>
	<link rel="stylesheet" href="<?php echo $href; ?>" />
<?php }
		foreach ($this->stylesheets as $sheet) {?>
	<link rel="stylesheet" href="<?php echo $this->lib.'/addon/'.$sheet.'.css'; ?>" />
<?php	} ?>
	<link rel="stylesheet" href="<?php echo PLX_PLUGINS.__CLASS__.'/'.__CLASS__; ?>.css" />
<?php
		if ($minifyJS) { ?>
	<script src="<?php echo $this->lib; ?>/codemirror.min.js" type="text/javascript"></script>
<?php		}
		else { // load each js file one after one ?>
	<script src="<?php echo $this->lib; ?>/lib/codemirror.js" type="text/javascript"></script>
<?php
			foreach ($this->modes as $m) { ?>
	<script src="<?php echo $this->lib.'/mode/'.$m.'/'.$m; ?>.js" type="text/javascript"></script>
<?php
			}
			foreach($this->addons[$colorize] as $a) { ?>
	<script src="<?php echo $this->lib.'/addon/'.$a; ?>.js" type="text/javascript"></script>
<?php
			}
		}
?>
	<script src="<?php echo PLX_PLUGINS.__CLASS__.'/'.__CLASS__; ?>.js" type="text/javascript"></script>
<?php

	}

	public function AdminTopEndHead() {
		global $plugin;

		switch ($this->script_name) {
			case 'parametres_plugin' :
				if ($plugin == __CLASS__) { ?>
	<link rel="stylesheet" href="<?php echo PLX_PLUGINS.__CLASS__.'/'.__CLASS__; ?>.css" />
	<script src="<?php echo PLX_PLUGINS.__CLASS__.'/'.__CLASS__; ?>.js" type="text/javascript"></script>
<?php			}
				break;
			case 'parametres_pluginhelp' :
			if ($plugin == __CLASS__) { ?>
	<link rel="stylesheet" href="<?php echo PLX_PLUGINS.__CLASS__.'/'.__CLASS__; ?>.css" />
<?php		}
				break;
			case 'parametres_edittpl' :
			case 'article' :
			case 'statique' :
				$param = $this->script_name;
				// $value = (!empty($this->getparam($param))) ? $this->getparam($param) : false;
				$value = intval($this->getparam($param));
				if ($value == 1)
					$this->setContext();
				break;
		}
	}

	public function AdminSettingsEdittplTop() { ?>
	<p style="text-align: right; margin: 5px 0;">
		<input type="button" id="fullscreen" value="<?php echo $this->lang('L_'.strtoupper(__CLASS__).'_FULLSCREEN'); ?>" title=" Dans l'éditeur, tapez F11 ou Esc. " />
		<i><?php echo $this->lang('L_'.strtoupper(__CLASS__).'_COMPLETION'); ?></i>
	</p>
<?php
	}

	// we wish to use Codemirror for writing article, static page and template
	public function AdminArticleFoot() {
		$param = $this->script_name;
		// $value = (!empty($this->getparam($param))) ? $this->getparam($param) : false;
		$value = $this->getparam($param);
		if ($value) { ?>
	<script type="text/javascript">
		<!--
		activeEditor('<?php echo $this->getParam('theme'); ?>', <?php echo ($this->getParam('lineNumbers') == 1) ? 'true' : 'false'; ?>);
		// -->
	</script>
<?php
		}
	}

	public function plxShowPluginsCss() {
		if ($this->getParam('show') == '1')
			$this->setContext(true);
	}

	public function ThemeEndBody() {
		if ($this->getParam('show') == '1') { ?>
	<script type="text/javascript">
		<!-- // default mode is not defined in standard
		// console.log(CodeMirror.version);
		CodeMirror.defaults.theme = '<?php echo $this->getParam('theme'); ?>';
		CodeMirror.colorize(null, 'htmlmixed');
		// -->
	</script>
<?php
		}
	}

}
?>

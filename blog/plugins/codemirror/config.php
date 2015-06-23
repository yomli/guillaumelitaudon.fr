<?php
if (!defined('PLX_ROOT')) exit;

# Control du token du formulaire
plxToken::validateFormToken($_POST);

$params = array(
	'theme'=>'string', 'lineNumbers'=>'boolean', 'article'=>'boolean',
	'statique'=>'boolean', 'parametres_edittpl'=>'boolean', 'show'=>'boolean', 'minify_js'=>'boolean');
$params_default = array('lineNumbers'=>1, 'parametres_edittpl'=>1);

if (!empty($_POST)) {
	foreach ($params as $field=>$type) {
		switch ($type) {
			case 'boolean' :
				$value = (isset($_POST[$field])) ? 1 : 0;
				$plxPlugin->setParam($field, $value, 'numeric');
				break;
			default :
				$value = (isset($_POST[$field])) ? $_POST[$field] : '';
				$plxPlugin->setParam($field, $value, $type);
				break;
		}
	}
	$plxPlugin->saveParams();
}
?>
	<h2><?php echo(L_PLUGINS_CONFIG.': '.$plxPlugin->getInfo('title')); ?></h2>
	<p><i><?php echo $plxPlugin->getInfo('description'); ?></i></p>
	<form id="form_<?php echo $plxPlugin->getInfo('title'); ?>" method="post">
		<p>
<?php
foreach ($params as $field=>$type) {
	$value = $plxPlugin->getParam($field);
	if (!empty($value))
		$value = plxUtils::strCheck($value);
	else
		$value = (array_key_exists($field, $plxPlugin->default_values)) ? $plxPlugin->default_values[$field] : '';
	$asterisk = ($field == 'show') ? '<sup>*</sup>' : '';
?>
			<label for="id_<?php echo $field; ?>"><?php $plxPlugin->lang('L_'.strtoupper($plugin).'_'.strtoupper($field)); echo $asterisk; ?></label>
<?php
		switch ($type) {
			case 'boolean' :
				$checked = ($value) ? ' checked' : '';
?>
			<input id="id_<?php echo $field; ?>" type="checkbox" name="<?php echo $field; ?>" value="1"<?php echo $checked; ?> />
<?php
				break;
			default :
				switch ($field) {
					case 'theme' : ?>
<?php $plxPlugin->printSelectThemes(); ?>
			<input type="button" value="<?php $plxPlugin->lang('L_'.strtoupper($plugin).'_SHOW_ME'); ?>" onclick="return demo_open('<?php echo $plxPlugin->print_demo_url(); ?>');">
<?php
						break;
					default : ?>
		<?php plxUtils::printInput($field, $value, 'text', '5-10', false, $class1);
						break;
				}
				break;
		}
?>		</p><p>
<?php
}
?>
			<sup>*</sup> <?php echo $plxPlugin->lang('L_'.strtoupper($plugin).'_COMMENT'); ?>
		</p><p>
			<label>&nbsp;</label>
			<?php echo plxToken::getTokenPostMethod(); ?>
			<input type="submit">
		</p><p>
			<a href="<?php echo $plxPlugin->lib.'/doc/manual.html';?>" target="_blank">Read the manual here</a>
			<a href="<?php echo $plxPlugin->lib.'/doc/compress.html';?>" target="_blank">Compress modes and addons here</a>
		</p>
		<h3>Examples from Codemirror & modes</h3>
		<p>
<?php
$folder = $plxPlugin->lib.'/demo';
$demos = array();
foreach (scandir($folder) as $filename) {
	if (substr($filename, -5) == '.html')
		array_push($demos, $filename);
}
sort($demos);
foreach ($demos as $d) {
	$caption = substr($d, 0, -5);
	if (strlen($caption) > 16)
		$caption = substr($caption, 0, 15).'.'; ?>
			<a href="<?php echo $folder.'/'.$d; ?>" target="_blank"><?php echo ucfirst($caption); ?></a>
<?php
}
?>
			<a href="<?php echo $plxPlugin->lib.'/mode/'; ?>" target="_blank">Modes</a>
		</p>
	</form>
	<form id="form_<?php echo $plxPlugin->getInfo('title'); ?>_download" action="http://marijnhaverbeke.nl/uglifyjs" method="post" target="_blank">
		<input type="hidden" name="download" value="codemirror.min.js" />
<?php $plxPlugin->printMinifyJS_Code_urls(); ?>
		<input type="submit" value="<?php $plxPlugin->lang('L_'.strtoupper($plugin).'_DOWNLOAD'); ?>"/>
	</form>

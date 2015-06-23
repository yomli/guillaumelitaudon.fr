<?php

if (!defined('PLX_ROOT')) exit;

# Control du token du formulaire
plxToken::validateFormToken($_POST);

$fields = array('delta'=>'numeric', 'buttons'=>'boolean', 'display_page'=>'boolean', 'direct_page'=>'boolean', 'articles_navigator'=>'boolean');
$default_values = array('delta'=>3, 'buttons'=>0, 'display_page'=>1, 'direct_page'=>0, 'articles_navigator'=>1);

if (!empty($_POST)) {
	// Saving parameters
	foreach ($fields as $field=>$type) {
		switch ($type) {
			case 'numeric' :
				$value = (!empty($_POST[$field])) ? intval($_POST[$field]) : '';
				if (($field == 'delta') and ($value > 10))
					$value = 10;
				break;
			case 'boolean' :
				$value = (isset($_POST[$field])) ? 1 : 0;
				break;
			default :
				$value = (!empty($_POST[$field])) ? $_POST[$field] : '';
				break;
		}
		if (!isset($value) and in_array($field, array_keys($default_values)))
			$value = $default_values[$field];
		$plxPlugin->setParam($field, $value, ($type == 'boolean') ? 'numeric' : $type);
	}
	$plxPlugin->saveParams();
}
?>

		<h2><?php echo($plxPlugin->getInfo('title')); ?></h2>
		<form id="form_<?php echo $plugin; ?>" method="post">
			<p>
<?php
foreach ($fields as $field=>$type) {
	$value = $plxPlugin->getParam($field);
	if ((strlen($value) == 0) && array_key_exists($field, $default_values))
		$value = $default_values[$field]; ?>
				<label for="id_<?php echo $field; ?>"><?php $plxPlugin->lang('L_'.strtoupper($plugin.'_'.$field)); ?></label>
<?php
	switch ($type) {
		case 'numeric' : ?>
				<?php plxUtils::printInput($field, $value, 'text', '1-2');
			break;
		case 'boolean' :
				$checked = ($value) ? ' checked' : '' ?>
				<input id="id_<?php echo $field; ?>" type="checkbox" name="<?php echo $field; ?>" value="1"<?php echo $checked; ?> />
<?php
			break;
		default :
			$size =  (!empty($field_sizes[$field])) ? $field_sizes[$field] : '20-50'; ?>
				<?php plxUtils::printInput($field, $value, 'text', $size);
			break;
	} ?>
			</p><p>
<?php
}
?>
				<?php $plxPlugin->lang('L_'.strtoupper($plugin.'_info')); echo "\n"; ?>
			</p><p>
				<?php echo plxToken::getTokenPostMethod(); echo "\n"; ?>
				<label>&nbsp;</label>
				<input type="submit" />
			</p>
		</form>

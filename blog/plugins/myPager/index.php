<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>Test pagination</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<style>
		body {width: 800px; margin: 25px; padding: 10px; background-color: LightGray;}
		div {background-color: PapayaWhip; border: 1px solid black; border-radius: 10px; padding-bottom: 10px;}
		h1, p { text-align: center; }
		p a {
			display: inline-block;
			width: 2em;
			margin: 1px;
			padding: 5px 0;
			background-color: AliceBlue;
			border-radius: 10px;
			border: 1px solid LightSteelBlue;
			text-decoration: none;
		}
		p span {margin: 0 10px;}
		a.active {background-color: Blue; color: White;}
		form label {
			display: inline-block;
			width: 400px;
			text-align: right;
			margin-right: 5px;
			line-height: 2em;
		}
		form input[type=text] {text-align: right;}
	</style>
	<script type="text/javascript">
		function page(aValue) {
			var page = document.getElementById('id_choix');
			page.value = aValue;
			var form1 = document.getElementById('form1');
			form1.submit();
			return false;
		}
		function avance(aPas) {
			var page = document.getElementById('id_choix');
			var n = parseInt(page.value);
			n += parseInt(aPas);
			page.value = n;
			var form1 = document.getElementById('form1');
			form1.submit();
			return false;
		}
	</script>
</head>
<body><div>
	<h1>Test Pagination</h1>
	<p>
<?php
	$pageCC = (!empty($_GET['choix'])) ? intval($_GET['choix']) : 1;
	$totalPages =  (!empty($_GET['dernier'])) ? intval($_GET['dernier']) : 1;
	if ($totalPages < 1)
		$totalPages = 1;
	$delta = (!empty($_GET['delta'])) ? intval($_GET['delta']) : 3;
	if ($delta < 1)
		$delta = 1;
	elseif ($delta > 10)
		$delta = 10;
	if ($pageCC > $totalPages)
		$pageCC = $totalPages;
	if ($pageCC < 0)
		$pageCC = 0;
	if ($totalPages > 1) {
		$active = ($pageCC == 1) ? ' class="active"' : ''; ?>
		<a href="#" onclick="return avance(-1);">&lt;</a>
		<a href="#"<?php echo $active; ?> onclick="return page(1);">1</a>
<?php
		if ($totalPages > 2) { ?>
		<span>
<?php
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
				$active = ($pageCC == $i) ? ' class="active"' : ''; ?>
			<a href="#"<?php echo $active; ?> onclick="return page(<?php echo $i; ?>);"><?php echo $i; ?></a>
<?php		} ?>
		</span>
<?php }
		$active = ($pageCC == $totalPages) ? ' class="active"' : ''; ?>
		<a href="#"<?php echo $active; ?> onclick="return page(<?php echo $totalPages; ?>);"><?php echo $totalPages; ?></a>
		<a href="#" onclick="return avance(1);">&gt;</a>
<?php
	}
	else
		echo '&nbsp;';
?>
	</p>
	<form id="form1">
		<input id="id_choix" type="hidden" name="choix" value="<?php echo $pageCC; ?>" size="2" maxlength="2"/><br>
		<label for="id_dernier">Saut de pages (<i>entre 1 et 10</i>)</label>
		<input id="id_delta" type="text" name="delta" value="<?php echo $delta; ?>"  size="2" maxlength="2" /><br>
		<label for="id_dernier">Nombre total de pages</label>
		<input id="id_dernier" type="text" name="dernier" value="<?php echo $totalPages; ?>"  size="2" maxlength="2" /><br>
		<label>&nbsp;</label>
		<input type="submit" />
	</form>
</div></body></html>

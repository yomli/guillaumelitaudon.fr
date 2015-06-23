<?php if (!defined('PLX_ROOT')) exit; 
/****************************************************
*
* @File: 		header.php
* @Package:		PluXML
* @Action:		YomliBlog theme for PluXML CMS
*
*****************************************************/
?>
<!DOCTYPE html>
<html lang="<?php $plxShow->defaultLang() ?>">
<head>

	<meta charset="<?php $plxShow->charset('min'); ?>">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0">

	<title><?php $plxShow->pageTitle(); ?></title>
	<?php $plxShow->meta('description') ?>
	<?php $plxShow->meta('keywords') ?>
	<?php $plxShow->meta('author') ?>

	<link rel="icon" href="<?php $plxShow->template(); ?>/img/favicon.ico" />
	<link rel="apple-touch-icon" href="<?php $plxShow->template(); ?>/img/apple-touch-icon.png" />

	<link rel="stylesheet" href="<?php $plxShow->template(); ?>/css/main.min.css" />
	<link rel="stylesheet" href="<?php $plxShow->template(); ?>/css/style.css" />
	<link  rel="stylesheet" href="<?php $plxShow->template(); ?>/css/tomorrow-night.css" />

	<link rel="alternate" type="application/rss+xml" title="<?php $plxShow->lang('ARTICLES_RSS_FEEDS') ?>" href="<?php $plxShow->urlRewrite('feed.php?rss') ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php $plxShow->lang('COMMENTS_RSS_FEEDS') ?>" href="<?php $plxShow->urlRewrite('feed.php?rss/commentaires') ?>" />
	
	<!--[if lte IE 8]>
		<script src="<?php $plxShow->template(); ?>/js/html5shiv.js"></script>
		<script src="<?php $plxShow->template(); ?>/js/selectivizr-min.js"></script>
	<![endif]-->

</head>

<body id="top" class="default">

	<header role="banner" id="header">

		<h1>
			<?php $plxShow->mainTitle('link'); ?>
		</h1>
		<a href="#nav" class="icon nav fa-bars">  &nbsp;Menu</a>
	</header>

		<nav role="navigation" id="nav">
			<ul class="links">
				<?php $plxShow->staticList($plxShow->getLang('HOME'),'<li id="#static_id"><a href="#static_url" class="#static_status" title="#static_name">#static_name</a></li>'); ?>
				<?php $plxShow->pageBlog('<li id="#page_id"><a class="#page_status" href="#page_url" title="#page_name">#page_name</a></li>'); ?>
				<li><?php eval($plxShow->callHook('quick_display')); ?></li>
			</ul>
		</nav>



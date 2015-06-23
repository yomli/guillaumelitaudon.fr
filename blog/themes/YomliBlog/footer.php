<?php if (!defined('PLX_ROOT')) exit; 
/****************************************************
*
* @File: 		footer.php
* @Package:		PluXML
* @Action:		YomliBlog theme for PluXML CMS
*
*****************************************************/
?>

<div class="relative">
	<div class="widget toTop">
		<a href="<?php $plxShow->urlRewrite('#top') ?>" title="<?php $plxShow->lang('GOTO_TOP') ?>" class="icon fa-chevron-up">
			<span class="label"><?php $plxShow->lang('TOP') ?></span>
		</a>
	</div>
</div>

<footer role="contentinfo" id="footer">

	<div class="container">
		<div class="row double">

			<!-- Sponsors -->
			<div class="3u 6u$(small)">
				<section class="widget links sponsors">
					<h3><?php $plxShow->lang('W3C') ?></h3>
					<ul class="alt-noborder">
						<li><img src="<?php $plxShow->template(); ?>/img/htmlcss.svg" alt="HTML5 CSS3" /></li>
					</ul>
				</section>
			</div>

			<!-- Sponsors -->
			<div class="3u 6u$(small)">
				<section class="widget links sponsors">
					<h3><?php $plxShow->lang('HOSTED') ?></h3>
					<ul class="alt-noborder">
						<li><a href="#"><img src="<?php $plxShow->template(); ?>/img/yomli.svg" alt="Lorem Ipsum" /></a></li>
					</ul>
				</section>
			</div>

			<!-- Links -->
			<div class="3u 12u$(small)">
				<section class="widget links">
					<h3><?php $plxShow->lang('LINKS') ?></h3>
					<ul class="alt-noborder">
						<li><a href="<?php $plxShow->urlRewrite('#top') ?>" title="<?php $plxShow->lang('GOTO_TOP') ?>" class="icon fa-chevron-up"> <?php $plxShow->lang('TOP') ?></a></li>
						<li><b class="icon my-fa-rss"> <?php $plxShow->artFeed(); ?></b></li>
					</ul>
				</section>
			</div>

			<!-- Contact -->
			<div class="3u 12u$(small)">
				<section class="widget contact last">
					<h3><?php $plxShow->lang('CONTACT') ?></h3>
					<ul class="alt-noborder">
						<li><a href="https://twitter.com/username" class="icon my-fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="https://github.com/username" class="icon fa-github"><span class="label">GitHub</span></a></li>
						<li><a href="skype:username" class="icon fa-skype"><span class="label">Skype</span></a></li>
						<li><a href="mailto:username" class="icon fa-envelope"><span class="label">Email</span></a></li>
					</ul>
				</section>
			</div>
		</div>
	</div>

	<!-- Copyright -->
	<div class="copyright">
		<span class="icon fa-beer" title="<?php $plxShow->lang('LICENSE') ?>"> <?php echo date('Y'); ?>  <?php $plxShow->mainTitle('link'); ?></span> | <?php $plxShow->lang('POWERED_BY') ?> <a href="http://www.pluxml.org" title="<?php $plxShow->lang('PLUXML_DESCRIPTION') ?>">PluXml</a>
	</div>
</footer>

<?php include(dirname(__FILE__).'/scripts.php'); ?>

</body>
</html>



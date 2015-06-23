<?php 
/****************************************************
*
* @File: 		article-with-sidebar.php
* @Package:		PluXML
* @Action:		YomliBlog theme for PluXML CMS
*
*****************************************************/

include(dirname(__FILE__).'/header.php'); 
?>

<div id="page" class="container row">
	<div id="cool-img" class="3u 0u$(small)">
		<div class="box alt">
		</div>
	</div>

	<div id="main" class="9u 12u$(small)">
		<div class="row 100%">

			<div id="content" class="8u 12u$(xsmall) important(collapse)">

				<article role="article" id="post-<?php echo $plxShow->artId(); ?>">

					<header>
						<h2  class="icon fa-file">
							<?php $plxShow->artTitle(''); ?>
						</h2>
					</header>

					<div>
						<?php $plxShow->artContent(); ?>
					</div>

					<footer>
						<p>
							<span class="icon fa-user"> <?php $plxShow->artAuthor(); ?> </span>
							<span class="icon fa-calendar"><time datetime="<?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>"> <?php $plxShow->artDate('#num_day #month #num_year(4)'); ?> </time></span>
							<span class="icon fa-folder-open"> <?php $plxShow->artCat(); ?> </span> 
							<span class="icon fa-tags"> <?php $plxShow->artTags(); ?> </span>	
						</p>
					</footer>

				</article>

				<?php $plxShow->artAuthorInfos('<div class="author-infos">#art_authorinfos</div>'); ?>
				<hr />
				<?php include(dirname(__FILE__).'/commentaires.php'); ?>

			</div>
			<?php include(dirname(__FILE__).'/sidebar.php'); ?>
		</div>
	</div>

</div>

<?php include(dirname(__FILE__).'/footer.php'); ?>
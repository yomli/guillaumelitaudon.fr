<?php 
/****************************************************
*
* @File: 		static-full-width.php
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

				<article role="article" id="static-page-<?php echo $plxShow->staticId(); ?>">

					<header>
						<h2>
							<?php $plxShow->staticTitle(); ?>
						</h2>
					</header>

					<div>
						<?php $plxShow->staticContent(); ?>
					</div>

				</article>

			</div>
			<?php include(dirname(__FILE__).'/sidebar.php'); ?>
		</div>

	</div>

</div>

<?php include(dirname(__FILE__).'/footer.php'); ?>
<?php 
/****************************************************
*
* @File: 		home.php
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

			<div class="feature row">

			<?php while($plxShow->plxMotor->plxRecord_arts->loop()): ?>
				<div class="4u 12u$(medium)">
					<div class="box">	

					<article role="article" id="post-<?php echo $plxShow->artId(); ?>" class="article-home">
						<header>
							<h2 class="icon fa-file">
								<?php $plxShow->artTitle('link'); ?>
							</h2>
							<p>
								<span class="icon fa-calendar"> <time datetime="<?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>"><?php $plxShow->artDate('#num_day #month #num_year(4)'); ?></time></span>
							</p>
						</header>

						<div>
							<?php $plxShow->artChapo(''); ?>
						</div>
					</article>
					</div>
				</div>

			<?php endwhile; ?>

			</div>
			
			<div id="pagination">
					<?php $plxShow->pagination(); ?>
			</div>

			<hr />
			<?php include(dirname(__FILE__).'/sidebar-home.php'); ?>


		</div>
	</div>

<?php include(dirname(__FILE__).'/footer.php'); ?>
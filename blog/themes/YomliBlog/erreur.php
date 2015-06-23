<?php 
/****************************************************
*
* @File: 		erreur.php
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

			<div id="content">

				<article>

					<header>
						<h2>
							<?php $plxShow->lang('ERROR'); ?>
						</h2>
					</header>

					<div>
						<?php $plxShow->erreurMessage(); ?>
					</div>

				</article>

			</div>

	</div>

</div>

<?php include(dirname(__FILE__).'/footer.php'); ?>
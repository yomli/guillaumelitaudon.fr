<?php if(!defined('PLX_ROOT')) exit; 
/****************************************************
*
* @File: 		sidebar-home.php
* @Package:		PluXML
* @Action:		YomliBlog theme for PluXML CMS
*
*****************************************************/
?>

<div class="row">

	<aside role="complementary" class="4u 12u$(xsmall)" id="sidebar">

		<div>
			<h3 class="icon fa-folder-open">
				<?php $plxShow->lang('CATEGORIES'); ?>
			</h3>

			<ul class="alt">
				<?php $plxShow->catList('','<li id="#cat_id"><a class="#cat_status" href="#cat_url" title="#cat_name">#cat_name</a> (#art_nb)</li>'); ?>
			</ul>
		</div>

		<hr />
		
		<div>
			<h3 class="icon fa-archive">
				<?php $plxShow->lang('ARCHIVES'); ?>
			</h3>
			<select id="archives-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
				<option value=""><?php $plxShow->lang('MONTH'); ?></option>
				<?php $plxShow->archList('<option value="#archives_url">#archives_name (#archives_nbart)</option>'); ?>
			</select>
		</div>

		<hr />

		<div>
			<h3 class="icon fa-tags">
				<?php $plxShow->lang('TAGS'); ?>
			</h3>

			<ul>
				<?php $plxShow->tagList('<li class="tag #tag_size"><a class="#tag_status" href="#tag_url" title="#tag_name">#tag_name</a></li>', 20, 'random'); ?>
			</ul>		
		</div>

	</aside>

	<div class="8u important(collapse) 12u$(xsmall)">
		<div id="content">
			<section class="last">
				<header>
					<h2 class="icon fa-info-circle"> <?php $plxShow->lang('ABOUT'); ?></h2>
				</header>
				<p>
					Lorem ipsum Laborum incididunt id adipisicing veniam nisi occaecat laboris voluptate velit voluptate culpa cupidatat sunt minim elit Duis officia ex dolor occaecat esse cupidatat sunt laborum.
				</p>
				<p>
					Duis quis anim nostrud nulla ut officia id proident Excepteur Duis irure cupidatat aliquip laboris officia commodo eu voluptate in esse fugiat ex aliquip nostrud occaecat nisi eiusmod ea sint sit esse sint Ut cillum aliquip et dolor adipisicing culpa dolor dolore elit nostrud aliquip elit amet enim minim anim culpa labore eiusmod eu pariatur dolore dolore in anim velit Duis ex reprehenderit consectetur dolor nostrud magna ea irure fugiat sint amet nostrud.
				<p>
					Duis irure magna anim et in enim dolor esse culpa do eu irure aute eu ex et enim quis laboris exercitation Excepteur ex aliqua pariatur culpa ad labore aliquip fugiat cupidatat incididunt tempor dolor dolore est enim veniam non est in aliquip ut laboris Duis in pariatur.
				</p>
				<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&amp;business=guillaume%2elitaudon%40gmail%2ecom&amp;lc=FR&amp;item_name=Guillaume%20%22Yomli%22%20Litaudon&amp;currency_code=EUR&amp;bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted" class="button icon fa-coffee"><?php $plxShow->lang('COFFEE'); ?>&nbsp;</a>

				</section>
			</div>

		</div>

	</div>


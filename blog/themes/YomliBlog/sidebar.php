<?php if(!defined('PLX_ROOT')) exit; 
/****************************************************
*
* @File: 		sidebar-home.php
* @Package:		PluXML
* @Action:		YomliBlog theme for PluXML CMS
*
*****************************************************/
?>

<aside role="complementary" class="3u 12u$(xsmall)" id="sidebar">

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

	<hr />

	<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&amp;business=guillaume%2elitaudon%40gmail%2ecom&amp;lc=FR&amp;item_name=Guillaume%20%22Yomli%22%20Litaudon&amp;currency_code=EUR&amp;bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted" class="button icon fa-coffee"><?php $plxShow->lang('COFFEE'); ?>&nbsp;</a>

</aside>


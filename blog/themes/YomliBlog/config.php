<?php
/* ----------------------------SPXSHORTCODES CONFIG---------------------------------*/

function shortcode_markup_func($atts,$content=null) {
	$content = str_replace ( "<p>" ,"" , $content );
	$content = str_replace ( "</p>" ,"", $content );
	extract(shortcode_atts(array(
		'class' => ''
 	), $atts));

	//if ($class == 'html' || $class == 'php' || $class == 'xhtml' || $class == 'xml') $content = htmlspecialchars($content);
	$content = htmlspecialchars($content);
	
	return ('<pre><code class="'.$class.'">'.$content.'</code></pre>');
}

add_shortcode('code', 'shortcode_markup_func');


?>
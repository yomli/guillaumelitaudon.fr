<?php if (!defined('PLX_ROOT')) exit; 
/****************************************************
*
* @File: 		scripts.php
* @Package:		PluXML
* @Action:		YomliBlog theme for PluXML CMS
*
*****************************************************/
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
	if (typeof jQuery === 'undefined') {
		document.write(unescape('%3Cscript%20src%3D%22<?php $plxShow->template(); ?>/js/jquery.min.js%22%3E%3C/script%3E'));
	}
</script>
<script src="<?php $plxShow->template(); ?>/js/skel.min.js"></script>
<script src="<?php $plxShow->template(); ?>/js/baseline.main.js"></script>
<script src="<?php $plxShow->template(); ?>/js/highlight.pack.js"></script>

<script type="text/javascript">

		 function keyboardFocus(){
		 	$(document).bind('keypress', function(e){
		 		var code = (e.keyCode ? e.keyCode : e.which);
		 		if(code === 9  || (e.shiftKey && code === 37)  || (e.shiftKey && code === 38)  || (e.shiftKey && code === 39)  || (e.shiftKey && code === 40)){
		 			$('a', 'nav').parents("li").addClass("hover");
		 			setTimeout(function(){
		 				$('a', 'nav').parents("li").removeClass("hover");
		 			}, 5000);
		 		}
		 	});

		 }

		 function toTop(element,footer){
		 	var scroll = $(window).scrollTop();
		 	var maxScroll = $(window).height() * 0.4;

		 	if(scroll > maxScroll)
		 		$(element).show();
		 	else
		 		$(element).hide();

		 	if($(element).offset().top + $(element).height() >= $(footer).offset().top - 10)
		 		$(element).css('position', 'absolute');
		 	if($(document).scrollTop() + window.innerHeight < $(footer).offset().top)
       			 $(element).css('position', 'fixed'); // restore when you scroll up
       		}

       		function parallax(element,percent,height,width,factor,reference){
       			var winWidth = $(window).width();
       			var winHeight = $(window).height();

       			var sizePercent = percent == 1 ? height : ((winWidth*percent)/width)*height;

       			var maxScroll = -(sizePercent - winHeight);
       			var speed = factor*($(reference).offset().top / winHeight);
       			var yPos = -($(window).scrollTop() / speed);
       			yPos = yPos >= -1 ? -1 : yPos;
       			yPos = yPos >= maxScroll ? yPos : maxScroll;
       			var coords = '0 '+ yPos + 'px';

       			$(element).css({ backgroundPosition: coords });
       		}


       		function goGoParallaxEffect(){
       			if($(window).width() > 388)
       				parallax('#page',0.42,1080,388,5,footer);
       			else
       				parallax('#page',1,1080,388,5,footer);
       		}

       		function keyboardAuth(redirection) {
       			var enterCount = 0;
				//$(document).keypress(function(event){
					document.addEventListener("keypress", function(event) {
						var keycode = (event.keyCode ? event.keyCode : event.which);
						if(keycode == '13'){
							enterCount++;
							if(enterCount >= 3){
								enterCount = 0;
								window.location = redirection;
							}
							setTimeout(function(){ enterCount = 0; },2000);
						}

					});
				}


				$(document).ready(function(){

					$(window).scroll(function() {
						goGoParallaxEffect();
						toTop('.toTop',"#footer");
					});

					$(window).resize(function() {
						goGoParallaxEffect();
						toTop('.toTop',"#footer");
					});

					hljs.initHighlightingOnLoad();

					$('a[href*=#]').on('click', function(event){     
						event.preventDefault();
						$('html,body').animate({scrollTop:$(this.hash).offset().top}, 700);
					});

					keyboardFocus();
					keyboardAuth("<?php $plxShow->urlRewrite('core/admin/'); ?>");
					toTop('.toTop',"#footer");
					
				});

			</script>

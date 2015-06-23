/* skel-baseline v3.0.0-dev | (c) n33 | skel.io | MIT licensed */

(function($) {

	// Vars.
	$body = $('body');

	// Breakpoints.
	skel.breakpoints({
		xlarge:	'(max-width: 1680px)',
		large:	'(max-width: 1280px)',
		medium:	'(max-width: 980px)',
		small:	'(max-width: 736px)',
		xsmall:	'(max-width: 480px)'
	});

	// Disable animations/transitions until everything's loaded.
	var	$window = $(window),
	$body = $('body');

	$body.addClass('is-loading');

	$window.on('load', function() {
		$body.removeClass('is-loading');
	});


	// Nav.
	var	$nav = $('#nav'),
	$navToggle = $('a[href*="#nav"]'),
	$navClose;


		// Event: Prevent clicks/taps inside the nav from bubbling.
		$nav.on('click touchend', function(event) {
			event.stopPropagation();
		});

		// Event: Hide nav on body click/tap.
		$body.on('click touchend', function(event) {
			$nav.removeClass('visible');
		});

		// Toggle.

			// Event: Toggle nav on click.
			$navToggle.on('click', function(event) {

				event.preventDefault();
				event.stopPropagation();
				$nav.toggleClass('visible');

			});

		// Close.

			// Create element.
			$navClose = $('<a></a>');
			$navClose.attr({ href : '#', tabIndex : 0 });
			$navClose.addClass('close');
			$nav.append($navClose);

			// Event: Hide on ESC.
			$window.on('keydown', function(event) {

				if (event.keyCode == 27)
					$nav.removeClass('visible');

			});

			// Event: Hide nav on click.
			$navClose.on('click', function(event) {

				event.preventDefault();
				event.stopPropagation();

				$nav.removeClass('visible');

			});

		})(jQuery);
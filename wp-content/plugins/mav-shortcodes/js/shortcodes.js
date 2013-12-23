/*-----------------------------------------------------------------------------------*/
/* Shortcode Functions */
/*-----------------------------------------------------------------------------------*/

jQuery(document).ready(function($) {

	// Toggle
	$(".mav-toggle-title").live( 'click', function () {

		$(this).next('div').toggle();

		// you should also toggle the class for the span containing the + sign
		s = $(this).find('span');
		$( s ).toggleClass('ui-icon-plus ui-icon-minus');

	});

});


/*-----------------------------------------------------------------------------------*/
/* Misc. Functions */
/*-----------------------------------------------------------------------------------*/

// Keep the plugin window in the center of the page
jQuery( document ).ready( function ($) {

	$(window).resize(function() {

		var winHeight = $(window).height() - 160;
		$("#mav-dialog").css( { 'max-height' : winHeight + 'px' } );
		$("#mav-dialog").dialog("option", "position", "center");

	});

});

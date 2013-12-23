<?php

/*-----------------------------------------------------------------------------------*/
/* Shortcodes */
/*-----------------------------------------------------------------------------------*/

// Enable the use of shortcodes also for the Widget Text
add_filter('widget_text', 'do_shortcode');


/*-----------------------------------------------------------------------------------*/
/* =Buttons */
/*-----------------------------------------------------------------------------------*/

function mav_button_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'color' => '',
		'link' => '',
		'size' => '',
		'target' => '',
		'type' => ''
	), $atts ) );

	return '<a href="' . $link . '" class="mav-button ' . $color . ' ' . $size . ' ' . $type . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
}

add_shortcode('mav_button', 'mav_button_shortcode');


/*-----------------------------------------------------------------------------------*/
/* =Info Box */
/*-----------------------------------------------------------------------------------*/

function mav_box_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'type' => '',
		'icon' => ''
	), $atts ) );

	if ( $icon == "yes" ? $icon : $icon = "no-icon" )

	return '<div class="mav-box ' . $type . ' ' . $icon . '">' . do_shortcode($content) . '</div>';
}

add_shortcode('mav_box', 'mav_box_shortcode');


/*-----------------------------------------------------------------------------------*/
/* =Highlight */
/*-----------------------------------------------------------------------------------*/

function mav_highlight_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'color' => ''
	), $atts ) );

	return '<span class="mav-highlight ' . $color . '">' . do_shortcode($content) . '</span>';
}

add_shortcode('mav_highlight', 'mav_highlight_shortcode');


/*-----------------------------------------------------------------------------------*/
/* =Accordion */
/*-----------------------------------------------------------------------------------*/

function mav_accordion_all_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'ids'	=> '',
		'group'	=> ''
	), $atts ) );

	$c = '<script type="text/javascript">

		jQuery( document ).ready( function ($) {
			$( "#mav-accordion-' . $group . '" ).accordion({
				clearStyle :	true,
				heightStyle: 	"content",
				autoHeight :	false
			});
		});

		window.setTimeout(function() {

				jQuery( document ).ready( function ($) {
					$( "#mav-accordion-' . $group . '" ).accordion( "refresh" );
				});

			}, 1000);

		</script>';

	$c .= '
		<div id="mav-accordion-' . $group . '" class="mav-accordion">';

	return $c;
}

add_shortcode('mav_accordion_all', 'mav_accordion_all_shortcode');


function mav_accordion_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title'	=> 'MAV accordion',
		'id'	=> '',
		'group'	=> '',
		'last'	=> ''
	), $atts ) );

	$c = '<h3 id="mav-accordion-title-' . $group . '-' . $id . '" class="mav-accordion-title mav-accordion-title-' . $group . '">' .
			$title .
		'</h3>
		<div id="mav-accordion-content-' . $group . '-' . $id . '" class="mav-accordion-content mav-accordion-content-' . $group . '"><p>' . do_shortcode($content) . '</p></div>';

	if ( $last == "last" )
		$c .= '</div>';

	return $c;
}

add_shortcode('mav_accordion', 'mav_accordion_shortcode');


/*-----------------------------------------------------------------------------------*/
/* =Toggle */
/*-----------------------------------------------------------------------------------*/

function mav_toggle_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title'	=> 'MAV Toggle',
		'state'	=> 'open'
	), $atts ) );

	// Check the state of the toggle to know what class to  add to the title span (I used jquery-ui`s own icons but you can use other, this is just as an example)
	if ( $state == 'open' ) {
		$span_class = 'ui-icon-minus';
	} else {
		$span_class = 'ui-icon-plus';
	}

	return '<div class="mav-toggle"><div class="mav-toggle-title"><span class="ui-icon ' . $span_class . '"></span>' . $title . '</div><div class="mav-toggle-content mav-toggle-state-' . $state . '">' . do_shortcode($content) . '</div></div>';
}

add_shortcode('mav_toggle', 'mav_toggle_shortcode');


/*-----------------------------------------------------------------------------------*/
/* =Tabs */
/*-----------------------------------------------------------------------------------*/

function mav_tabs_all_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'ids'	=> '',
		'group'	=> ''
	), $atts ) );

	$c = '<script type="text/javascript">
			jQuery( document ).ready( function ($) {
				var d = $.find( ".mav-tabs-title-' . $group . '" );
				var a = $.find( ".mav-tabs-a-' . $group . '" );
				$.each( d, function ( key, o ) {
					t = o.textContent;
					a[key].textContent = t;
					r = $(o).attr( "id" );
					$( "#" + r ).remove();
				});

				// The effects are documented at Documentation here: http://docs.jquery.com/UI/Effects
				// They are loaded from mav-shortcode.php (are packed in wordpress)
				// In time you could put some selectboxes to chose the effect :)
				$( "#mav-tabs-' . $group . '" ).tabs({ fx: { opacity: "toggle" } });
			});
		</script>';

	$c .= '
		<div id="mav-tabs-' . $group . '" class="mav-tabs">
			<ul>';
		for ($i = 1; $i <= $ids; $i++) {
			$c .= '<li><a class="mav-tabs-a-' . $group . '" href="#mav-tabs-content-' . $group . '-' . $i . '">Tab Title</a></li>';
		}
	$c .= '</ul>';

	return $c;
}

add_shortcode('mav_tabs_all', 'mav_tabs_all_shortcode');


function mav_tabs_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title'	=> '',
		'id'	=> '',
		'group'	=> '',
		'last'	=> ''
	), $atts ) );

	$c = '<div id="mav-tabs-title-' . $group . '-' . $id . '" class="mav-tabs-title mav-tabs-title-' . $group . '">' .
			$title .
		'</div>
		<div id="mav-tabs-content-' . $group . '-' . $id . '" class="mav-tabs-content mav-tabs-content-' . $group . '">' . do_shortcode($content) . '</div>';

	if ( $last == "last" )
		$c .= '</div>';

	return $c;
}

add_shortcode('mav_tabs', 'mav_tabs_shortcode');


/*-----------------------------------------------------------------------------------*/
/* =Columns */
/*-----------------------------------------------------------------------------------*/

function mav_columns_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title'	=> '',
		'color'	=> '',
		'type'	=> ''
	), $atts ) );

	$c = '<div class="mav-columns mav-columns-color-' . $color . ' mav-columns-' . $type . '">
			<h3 class="mav-columns-title">' .
				$title .
			'</h3>
		<div class="mav-columns-content">' . do_shortcode($content) . '</div></div>';

	return $c;
}

add_shortcode('mav_columns', 'mav_columns_shortcode');


?>

<?php
if (function_exists('wpml_register_admin_strings')) {
    wpml_register_admin_strings('a:1:{s:13:"Stand_options";a:7:{s:18:"home_message_title";s:12:"Howdy Folks!";s:17:"home_message_text";s:57:"Enter the text you would like to display as home message.";s:10:"quote_text";s:54:"Bike messenger by day, aspiring actor by night, etc...";s:21:"portfolios_home_title";s:10:"What We Do";s:15:"portfolios_desc";s:54:"Bike messenger by day, aspiring actor by night, etc...";s:19:"projects_home_title";s:12:"Recent Works";s:13:"projects_desc";s:54:"Bike messenger by day, aspiring actor by night, etc...";}}');
}
?>

<?php

// These are functions specific to the included option settings and this theme

/*-----------------------------------------------------------------------------------*/
/* Output CSS from standarized options */
/*-----------------------------------------------------------------------------------*/

function of_head_css() {

	global $post, $mav_data, $of_set; // fetch options stored in $mav_data

	$output = '';

	if ( $mav_data['bg_patterns'] ) {
		$output .= "
body { background-image: url(" . $mav_data['custom_bg'] . "); }";
	}

	if ( $mav_data['body_options'] ) {
		$output .= "
body { background-color: " . $mav_data['body_color'] . "; background-image: url(" . $mav_data['body_image'] . "); background-repeat: " . $mav_data['body_repeat'] . "; background-position: " . $mav_data['body_pos'] . "; }";
	}

	elseif ( $mav_data['body_color'] ) {
		$output .= "
body { background-color: " . $mav_data['body_color'] . "; }";
	}

	// Primary Color
	if ( $mav_data['primary_color'] <> '' ) {
		$output .= "
a, a:link, a:visited, .entry-title a:hover, #navi ul li a:hover, #navi ul li.current-menu-item > a, ul#filters li a:hover, ul#filters li a.selected, span.img_copyrights a, span.tag-links a:hover, span.comments-link a:hover, span.comments-link a:hover > strong, .format-quote h3.entry-title a, .single-post .format-quote h3.entry-title, #projects .element:hover > h3.entry-title a, #portfolios .element:hover > h3.entry-title a { color: " . $mav_data['primary_color'] . "; }
span.overlay:hover, a.entry-format, #projects .element img, #portfolios .element img, .related-item img, .nav-previous a:hover, .nav-next a:hover, .prevButton:hover, .nextButton:hover, a.more-link, a:link.more-link, a:visited.more-link, span.cat-links a:hover, span.by-author:hover, span.posted-on:hover, blockquote:before, .format-quote h3.entry-title a, a.comment-reply-link:hover, h1.page-title { background-color: " . $mav_data['primary_color'] . "; }
#slideshowmenuwrapper .cursor, ul#slideshowmenu li a:hover, ul#slideshownav li a:hover, ul#slideshowmenu li a.active { background-color: " . $mav_data['primary_color'] . "; }
.tagcloud a:hover, input[type=\"submit\"], a.project-link-button { background-color: " . $mav_data['primary_color'] . "; border-color: " . $mav_data['primary_color'] . "; }
.gallery .gallery-item img:hover { border-color: " . $mav_data['primary_color'] . " !important; }";
	}

	// Secondary Color
	if ( $mav_data['secondary_color'] <> '' ) {
		$output .= "
a:active, a:hover, span.img_copyrights a:hover { color: " . $mav_data['secondary_color'] . "; }";
	}

	// Selection Color
	if ( $mav_data['selection_color'] <> '' ) {
		$output .= "
::-webkit-selection { background: " . $mav_data['selection_color'] . "; }
::-moz-selection { background: " . $mav_data['selection_color'] . "; }
::selection { background: " . $mav_data['selection_color'] . "; }\n";
	}

	if ( $mav_data['custom_css'] <> '' ) {
		$output .= $mav_data['custom_css'] . "\n";
	}

	// Output styles
	if ($output <> '') {
		$output = "<!-- Custom Styling -->\n<style type=\"text/css\">" . $output . "</style>\n\n";
		echo $output;
	?>

	<?php
	/*
	 * Custom Background Image
	 */
	?>
	<?php if ( $bg_image = get_post_meta( get_the_ID(), 'of_bg_image', true ) ) : ?>
<style type="text/css"> body { background-image: url(<?php echo $bg_image; ?>); } </style>
	<?php endif; ?>
	<?php
	$portfolios = wp_get_post_terms( $post->ID, array('portfolios') );
	foreach ($portfolios as $portfolio) {
		$tag_extra_fields = get_option('portfolios_fields');

		if ( $of_set['portfolio'] == true ) :
		if ( isset( $tag_extra_fields[$portfolio->term_id]['_custom_bg_image_url'] ) ) {
			$custom_bg_image_url = $tag_extra_fields[$portfolio->term_id]['_custom_bg_image_url'];
			// print_r($custom_bg_image_url);
		}
		endif;
	}
	?>
	<?php if ( !empty( $custom_bg_image_url ) ) : ?>
<style type="text/css"> body { background-image: url(<?php echo $custom_bg_image_url; ?>); } </style>
	<?php endif; ?>

	<?php

	}

}

add_action('wp_head', 'of_head_css');


/*-----------------------------------------------------------------------------------*/
/* Add Body Classes for Layout
/*-----------------------------------------------------------------------------------*/

// Adds a body class to indicate sidebar position.

function of_body_class($classes) {

	global $mav_data; // fetch options stored in $mav_data

	$layout = $mav_data['layout'];

	if ($layout == '') {
		$layout = 'layout-2cr';
	}

	$classes[] = $layout;

	return $classes;

}

add_filter('body_class','of_body_class');


/*-----------------------------------------------------------------------------------*/
/* Add Favicon
/*-----------------------------------------------------------------------------------*/

function custom_favicon() {

	global $mav_data; // fetch options stored in $mav_data

	if ( $mav_data['custom_favicon'] != '') {
		echo '<link rel="icon" href="' . $mav_data['custom_favicon'] . '"/>'."\n";
		echo '<link rel="shortcut icon" href="' . $mav_data['custom_favicon'] . '"/>'."\n";
	} else { ?>
	<link rel="icon" href="<?php echo get_stylesheet_directory_uri() ?>/images/favicon.ico" />
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() ?>/images/favicon.ico" />
<?php }
}

add_action('wp_head', 'custom_favicon');


/*-----------------------------------------------------------------------------------*/
/* Show analytics code in footer */
/*-----------------------------------------------------------------------------------*/

function theme_analytics() {

	global $mav_data; // fetch options stored in $mav_data
	
	$output = $mav_data['google_analytics'];
	
	if ( $output <> "" ) 
	echo stripslashes($output) . "\n";

}

add_action('wp_footer','theme_analytics');

?>

<?php

	/**
	 * FRAMEWORK VERSION 1.0.10
	 * 
	 */

	global $of_set, $pri_color, $sec_color, $sel_color, $bg_color, $layout, $slider_height, $topbar, $bg_patterns, $blog_home_std, $portfolios_home_std, $projects_home_std, $homepage_blocks, $related_posts_std, $related_projects_std, $site_tagline;

	$of_set = array (
		"responsive"	 => 1,
		"main_layout" 	 => 1,
		"layout_manager" => 1,
		"portfolio" 	 => 1,
		"slider" 		 => 1
	);

	$site_tagline = false;

	$topbar = false;

	$layout = 'layout-2cr'; // 2cr, 2cl, 1col

	$pri_color = "#fa4951";
	$sec_color = "#3b4045";
	$sel_color = "#fa4951";
	$bg_color =  "#fa4951";

	$bg_patterns = false;

	$homepage_blocks = array(
		"disabled" => array (
			"placebo" 				=> "placebo", // REQUIRED!
			"block_slider"			=> "Slider",
			"block_blog_posts"		=> "Blog",
			"block_projects"		=> "Latest Projects"
		),
		"enabled" => array (
			"placebo" 				=> "placebo", // REQUIRED!
			"block_home_message" 	=> "Home Message",
			"block_portfolio"		=> "Portfolios",
			"block_quote"			=> "Quote"
		),
	);
	
	$blog_home_std = "3";

	// $portfolios_home_std = "3";

	$projects_home_std = "3";

	$slider_height = "300";

	$related_posts_std = "3";

	$related_projects_std = "3";


	// Set thumbnail and images size
	set_post_thumbnail_size( 300, 210, true );
	add_image_size( 'mav-thumbnails', 300, 210, true );
	add_image_size( 'mav-widget-thumbnails', 300, 210, true );
	add_image_size( 'mav-related-thumbnails', 193, 135, true );
	add_image_size( 'mav-single-thumbnails', 560, '', true );
	add_image_size( 'mav-one-column-thumbnails', 940, 705, true );


	// Register WP3.0+ Menus
	register_nav_menus( array(
		'primary'   => __( 'Header Navigation', 'framework' ),
		'secondary' => __( 'Home Message Navigation', 'framework' ),
		'third'     => __( 'Footer Navigation', 'framework' )
	) );


	/**
	 * Enqueue Google Fonts
	 */
	function google_fonts() {
		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( 'framework-fonts', "$protocol://fonts.googleapis.com/css?family=Merriweather&subset=latin,latin-ext' rel='stylesheet' type='text/css" );
	}

	add_action( 'wp_enqueue_scripts', 'google_fonts' );

?>
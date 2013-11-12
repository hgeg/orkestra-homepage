<?php 

// Theme functions and definitions

/*-----------------------------------------------------------------------------------*/
/* Set the content width based on the theme's design and stylesheet */
/*-----------------------------------------------------------------------------------*/

if ( ! isset( $content_width ) )
	$content_width = 620;

// Tell WordPress to run framework_setup() when the 'after_setup_theme' hook is run.
add_action( 'after_setup_theme', 'framework_setup' );

if ( ! function_exists( 'framework_setup' ) ) :

	/*-----------------------------------------------------------------------------------*/
	/* Sets up theme defaults and registers support for various WordPress features */
	/*-----------------------------------------------------------------------------------*/

	function framework_setup() {

		// Post Format support
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'link', 'quote', 'video', 'audio' ) );

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
		
		// Make theme available for translation
		load_theme_textdomain( 'framework',  get_template_directory() . '/languages' );
		$locale = get_locale();
		$locale_file =  get_template_directory() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );

		// Add support for bbPress 2.x
		add_theme_support( 'bbpress' );
		
		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );

		if ( is_child_theme() ) { // dahex
			include ( get_stylesheet_directory() . '/functions/framework_setup.php');
		} else {
			include ('functions/framework_setup.php');
		}

	}

endif;


/*-----------------------------------------------------------------------------------*/
/* Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link */
/*-----------------------------------------------------------------------------------*/

function framework_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}

add_filter( 'wp_page_menu_args', 'framework_page_menu_args' );


/*-----------------------------------------------------------------------------------*/
/* Sets the post excerpt length to 40 characters */
/*-----------------------------------------------------------------------------------*/

function framework_excerpt_length( $length ) {
	return 24; // 40 default
}
add_filter( 'excerpt_length', 'framework_excerpt_length' );

function framework_continue_reading_link() {
	return '<p><a class="more-link" href="'. get_permalink() . '">' . __( 'Read More', 'framework' ) . '</a></p>';
}


/*-----------------------------------------------------------------------------------*/
/* Replaces "[...]" (appended to automatically generated excerpts) */
/* with an ellipsis - &hellip; - and framework_continue_reading_link() */
/*-----------------------------------------------------------------------------------*/

function framework_auto_excerpt_more( $more ) {
	return '&hellip;' . framework_continue_reading_link();
}

add_filter( 'excerpt_more', 'framework_auto_excerpt_more' );


/*-----------------------------------------------------------------------------------*/
/* Adds a pretty "=Continue Reading" link to custom post excerpts */
/*-----------------------------------------------------------------------------------*/

function framework_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= framework_continue_reading_link();
	}
	return $output;
}

add_filter( 'get_the_excerpt', 'framework_custom_excerpt_more' );


/*-----------------------------------------------------------------------------------*/
/* Custom =Logo Login */
/*-----------------------------------------------------------------------------------*/

function framework_login_head() {

	global $mav_data; // fetch options stored in $mav_data

	if ( $mav_data['custom_logo_login'] ) {
		echo '<style>
			body.login #login h1 a {
			background-image: url('.$mav_data['custom_logo_login'].');
			background-size: auto;
			background-position: center center;
			background-repeat: no-repeat;
			margin: 0 auto;
			margin-bottom: 20px;
			padding-bottom: 0;
			height: 140px;
			max-width: 260px;
		}
		</style>';
	}

}

add_action("login_head", "framework_login_head");


// Custom Login URL
add_filter( 'login_headerurl', 'my_custom_login_url' );
function my_custom_login_url($url) {
	$blog_url = home_url();
	return $blog_url;
}

// Custom Logo URL title
function my_login_logo_url_title() {
	$blog_name = get_bloginfo('name');
	return $blog_name;
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );


/*-----------------------------------------------------------------------------------*/
/* =Gravatar */
/*-----------------------------------------------------------------------------------*/

/*add_filter( 'avatar_defaults', 'mav_custom_gravatar' );

function mav_custom_gravatar ( $avatar_defaults ) {
	// $custom_gravatar = 'http://mattiaviviani.com/mav-logo.png';
	$custom_gravatar = get_template_directory_uri() . '/images/gravatar.png';
	$avatar_defaults[$custom_gravatar] = "Theme Gravatar";
	return $avatar_defaults;
}*/


/*-----------------------------------------------------------------------------------*/
/* Template for =Comments and Pingbacks */
/*-----------------------------------------------------------------------------------*/

/**
 * To override this walker in a child theme without modifying the comments template
 * simply create your own framework_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */

if ( ! function_exists( 'framework_comment' ) ) :

	function framework_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			
			<div id="comment-<?php comment_ID(); ?>" class="comment-block">
			
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 60 ); ?>
				</div> <!-- /end .comment-author .vcard -->

				<span class="fn">
				<?php
				$comment_author = get_comment_author_url();
				if (!empty($comment_author)) { ?><a href="<?php comment_author_url(); ?>" rel="external nofollow" class="url" target="_blank"><?php comment_author(); ?></a>
				<?php } else {
					comment_author();
				} ?>
				</span>

				<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<?php
					/* translators: 1: date, 2: time */
					printf( __( '%1$s at %2$s', 'framework' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( 'edit', 'framework' ), ' ' );
					?>
				</div> <!-- /end .comment-meta .commentmetadata -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'framework' ); ?></em>
				<?php endif; ?>

				<div class="comment-body"><?php comment_text(); ?></div>

				<section class="comment-footer">
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div> <!-- /end .reply -->
				</section>

			</div> <!-- /end #comment-##  -->

		<?php
		break;
		case 'pingback'  :
		case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'framework' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'framework' ), ' ' ); ?></p>
		<?php
		break;
		endswitch;
	}

endif;


/*-----------------------------------------------------------------------------------*/
/* Removes the default styles that are packaged with the Recent Comments widget */
/*-----------------------------------------------------------------------------------*/

function framework_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}

add_action( 'widgets_init', 'framework_remove_recent_comments_style' );


/*-----------------------------------------------------------------------------------*/
/* Register =Sidebars */
/*-----------------------------------------------------------------------------------*/

function framework_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Sidebar Blog', 'framework' ),
		'id' => 'primary-blog-widget-area',
		'description' => __( 'The primary sidebar for Blog.', 'framework' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title"><span class="title-bg">',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar Page', 'framework' ),
		'id' => 'primary-page-widget-area',
		'description' => __( 'The primary sidebar for Pages.', 'framework' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title"><span class="title-bg">',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Secondary Sidebar (Blog and Pages)', 'framework' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary sidebar for Blog and Pages.', 'framework' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title"><span class="title-bg">',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer First', 'framework' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'An optional widget area for your site footer.', 'framework' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title"><span class="title-bg">',
		'after_title' => '</span></h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Second', 'framework' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'An optional widget area for your site footer.', 'framework' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title"><span class="title-bg">',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Third', 'framework' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'An optional widget area for your site footer.', 'framework' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title"><span class="title-bg">',
		'after_title' => '</span></h3>',
	) );

}

// Register sidebars by running framework_widgets_init() on the widgets_init hook
add_action( 'widgets_init', 'framework_widgets_init' );


/*-----------------------------------------------------------------------------------*/
/* Register =Widgets */
/*-----------------------------------------------------------------------------------*/

function framework_register_widgets() {

	$widget_tweets = get_stylesheet_directory() . '/widgets/widget-tweets.php';
	$widget_blog = get_stylesheet_directory() . '/widgets/widget-blog.php';
	$widget_portfolio = get_stylesheet_directory() . '/widgets/widget-portfolio.php';
	
	// print_r($widget_blog); // debugging

	// Load each widget file

	// Widget Twitter
	if ( is_child_theme() && file_exists( $widget_tweets ) ) {
		require_once( $widget_tweets );
	} else {
		require_once( 'widgets/widget-tweets.php' );
	}

	// Widget Blog
	if ( is_child_theme() && file_exists( $widget_blog ) ) {
		require_once( $widget_blog );
	} else {
		require_once( 'widgets/widget-blog.php' );
	}

	// Widget Portfolio
	global $of_set;
	if ( $of_set['portfolio'] == true ) :
		if ( is_child_theme() && file_exists( $widget_portfolio ) ) {
			require_once( $widget_portfolio );
		} else {
			require_once( 'widgets/widget-portfolio.php' );
		}
	endif;

	// Register each widget
	register_widget( 'mav_tweets' );
	register_widget( 'mav_blog' );
	if ( $of_set['portfolio'] == true ) :
		register_widget( 'mav_portfolio' );
	endif;

}

add_action( 'widgets_init', 'framework_register_widgets');


/*-----------------------------------------------------------------------------------*/
/* Register =CSS */
/*-----------------------------------------------------------------------------------*/

function framework_include_styles() {

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'framework-style', get_stylesheet_uri(), '', '', '' );

	// Register the style like this for a theme:
	// wp_register_style( 'mavslider', get_template_directory_uri() . '/css/mavslider.css');
	wp_register_style( 'iosslider', get_template_directory_uri() . '/css/iosslider.css');
	wp_register_style( 'prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css');
	wp_register_style( 'mediaelementplayer', get_template_directory_uri() . '/css/mediaelementplayer.css');

	global $mav_data; // fetch options stored in $mav_data
	global $of_set;

	if ( $of_set['responsive'] == true ) {
		$media_queries = get_stylesheet_directory_uri() . '/css/mediaqueries.css';
		// print_r($media_queries);
		if ( $mav_data['responsive_layout'] ) :
			wp_register_style( 'media-queries', get_template_directory_uri() . '/css/mediaqueries.css');
			if ( is_child_theme() && !file_exists( $media_queries ) ) {
				wp_register_style( 'child-media-queries', $media_queries );
			}
		endif;
	}

	// For either a plugin or a theme, you can then enqueue the style:
	// wp_enqueue_style( 'mavslider' );
	wp_enqueue_style( 'iosslider' );
	wp_enqueue_style( 'prettyPhoto' );
	wp_enqueue_style( 'mediaelementplayer' );

	if ( $of_set['responsive'] == true ) :
		if ( $mav_data['responsive_layout'] ) {
				
			wp_enqueue_style( 'media-queries' );
			
			if ( is_child_theme() ) :
				wp_enqueue_style( 'child-media-queries' );
			endif;
			
		}
	endif;

}

add_action( 'wp_print_styles', 'framework_include_styles', '' );

/**
 * Enqueue Google Fonts - theme-child/functions/framework_setup.php
 */
/*function google_fonts() {
	$protocol = is_ssl() ? 'https' : 'http';
	wp_enqueue_style( 'framework-fonts', "$protocol://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic' rel='stylesheet' type='text/css" );
}

add_action( 'wp_enqueue_scripts', 'google_fonts' );*/


/*-----------------------------------------------------------------------------------*/
/* Register =Javascripts */
/*-----------------------------------------------------------------------------------*/

function framework_include_js() {

	// Register the script like this for a theme:
	wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr-2.6.2.js', '', '', false );
	wp_register_script( 'custom-script', get_template_directory_uri() . '/js/jquery.custom.js', '', '', true );
	// wp_register_script( 'mavslider', get_template_directory_uri() . '/js/jquery.mavslider.js', '', '', true );
	wp_register_script( 'iosslider', get_template_directory_uri() . '/js/jquery.iosslider.min.js', '', '', true );
	wp_register_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', '', '', true );
	wp_register_script( 'jquery-easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', '', '', true );
	wp_register_script( 'jquery-easing-compatibility', get_template_directory_uri() . '/js/jquery.easing.compatibility.js', '', '', true );
	wp_register_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', '', '', true ); // Under Commercial License
	wp_register_script( 'form-validate', get_template_directory_uri() . '/js/jquery.validate.js', '', '', true );
	wp_register_script( 'prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', '', '', true );
		wp_register_script( 'jquery-tweet', get_template_directory_uri() . '/js/jquery.tweet.js', '', '', true );
	wp_register_script( 'mediaelement', get_template_directory_uri() . '/js/mediaelement-and-player.min.js', '', '', false ); // load the js in <head>, js bug if otherwise.

	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'modernizr' );
	wp_enqueue_script( 'custom-script' );
	// wp_enqueue_script( 'mavslider' );
	wp_enqueue_script( 'iosslider' );
	wp_enqueue_script( 'superfish' );
	wp_enqueue_script( 'jquery-easing' );
	wp_enqueue_script( 'jquery-easing-compatibility' );
	wp_enqueue_script( 'isotope' );
	wp_enqueue_script( 'form-validate' );
	wp_enqueue_script( 'prettyPhoto' );
		wp_enqueue_script( 'jquery-tweet' );
	wp_enqueue_script( 'mediaelement' );

}

add_action( 'wp_enqueue_scripts', 'framework_include_js' );


/** --- Admin JS --- **/
function framework_admin_js() {

	if ( is_admin()/* && framework_get_current_post_type() == 'portfolio'*/ ) :

		wp_enqueue_style( 'admin-style', ADMIN_DIR . 'assets/css/admin-style.css');

		global $of_set;
		if ( $of_set['portfolio'] == true ) :
		// wp_enqueue_script( 'portfolio', trailingslashit( get_template_directory_uri() ) . 'js/portfolio.js', array( 'jquery', 'thickbox', 'media-upload' ) );
		wp_enqueue_script( 'portfolio', ADMIN_DIR . 'assets/js/portfolio.js', array( 'jquery', 'thickbox', 'media-upload' ) );
		endif; // $of_set

	endif;

}

add_action( 'admin_enqueue_scripts', 'framework_admin_js' );


/*-----------------------------------------------------------------------------------*/
/* Add PrettyPhoto to Post Gallery Format */
/*-----------------------------------------------------------------------------------*/
 
function prettyPhoto_post_gallery ($content) {
	$content = preg_replace("/<a/","<a data-rel=\"prettyPhoto[gallery]\"", $content, 1);
	return $content;
}

add_filter( 'wp_get_attachment_link', 'prettyPhoto_post_gallery');


/*-----------------------------------------------------------------------------------*/
/* Custom Menu Walker for =Responsive Menus */
/*-----------------------------------------------------------------------------------*/

// http://wpconsult.net/change-wordpress-navigation-to-a-dropdown-select-element-for-mobile/

class Walker_Responsive_Menu extends Walker_Nav_Menu {

	var $to_depth = -1;

	function start_lvl(&$output, $depth) {
		$output .= '</option>';
	}

	function end_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth); // don't output children closing tag
	}

	function start_el(&$output, $item, $depth, $args) {
		$indent = ( $depth ) ? str_repeat( "&nbsp;", $depth * 4 ) : '';
		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
		$value = ' value="'. $item->url .'"';
		$output .= '<option'.$id.$value.$class_names.'>';
		$item_output = $args->before;
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$output .= $indent.$item_output;
	}

	function end_el(&$output, $item, $depth) {
		if(substr($output, -9) != '</option>')
		$output .= "</option>"; // replace closing </li> with the option tag
	}

}


/*-----------------------------------------------------------------------------------*/
/* =Shortcodes */
/*-----------------------------------------------------------------------------------*/

// Enable the use of shortcodes also for the Widget Text
add_filter('widget_text', 'do_shortcode');

/**** Display link to WP.org. [wp-link] ****/
function shortcode_wp_link() {
    return '<a class="wp-link" href="http://WordPress.org/" title="WordPress" target="_blank">WordPress</a>';
}
add_shortcode('wp-link', 'shortcode_wp_link');

/**** Display link to wp-admin of the site. [loginout-link] ****/
function shortcode_login_link() {
    if ( ! is_user_logged_in() )
        $link = '<a href="' . site_url('/wp-login.php') . '">' . __('Login','framework') . '</a>';
    else
    $link = '<a href="' . wp_logout_url() . '">' . __('Logout','framework') . '</a>';
    return apply_filters('loginout', $link);
}
add_shortcode('loginout-link', 'shortcode_login_link');

/**** Display the site title. [blog-title] ****/
function shortcode_blog_title() {
	return '<span class="blog-title">' . get_bloginfo('name', 'display') . '</span>';
}
add_shortcode('blog-title', 'shortcode_blog_title');

/**** Display the site title with a link to the site. [blog-link] ****/
function shortcode_blog_link() {
	return '<a href="' . site_url('/') . '" title="' . esc_attr( get_bloginfo('name', 'display') ) . '" >' . get_bloginfo('name', 'display') . "</a>";
}
add_shortcode('blog-link', 'shortcode_blog_link');

/**** Display the current year. [the-year] ****/
function shortcode_year() {   
    return '<span class="the-year">' . date('Y') . '</span>';
}
add_shortcode('the-year', 'shortcode_year');

/**** Display link to admin + sign up. [signup-link] ****/
function shortcode_signup_link() {
	if ( ! is_user_logged_in() )
        $link = '<a href="' . site_url('/wp-login.php') . '">' . __('Login','framework') . '</a> or <a href="' . site_url('/wp-login.php?action=register') . '">' . __('Sign Up','framework') . '</a>';
    else
    $link = '<a href="' . wp_logout_url() . '">' . __('Logout','framework') . '</a>';
	// $link = '<a href="' . site_url('/wp-admin') . '">' . __('Dashboard','framework') . '</a> - <a href="' . wp_logout_url() . '">' . __('Logout','framework') . '</a>';
    return apply_filters('loginout', $link);
}
add_shortcode('signup-link', 'shortcode_signup_link');


/*-----------------------------------------------------------------------------------*/
/* Include =Portfolio Functions */
/*-----------------------------------------------------------------------------------*/

// global $of_set;
// if ( $of_set['portfolio'] == true ) :
include ('functions/portfolio-functions.php');
// endif;

/*-----------------------------------------------------------------------------------*/
/* Post =Metabox */
/*-----------------------------------------------------------------------------------*/

include ('functions/metabox-post.php');

/*-----------------------------------------------------------------------------------*/
/* Options =Framework */
/*-----------------------------------------------------------------------------------*/

require_once ('admin/index.php');


/*-----------------------------------------------------------------------------------*/
/* Options =Framework => Label */
/*-----------------------------------------------------------------------------------*/

// To be used as portfolio image label or whatever.
function framework_project_label( $post, $classes = array() ) {

	global $mav_data;

	$values = get_post_custom( $post->ID );
	$label = get_post_meta( get_the_ID(), 'label_select', true );
	$classes[] = 'project-label';

	switch ( $label ) {

		case( 'none' ) :
				return;
			break;

		case( 'free' ) :
			// echo( '<span class="project_label ' . $label . '"><img id="project-label-' . $post->post_name . '" class="' . implode( ' ', $classes) . '" src="' . $mav_data['project_free_label'] . '" alt="" /></span>' );
			echo( '<span class="project_label ' . $label . '"><img class="' . implode( ' ', $classes) . '" src="' . $mav_data['project_free_label'] . '" alt="' . $post->post_name . '" /></span>' );
			return;
		break;

		case( 'new' ) :
			// echo( '<span class="project_label ' . $label . '"><img id="project-label-' . $post->post_name . '" class="' . implode( ' ', $classes) . '" src="' . $mav_data['project_new_label'] . '" alt="" /></span>' );
			echo( '<span class="project_label ' . $label . '"><img class="' . implode( ' ', $classes) . '" src="' . $mav_data['project_new_label'] . '" alt="' . $post->post_name . '" /></span>' );
			return;
		break;

	}
}


/*-----------------------------------------------------------------------------------*/
/* Options =Framework => Default values */
/*-----------------------------------------------------------------------------------*/

function mav_framework_defaults() {

	$mav_data = get_option( 'mav_framework_options' );

	if ( ! isset( $mav_data ) )
		$mav_data = array();

	$temp_options = array();

	$mav_framework_defaults = array(
		"logo" => "",
		"tagline_text" => "",
		"contact_email"	=> "",
		"custom_favicon" => "",
		"custom_logo_login"	=> "",
		"google_analytics" => "",
		"layout" => "",
		"primary_color"	=> "",
		"secondary_color" => "",
		"selection_color" => "",
		"body_color" => "",
		"body_options" => "",
		"body_image" => "",
		"body_repeat" => "",
		"body_pos" => "",
		"custom_css" => "",
		"homepage_layout" => array(
			"disabled" => array(
				"placebo" => ""
			),
			"enabled" => array(
				"placebo" => "",
				"block_home_message" => "",
				"block_slider" => "",
				"block_portfolio"	=> "",
				"block_blog_posts" => "",
				"block_quote" => ""
			),
		),
		"home_message_title" => "",
		"home_message_text"	=> "",
		"blog_home_cat"	=> "",
		"blog_home_postperpage"	=> "",
		"portfolios_home_title" => "",
		"portfolios_home_page" => "",
		"portfolios_home_postperpage" => "",
		"projects_home_title" => "",
		"projects_home_page" => "",
		"projects_home_postperpage" => "",
		"slider_home" => array(
			1	=> array(
			  "order" => "",
			  "title" => "",
			  "url"	=> "",
			  "link" => "",
			  "link_behaviour" => "",
			  "description"	=> "",
			),
		),
		"slider_home" => "",
		"slider_height" => "",
		"slider_arrows" => "",
		"slider_buttons" => "",
		"related_posts"	=> "",
		"related_posts_perpage"	=> "",
		"posts_related_condition" => "",
		"portfolio_order_1"	=> "",
		"portfolio_order_2"	=> "",
		"related_projects" => "",
		"related_projects_perpage" => "",
		"portfolio_related_condition" => "",
		"project_free_label" => "",
		"project_new_label"	=> "",
		"footer_text_left"	=> "",
		"footer_text_right"	=> "",
		"portfolio_home_project" => "",
		"topbar_text" => "",
		"quote_text" => "",
		"portfolio_quote_text" => "",
		"portfolios_desc" => "",
		"projects_desc" => ""
	);


	foreach( $mav_framework_defaults as $key => $option ) {

		if( ! isset( $mav_data[$key] ) ) {
			if( is_array( $option ) ) {
				mav_framework_defaults_array_helper( $key, $option, $temp_options );
			} else {
				$temp_options[$key] = $option;
			}
				} else {

			if ( $mav_data[$key] != $option && $mav_data[$key] != "" ) {
				if( is_array( $option ) ) {
					mav_framework_defaults_array_helper( $key, $option, $temp_options );
				} else {
					$temp_options[$key] = $mav_data[$key];
				}
			}

		}

	}

	return $temp_options;
}

// Helper function for mav_framework_defaults()
function mav_framework_defaults_array_helper( $key, $option, $temp_options ) {

	foreach( $option as $k => $o ) {

		if( is_array( $o ) ) {
			mav_framework_defaults_array_helper( $k, $o, $temp_options );
		} else {
			$temp_options[$key][$k] = $o;
		}

	}

	return $temp_options;

}


/*-----------------------------------------------------------------------------------*/
/* Options =Framework => Flush + Remove Admin Editor */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'flush_xxx');

function flush_xxx() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

/*add_action('admin_menu', 'remove_menus', 102);
function remove_menus() {
	global $submenu;
	remove_submenu_page ( 'themes.php', 'theme-editor.php' ); // Appearance -> Editor
}*/


/*-----------------------------------------------------------------------------------*/
/* Options =Framework => Use This Media */
/*-----------------------------------------------------------------------------------*/

function use_image($safe_text, $text) {
	return str_replace( __( 'Insert into Post', 'framework' ), __( 'Use This Media', 'framework' ), $text);
}

add_filter("attribute_escape", "use_image", 10, 2);


/*-----------------------------------------------------------------------------------*/
/* STOP IMAGES BEING WRAPPED IN 'P' TAGS - http://www.wpfill.me/ */
/*-----------------------------------------------------------------------------------*/

function wpfme_remove_img_ptags($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'wpfme_remove_img_ptags');

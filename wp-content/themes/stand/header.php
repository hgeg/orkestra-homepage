<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php
	// Print the <title> tag based on what is being viewed.
	global $page, $paged, $mav_data;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'framework' ), max( $paged, $page ) );

	?></title>
	<meta name="description" content="" />
	<?php if ( $mav_data['responsive_layout'] ) { ?><meta name="viewport" content="width=device-width, initial-scale=1.0" /><?php } ?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if ie]><meta http-equiv="X-UA-Compatible" content="IE=10" /><![endif]-->
	<?php
		/* include jQuery */
		wp_enqueue_script('jquery');

		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use).
		 */
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
	?>
</head>

<body <?php body_class(); ?>>

	<?php
	global $mav_data; // fetch options stored in $mav_data
	if ( $mav_data['topbar'] ) { ?>
	<div id="topbar">
		<div class="wrapper clearfix">
			<?php if ( $mav_data['topbar'] && $mav_data['topbar_text'] ) { ?>
			<span class="topbar_text">
				<?php echo do_shortcode(stripslashes($mav_data['topbar_text'])); ?>
			</span>
			<?php } ?>
		</div> <!-- /end .wrapper -->
	</div> <!-- /end #topbar -->
	<?php } ?>

	<header id="header">
		<div class="wrapper clearfix">

			<section id="logo">
				<a href="<?php echo home_url(); ?>">
					<?php if ( $mav_data['logo_text'] ) { ?>
					<h1 id="site-title"><?php bloginfo( 'name' ); ?></h1>
					<?php } elseif ( $mav_data['logo'] ) { ?>
					<img src="<?php echo $mav_data['logo']; ?>" alt="<?php bloginfo( 'name' ); ?>"/>
					<?php } else { ?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" />
					<?php } ?>
				</a>
			</section> <!-- /end #logo -->

			<?php if ( $mav_data['tagline'] ) { ?><section id="tagline"><?php bloginfo( 'description' ); ?></section><?php } ?>

			<nav id="navi" role="navigation">
				<?php
				wp_nav_menu( array(
					'container_class' => 'custom-menu',
					'theme_location' => 'primary',
				) );

				// Generates a dropdown select element for navigation on mobile devices
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'fallback_cb' => '',
					'walker' => new Walker_Responsive_Menu(),
					'items_wrap' => '<select class="responsive_menu" onchange="window.location.href=this.value">%3$s</select>'
				) );
				?>

			</nav> <!-- /end #navi -->

		</div> <!-- /end .wrapper -->
	</header> <!-- /end #header -->	


	<div id="main">
		<div class="wrapper modular clearfix">

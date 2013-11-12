<?php

/* Template Name: Homepage */

get_header();

?>

<?php

global $of_set, $mav_data;

$layout = $mav_data['homepage_layout']['enabled'];

$mav_slider_height = $mav_data['slider_height'];

if ($layout):
	foreach ( $layout as $key=>$value ) {
		switch ( $key ) {
			case 'block_slider':
			if ( $of_set['slider'] == true ) :
		?>
		<section class="slider-home">
			<div class="wrapper clearfix" style="height:<?php echo $mav_slider_height ?>px">
			<?php get_template_part( '/inc/block_slider' ); ?>
			</div> <!-- /end .wrapper -->
		</section> <!-- /end .slider-home -->

		<?php
			endif;
			break;
			case 'block_home_message':
			// if ( $mav_data['home_message'] ) :
		?>
		<section id="home-message">
			<div class="wrapper clearfix">
			<?php get_template_part( '/inc/block_home_message' ); ?>
			</div> <!-- /end .wrapper -->
		</section> <!-- /end #home-message -->

		<?php
			// endif;
			break;
			case 'block_portfolio':
			if ( $of_set['portfolio'] == true ) :
		?>
		<section id="portfolio-home">
			<div class="wrapper clearfix">
			<?php get_template_part( '/inc/block_portfolios' ); ?>
			</div> <!-- /end .wrapper -->
		</section> <!-- /end #portfolio-home -->

		<?php
			endif; // $of_set
			break;
			case 'block_projects':
			if ( $of_set['portfolio'] == true ) :
		?>
		<section id="projects-home">
			<div class="wrapper clearfix">
			<?php get_template_part( '/inc/block_projects' ); ?>
			</div> <!-- /end .wrapper -->
		</section> <!-- /end #projects-home -->

		<?php
			endif; // $of_set
			break;
			case 'block_quote':
		?>
		<section id="home-quote">
			<div class="wrapper clearfix">
			<?php get_template_part( '/inc/block_quote' ); ?>
			</div> <!-- /end .wrapper -->
		</section> <!-- /end #home-quote -->

		<?php
			break;
			case 'block_blog_posts':
		?>
		<section id="blog-home">
			<div class="wrapper clearfix">
			<?php get_template_part( '/inc/block_blog_posts' ); ?>
			<?php get_sidebar(); ?>
			</div> <!-- /end .wrapper -->
		</section> <!-- /end #blog-home -->

		<?php
		break;
	}
}

endif;
?>

<?php get_footer(); ?>

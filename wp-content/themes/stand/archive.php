
<?php get_header(); ?>

<section id="content" role="main">

	<?php if ( have_posts() ) the_post(); ?>

	<header class="page-header">
		<h1 class="page-title">
			<?php if ( is_day() ) : ?>
			<?php printf( __( 'Daily Archives: <span>%s</span>', 'framework' ), get_the_date( 'l' ) ); ?>
			<?php elseif ( is_month() ) : ?>
			<?php printf( __( 'Monthly Archives: <span>%s</span>', 'framework' ), get_the_date( 'F Y' ) ); ?>
			<?php elseif ( is_year() ) : ?>
			<?php printf( __( 'Yearly Archives: <span>%s</span>', 'framework' ), get_the_date( 'Y' ) ); ?>

			<?php // Portfolio Custom Taxonmy Categories
				elseif( is_tax('portfolio_category') ) : {
				global $wp_query;
				$term = $wp_query->get_queried_object();
				$title = $term->name; ?>
				<?php _e( 'Portfolio Category Archives:', 'framework' ); ?><span><?php echo $title ?></span>
			<?php } ?>
			
			<?php // Portfolio Custom Taxonmy tags
				elseif( is_tax('portfolio_tag') ) : {
				global $wp_query;
				$term = $wp_query->get_queried_object();
				$title = $term->name; ?>
				<?php _e( 'Portfolio Tag Archives:', 'framework' ); ?><span><?php echo $title ?></span>
			<?php } ?>

			<?php else : ?>
			<?php _e( 'Archives:', 'framework' ); ?>
			<?php endif; ?>
		</h1>

	</header> <!-- /end .page-header -->

	<?php
		/* Since we called the_post() above, we need to
 	 	 * rewind the loop back to the beginning that way
 	 	 * we can run the loop properly, in full.
 	 	 */
		rewind_posts();

		/* Run the loop for the archives page to output the posts.
 	 	 * If you want to overload this in a child theme then include a file
 	 	 * called loop-archive.php and that will be used instead.
 	 	 */
 		get_template_part( 'loop', 'archive' );
	?>

</section> <!-- /end #content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>


<?php get_header(); ?>

<section id="content" role="main">

	<?php if ( have_posts() ) : ?>
	<header class="page-header">
		<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'framework' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	</header> <!-- /end .page-header -->
	
	<?php
		/* Run the loop for the search to output the results.
		 * If you want to overload this in a child theme then include a file
		 * called loop-search.php and that will be used instead.
		 * This theme already use loop-search.php
		 */
		 get_template_part( 'loop', 'search' );
	?>
	<?php else : ?>

	<h1 class="entry-title"><?php _e( 'Nothing Found', 'framework' ); ?></h1>
	<section class="entry-content">
		<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'framework' ); ?></p>
		<?php get_search_form(); ?>
	</section>

	<?php endif; ?>

</section> <!-- /end #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
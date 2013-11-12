
<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
<article id="post-0" class="post error404 not-found">
	<header><h1 class="entry-title"><?php _e( 'Nothing Found', 'framework' ); ?></h1></header>
	<section class="entry-content">
		<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'framework' ); ?></p>
		<?php get_search_form(); ?>
	</section>
</article> <!-- /end #post-## -->
<?php endif; ?>

<?php while ( have_posts() ) : the_post(); // the loop begins ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php

	// Load Post Formats
	$format = get_post_format();

		if ( false === $format )
			$format = 'standard';

	get_template_part( 'format', $format );

	?>

</article> <!-- #post-<?php the_ID(); ?> -->

<?php comments_template( '', true ); ?>

<?php endwhile; // the loop ends ?>

<?php wp_reset_query(); ?>

<?php
if(function_exists('wp_pagenavi')) {
	wp_pagenavi();
} else {
?>
<?php if ( $wp_query->max_num_pages > 1 ) : // display navigation to next/previous pages when applicable ?>
<nav id="navigation">
	<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older', 'framework' ) ); ?></div>
	<div class="nav-next"><?php previous_posts_link( __( 'Newer <span class="meta-nav">&rarr;</span>', 'framework' ) ); ?></div>
</nav>
<?php endif; ?>
<?php } ?>

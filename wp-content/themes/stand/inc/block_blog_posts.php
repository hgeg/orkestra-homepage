<?php
/**
 * Block Template for Homepage Blog Posts
 */
?>
<section id="content" role="main">

	<?php

	global $mav_data;

	$blog_home_postperpage = $mav_data['blog_home_postperpage'];
	$blog_home_cat = $mav_data['blog_home_cat'];

	$cat_term_id = get_cat_ID( $blog_home_cat );
	
	// https://codex.wordpress.org/Pagination#static_front_page
	if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
	elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
	else { $paged = 1; }

	$args = array(
		'paged' => $paged,
		'posts_per_page'=> $blog_home_postperpage
	);

	/* sticky solution starts */
	function setcat_pre_posts($query) {
		global $mav_data;
		$blog_home_cat = $mav_data['blog_home_cat'];
		$cat_term_id = get_cat_ID( $blog_home_cat );	
		if ($query->is_home) {
			$query->set('category__in', $cat_term_id);
		}
		return $query;

	}
	// add_filter('pre_get_posts', 'setcat_pre_posts'); // warning: generates footer menu crash
	/* sticky solution ends */

	query_posts( $args );

	?>

	<?php global $more; // Declare global $more (before the loop). ?>

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

	<?php $more = 0; // Set (inside the loop) to display content above the more tag. ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<?php

		// Load Post Formats
		$format = get_post_format();

			if ( false === $format )
				$format = 'standard';

		get_template_part( 'format', $format );

		?>
		
	</article> <!-- #post-<?php the_ID(); ?> -->

	<?php endwhile; // the loop ends ?>


	<?php
	// Hide pagination if the homepage is used as a static page.
	/*if ( 'page' == get_option( 'show_on_front' ) ) :
	// do nothing
	else : */?>

	<?php
	// Check if wp-pagenavi plugin is installed
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

	<?php /*endif;*/ // Hide pagination ?>

	<?php wp_reset_query(); ?>

</section> <!-- /end #content -->


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

	<header class="entry-meta">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'framework' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

		<span class="posted-on"><?php
		printf( __( 'Posted on <a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a> <span class="by-author">by <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s" rel="author">%6$s</a></span></span>', 'framework' ),
			esc_url( get_permalink() ),
			get_the_date( 'c' ),
			get_the_date(),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'framework' ), get_the_author() ) ),
			get_the_author()
		);
		?></span>
	</header> <!-- /end header.entry-meta -->


	<section class="entry-content">
		<?php

		// If we are using the Portfolio feature
		global $of_set;
		if ( $of_set['portfolio'] == true ) :


		if ( false != get_the_term_list( $post->ID, 'portfolios' ) ) :

			$custom = get_post_custom($post->ID);
			$project_img_ID = $custom["project_img_ID"][0];
			$thumb_ID = $project_img_ID;
			$thumb = wp_get_attachment_image( $thumb_ID, 'mav-related-thumbnails', false, array( 'class' => 'portfolios_post_image_thumb portfolio-image', 'alt' =>  $post->post_title ) );		
		?>
		<?php if ( $project_img_ID ) { ?>
		<figure class="search-thumb">
			<a href="<?php the_permalink() ?>" rel="bookmark">
				<span class="overlay"></span>
				<?php echo $thumb; ?>
			</a>
		</figure>
		<?php } ?>
		<?php endif; ?>

		<?php endif; // $of_set - If we are using the Portfolio feature ?>

		<?php if ( has_post_thumbnail() ) : ?>
		<figure class="search-thumb">
			<a href="<?php the_permalink() ?>" rel="bookmark">
				<span class="overlay"></span>
				<?php the_post_thumbnail(); ?>
			</a>
		</figure>
		<?php endif; ?>

		<?php the_excerpt(); ?>

	</section> <!-- /end .entry-content -->


	<footer class="entry-meta">
		<?php

		// If we are using the Portfolio feature
		global $of_set;
		if ( $of_set['portfolio'] == true ) {
		//

		if ( false != get_the_term_list( $post->ID, 'portfolios' ) ) { ?>

			<span class="portfolios-links">
			<?php echo 'Portfolio' . get_the_term_list( $post->ID, 'portfolios', ' ', ', ', '' ); ?>
			</span>

			<br/>
			<span class="cat-links">
				<?php
				$project_categories = wp_get_object_terms($post->ID, 'project_category');
				if ($project_categories) {
					_e( 'Posted in ', 'framework' );
					$project_category = array();
					foreach($project_categories as $category) {
						$project_category[] = '<a href="'.get_home_url().'/?project_category=' . $category->slug . '">' . $category->name . '</a>';
					}
					echo implode(', ', $project_category);
				}
				?>
			</span> <!-- /end .cat-links -->
			<br/>

			<?php // project Tags
			$project_tags = wp_get_object_terms($post->ID, 'project_tag');
			if ($project_tags) {
				$project_tag = array();
				foreach($project_tags as $tag) {
					$project_tag[] = '<a href="'.get_home_url().'/?project_tag=' . $tag->slug . '">' . $tag->name . '</a>';
				} ?>
			<span class="tag-links">
				<span><?php _e( 'Tagged', 'framework' ); ?> <?php echo implode(', ', $project_tag); ?></span>
			</span> <!-- /end .tag-links -->
			<?php } ?>

			<?php } // If we are using the Portfolio feature ?>

			<?php

			} else {

			if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search
			$categories_list = get_the_category_list( __( ', ', 'framework' ) );
			if ( $categories_list ): ?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %2$s', 'framework' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list ); ?>
			</span>
			<?php endif; // if categories /ends ?>

			<!-- <span class="sep">/</span> --><br/>
			<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'framework' ) );
			if ( $tags_list ): ?>
			<span class="tag-links">
				<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'framework' ), '', $tags_list ); ?>
			</span>
			<?php endif; // if $tags_list /ends ?>

			<?php endif; // if 'post' == get_post_type() /ends

		}

		?>
	</footer> <!-- /end footer.entry-meta -->


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

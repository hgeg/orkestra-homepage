
<section id="related-posts">

	<h3 class="related-title"><span class="title-bg"><?php _e( 'You may also like', 'framework' ); ?></span></h3>

	<section class="related-list">

		<?php

		global $mav_data; // fetch options stored in $mav_data
		$showposts = $mav_data['related_posts_perpage'];

		global $post;

		$tags = wp_get_post_terms( $post->ID , array('post_tag') );
		$cats = wp_get_post_terms( $post->ID , array('category') );

		if ( count( $tags ) >= 0 && ! empty( $tags ) ) {
			foreach($tags as $tag) $tag_slugs[] = $tag->slug;
		} else {
			$tag_slugs = array('');
		}
		if ( count( $cats ) >= 0 && ! empty( $cats ) ) {
			foreach($cats as $cat) $cat_slugs[] = $cat->slug;
		} else {
			$cat_slugs = array('');
		}

		// Check what terms to use for related articles
		switch ( $mav_data['posts_related_condition'] ) {

			case "Tags":
			$taxonomy = array('post_tag');
		
		break;

			case "Categories":
			$taxonomy = array('category');
		
		break;
			
			case "Tags + Categories":
			$taxonomy = array('post_tag','category');

		break;
		
		}

		if (empty($taxonomy)) : $taxonomy = ''; endif; // DAHEX

		$terms = wp_get_object_terms($post->ID, $taxonomy);

		if ($terms) {
			$terms_ids = array();
			foreach($terms as $term) $terms_ids[] = $term->term_id;
			foreach($taxonomy as $taxy)
				$tax_query[] = array(
					'taxonomy' => $taxy,
					'field' => 'id',
					'terms' => $terms_ids
				);

			if ( $taxonomy = array('post_tag','category') ) {

				$args =  array(
					'post_type' => 'post',
					'post__not_in' => array($post->ID),
					'posts_per_page' => $showposts,
					'tax_query' => array(
						'relation' => 'OR',
						array(
							'taxonomy' => 'post_tag',
							'field' => 'slug',
							'terms' => $tag_slugs
						),
						array(
							'taxonomy' => 'category',
							'field' => 'slug',
							'terms' => $cat_slugs
						)
					)
				);

			} else {

				$args = array(
					'relation' => 'OR',
					'post_type' => 'post',
					'post__not_in' => array($post->ID),
					'posts_per_page' => $showposts,
					'ignore_sticky_posts' => 1,
					'tax_query'	=> $tax_query
				);

			}

			$my_query = new WP_Query( $args );

			if( $my_query->have_posts() ) {

				while( $my_query->have_posts() ) {
					$my_query->the_post();
		?>

		<figure class="related-item">
			<?php if ( has_post_thumbnail() ) { ?>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
				<span class="overlay">
					<span class="view"><?php _e( 'View', 'framework' ); ?></span>
				</span>
				<?php the_post_thumbnail(); ?>
			</a>
			<?php } else { ?>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
				<span class="overlay">
					<span class="view"><?php _e( 'View', 'framework' ); ?></span>
				</span>
				<img src="<?php echo get_template_directory_uri(); ?>/images/thumb.png" alt="<?php the_title_attribute(); ?>" />
			</a>
			<?php } ?>
			<h4 class="entry-title">
				<a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>">
					<?php
					$thetitle = $post->post_title;
					$getlength = strlen($thetitle);
					$thelength = 50;
					echo substr($thetitle, 0, $thelength);
					if ($getlength > $thelength) echo "...";
					?>
				</a>
			</h4> <!-- /end .entry-title -->

			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search
				
				$categories_list = get_the_category_list( ' ', '', get_the_ID() );
				if ( $categories_list ): ?>
				<span class="cat-links">
				<?php printf( __( '%2$s', 'framework' ), '', $categories_list ); ?>
				</span><?php endif; // if categories /ends ?>
				<?php
				$tag_list = get_the_tag_list( __('Tagged: ', 'framework'), ', ', '' );
				if ( $tag_list ): ?>
				<span class="tag-links">
				<?php printf( __( '%2$s', 'framework' ), '', $tag_list ); ?>
				</span><?php endif; // if tags /ends ?>

			<?php endif; // if 'post' == get_post_type() /ends ?>

		</figure> <!-- /end .related-item -->

	<?php
			}
		}
	} else {
		echo 'No posts found';
	}

	// Restore original Query & Post Data
	wp_reset_query();
	wp_reset_postdata();

	?>

	</section> <!-- /end .related-list -->

</section> <!-- /end #related-posts -->

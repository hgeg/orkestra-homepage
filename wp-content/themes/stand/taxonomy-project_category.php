<?php
/**
 * Taxonomy Template for the Project Categories
 */
?>

<?php get_header(); ?>

<?php

if ( $post ) :

	$c = wp_get_post_terms( $post->ID , array('project_category') );
	$category = $c[0];

	$post_img_width = 300;
	$post_img_height = 210;

	global $mav_data; // fetch options stored in $mav_data

	$tax_query[] = array(
		'taxonomy' => 'project_category',
		'field' => 'slug',
		'terms' => array( $category->slug )
	);

	$args = array(
		'post_type' => 'project',
		'posts_per_page' => -1,
		'tax_query'	=> $tax_query
	);

	$port_query = new WP_Query($args);

	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	// print_r($term)

?>

	<section id="content" class="portfolio one-column" role="main">

		<header class="page-header">

			<h1 class="page-title"><?php _e( 'Current Category:', 'framework' ); ?> <span><?php echo( $term->name ); ?></span></h1>

			<?php if ($category->description) { ?><p class="portfolio-header-description"><?php echo( $category->description ); ?></p><?php } ?>

			<?php

			$temp = array();

			foreach ( $posts as $post ) {

				$temp_args = array();

				while ($port_query->have_posts()) : $port_query->the_post(); // the loop begins, we need it here. It's important!!

				$temp_tags = wp_get_object_terms( $post->ID, 'project_tag'/*, $args*/ );

				if ( $temp_tags ) {
					foreach ( $temp_tags as $temp_tag ) {
						if ( ! in_array( $temp_tag->slug, $temp ) ) {
							$temp[] = $temp_tag->slug;
							$tags[] = $temp_tag;
						}
					}
				}

				endwhile;

			}


			// DAHEX
			$temp = array();

			if ( isset($tags) ) {
				foreach ( $tags as $tag ) {
					$temp[] = array ('term_id'=>$tag->term_id,'name'=>$tag->name,'slug'=>$tag->slug,'term_group'=>$tag->term_group,'term_taxonomy_id'=>$tag->term_taxonomy_id,'taxonomy'=>$tag->taxonomy,'description'=> $tag->description,'parent'=>$tag->parent,'count'=> $tag->count);
				}
			}

			usort($temp, array(new Sorter('slug'), 'sort')); // Sorting Array by slug

			$tags = array();
			foreach ( $temp as $tag ){
				$tags[] =(object) $tag;
			}
			// DAHEX

			
			if ( isset($tags) ) {

				echo( '<ul id="filters" class="option-set">
					<li><a href="#" data-filter="*" class="show-all selected">All</a></li>' );
				
				foreach ( $tags as $tag ) {
					echo '<li><span class="sep">/</span><a href="#' . $tag->slug . '" data-filter=".' . $tag->slug . '">' . $tag->name . '</a></li>';
				}

				echo( '</ul> <!-- /end #filters -->' );

			} else {
				echo '<span class="ooops">';
				_e( 'Ooops! nothing found...', 'framework' );
				echo '</span>';
			}
			?>
		</header> <!-- /end .page-header -->

		<section id="projects">
			<?php
			while ($port_query->have_posts()) : $port_query->the_post(); // the loop begins
			$terms = get_the_terms( get_the_ID(), 'project_tag' );
			$terms = $terms == false ? array() : $terms;
			?>

			<?php
			$custom = get_post_custom($post->ID);
			$project_img = $custom["project_img"][0];
			$project_img_ID = $custom["project_img_ID"][0];
			$project_permalink = $custom["project_permalink"][0];
			$project_desc = $custom["project_desc"][0];

			// Need some proof check to ensure that no "notice" is thrown ...
			if ( ! empty( $post ) ) {

				$term_slug = $post->post_name;

				if ( isset( $custom["lightbox_path"][0] ) ) {
					$lightbox_path = $custom["lightbox_path"][0];
				} else {
					$lightbox_path = '';
				}

				$empty_thumb = '<img class="portfolios_single_thumb portfolio-image" src="' . get_template_directory_uri() . '/images/thumb.png" width="' . $post_img_width . '" height="' . $post_img_height . '" alt="' . $post->post_title . '" />';

				if ( isset( $project_img_ID ) ) {

					if ( is_numeric( $project_img_ID ) ) {

						$thumb_ID = $project_img_ID;
						$thumb = wp_get_attachment_image( $thumb_ID, 'mav-thumbnails', false, array( 'class' => 'portfolios_post_image_thumb portfolio-image', 'alt' =>  $post->post_title ) );

						if ( empty ($thumb) ) {
							$thumb = $empty_thumb;
						}

					} elseif( $project_img_ID != "" ) {
						
						$thumb = '<div class="project_iframe_thumb-$term_slug"><iframe width="' . $post_img_width . '" height="' . $post_img_height . '" src="' . $project_img . '" title="' . $project_img_ID . '" frameborder="0" allowfullscreen></iframe></div>';

					} else {

						$thumb = $empty_thumb;

					}

				} else {
					$thumb = $empty_thumb;
				}

			}
			?>

			<article id="project-<?php the_ID(); ?>" class="element <?php foreach ($terms as $term) { echo strtolower(preg_replace('/\s+/', '-', $term->slug)). ' '; } ?>">

				<?php
				/**
				 * Generate the Project Image (Thumb)
				 */
				if ( $lightbox_path != '' ) { ?>
				<div class="lightbox">
					<a href="<?php echo $lightbox_path ?>" data-rel="prettyPhoto" title="<?php the_title_attribute(); ?>">
						<span class="overlay lightbox"></span>
						<?php framework_project_label( $post, array( 'portfolios-project-label' ) ); ?>
						<?php echo( $thumb ); ?>
					</a>
				</div>
				<?php
				} elseif ($project_permalink) {
				?>
				<a target="_blank" href="<?php echo $project_permalink ?>" rel="bookmark">
					<span class="overlay link"></span>
					<?php framework_project_label( $post, array( 'portfolios-project-label' ) ); ?>
					<?php echo( $thumb ); ?>
				</a>
				<?php } else { ?>
				<a href="<?php the_permalink() ?>" rel="bookmark">
					<span class="overlay">
						<span class="view"><?php _e( 'View', 'framework' ); ?></span>
					</span>
					<?php framework_project_label( $post, array( 'portfolios-project-label' ) ); ?>
					<?php echo( $thumb ); ?>
				</a>
				<?php } // end Generate the Project Image (Thumb) ?>

				<h3 class="entry-title">
					<?php if ($project_permalink) { ?>
					<a target="_blank" href="<?php echo $project_permalink ?>" rel="bookmark"><?php the_title(); ?></a>
					<?php } else { ?>
					<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
					<?php } ?>
				</h3>

				<?php if ($project_desc) { ?><p class="project-description"><?php echo do_shortcode(stripslashes($project_desc)); ?></p><?php } ?>

				
				<footer class="entry-meta">

					<?php
					$project_categories = wp_get_object_terms($post->ID, 'project_category');
					if ($project_categories) { ?>
					<span class="cat-links">
						<?php
							// _e( 'Posted in ', 'framework' );
							$project_category = array();
							foreach($project_categories as $category) {
								$project_category[] = '<a href="'.get_home_url().'/?project_category=' . $category->slug . '">' . $category->name . '</a>';
							}
							echo implode(' ', $project_category);
						?>
					</span> <!-- /end .cat-links -->
					<br/> <!-- Stand -->
					<?php } ?>

					<span class="posted-on"><?php _e( 'Posted on', 'framework' ); ?> <a href="<?php the_permalink() ?>"><?php /* http://codex.wordpress.org/Formatting_Date_and_Time */ echo get_the_date('F j, Y'); ?></a></span>

					<?php // Project Tags
					$project_tags = wp_get_object_terms($post->ID, 'project_tag');
					if ($project_tags) {
						$project_tag = array();
						foreach($project_tags as $tag) {
							$project_tag[] = '<a href="'.get_home_url().'/?project_tag=' . $tag->slug . '">' . $tag->name . '</a>';
						} ?>
						<span class="tag-links">
							<span><?php _e( 'Tagged: ', 'framework' ); ?> <?php echo implode(', ', $project_tag); ?></span>
						</span> <!-- /end .tag-links -->
					<?php } ?>

				</footer> <!-- /end .entry-meta -->


			</article> <!-- /end #project-<?php the_ID(); ?> .element -->

			<?php endwhile; ?>

			<?php wp_reset_query(); ?>

		</section> <!-- /end #projects -->

	</section> <!-- /end #content -->

<?php endif; ?>

<?php get_footer(); ?>

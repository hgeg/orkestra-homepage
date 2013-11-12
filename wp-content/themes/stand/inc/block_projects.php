<?php
/**
 * Block Template for Homepage Projects
 */
?>
<?php

if ( $post ) :

	$port = get_terms('portfolios', 'orderby=none&hide_empty=0');

	if ( count( $port ) <= 0 ) :
	echo 'No items to show at this time. To to use the Portfolios &amp; Projects feature go to Projects -> Portfolios and create at least one Portfolio.
		Then create some Projects and assign them to a Portfolio.';
	return;
	endif;

	$portfolio = $port[0];
	$post_img_width = 300;
	$post_img_height = 210;
	
	// The Portfolio extra fields (all portfolios extra fields ar stored in an options array, so we need to take only our current portfolio`s options)
	$tag_extra_fields = get_option('portfolios_fields');
	$portfolios_fields = $tag_extra_fields[$portfolio->term_id];

	global $mav_data; // fetch options stored in $mav_data

	$projects_home_title = $mav_data['projects_home_title'];
	$portfolio_order_1 = $mav_data['portfolio_order_1']; // date, title
	$portfolio_order_2 = $mav_data['portfolio_order_2']; // ASC, DESC
	$projects_home_postperpage = $mav_data['projects_home_postperpage'];
	$portfolio_home_project = $mav_data['portfolio_home_project'];

	$projects_desc = $mav_data['projects_desc'];

	if ($portfolio_home_project == 'Select a portfolio:') {
		$tax_query = get_terms('portfolios', 'orderby=none&hide_empty=0');
		// echo $tax_query[0]->name;
	} else {
		$tax_query[] = array(
			'taxonomy' => 'portfolios',
			'field' => 'slug',
			'terms' => array( $portfolio_home_project )
		);
	}

	$args = array(
		'post_type' => 'project',
		'posts_per_page' => $projects_home_postperpage,
		'orderby' => $portfolio_order_1,
		'order' => $portfolio_order_2,
		'tax_query'	=> $tax_query
	);

	$port_query = new WP_Query($args);

?>

	<header class="page-header">

		<?php if ($projects_home_title) { ?><h1 class="entry-title"><?php echo do_shortcode(stripslashes($projects_home_title)); ?></h1><?php } ?>
		<?php if ($projects_desc) { ?><p class="portfolio-header-description"><?php echo do_shortcode(stripslashes( $projects_desc )); ?></p><?php } ?>

		<?php

		if ($portfolio_home_project == 'Select a portfolio:') :
		// nothing to show...
		else :

			if ( is_front_page() ) :
				while ($port_query->have_posts()) : $port_query->the_post(); // the loop begins, we need it here. It's important!!
				$portfolio_terms = wp_get_object_terms($post->ID, 'portfolios');
				endwhile;
			else :
				// get the post ID outside the loop
				// global $port_query;
				// $postID = $port_query->post->ID;

				// $portfolio_terms = wp_get_object_terms($postID, 'portfolios');
				$portfolio_terms = wp_get_object_terms($post->ID, 'portfolios');
			endif;

			// echo $post->ID;

			if(!empty($portfolio_terms)) {

				if(!is_wp_error( $portfolio_terms )) {

					foreach($portfolio_terms as $portfolio) {
						if ($portfolio->description) {
							echo '<p class="portfolio-header-description">' . $portfolio->description . '</p>';
						}
					}

				}

			}

		endif;
		?>

		<?php

		$temp = array();

		foreach ( $posts as $post ) {

			$temp_args = array();

			while ($port_query->have_posts()) : $port_query->the_post(); // the loop begins, we need it here. It's important!!		// MAV only if $post->ID

			$temp_cats = wp_get_object_terms( $post->ID, 'project_category'/*, $args*/ );

			if ( $temp_cats ) {
				foreach ( $temp_cats as $temp_cat ) {
					if ( ! in_array( $temp_cat->slug, $temp ) ) {
						$temp[] = $temp_cat->slug;
						$categories[] = $temp_cat;
					}
				}
			}

			endwhile;

		}

		// DAHEX
		$temp = array();

		if(!empty($categories)) {
			foreach ( $categories as $category ) {
				$temp[] = array ('term_id'=>$category->term_id,'name'=>$category->name,'slug'=>$category->slug,'term_group'=>$category->term_group,'term_taxonomy_id'=>$category->term_taxonomy_id,'taxonomy'=>$category->taxonomy,'description'=> $category->description,'parent'=>$category->parent,'count'=> $category->count);
			}
		}

		usort($temp, array(new Sorter('slug'), 'sort')); // Sorting Array by slug

		$categories = array();
		foreach ( $temp as $category ){
			$categories[] =(object) $category;
		}
		// DAHEX


		if(!empty($categories)){

			if(!is_wp_error( $categories )){

				echo( '<ul id="filters" class="option-set">
				<li><a href="#" data-filter="*" class="show-all selected">All</a></li>' );
				
				foreach ( $categories as $category ) {
					// $category_link = get_category_link( $category->term_id );
					echo '<li><span class="sep">/</span><a href="#' . $category->slug . '" data-filter=".' . $category->slug . '">' . $category->name . '</a></li>';
				}

				echo( '</ul> <!-- /end #filters -->' );
			
			} else {
				echo '<span class="ooops">';
				_e( 'Ooops! nothing found...', 'framework' );
				echo '</span>';
			}
		}
		// print_r($categories); // debugging...
		?>
	</header> <!-- /end .page-header -->

	<section id="projects">

		<?php
		while ($port_query->have_posts()) : $port_query->the_post(); // the loop begins
		$terms = get_the_terms( get_the_ID(), 'project_category' );
		$terms = $terms == false ? array() : $terms;
		?>

		<?php
		$custom = get_post_custom($post->ID);

		$portfolio_permalink = $custom["project_permalink"][0];
		$portfolio_desc = $custom["project_desc"][0];

		if ( !isset( $lightbox_path ) ) {
			$lightbox_path = '';
		}

		// Prepare Project Image Thumb
		$project_img = $custom["project_img"][0];
		$project_img_ID = $custom['project_img_ID'][0];


		// Thumbs etc..
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

				$thumb = '<div class="project_iframe_thumb"><iframe width="' . $post_img_width . '" height="' . $post_img_height . '" src="' . $project_img . '" title="' . $project_img_ID . '" frameborder="0" allowfullscreen></iframe></div>';

			} else {

				$thumb = $empty_thumb;

			}

		} else {
			$thumb = $empty_thumb;
		}
		?>

		<article id="project-<?php the_ID(); ?>" class="element <?php foreach ($terms as $term) { echo strtolower(preg_replace('/\s+/', '-', $term->slug)). ' '; } ?>">

			<?php /* if ($label) { ?>
			<span href="<?php the_permalink() ?>" class="entry-format <?php echo $label ?>"><?php _e( $label, 'framework' ); ?></span>
			<?php } */ ?>

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
			} elseif ($portfolio_permalink) {
			?>
				<a target="_blank" href="<?php echo $portfolio_permalink ?>" rel="bookmark">
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
				<?php if ($portfolio_permalink) { ?>
				<a target="_blank" href="<?php echo $portfolio_permalink ?>" rel="bookmark"><?php the_title(); ?></a>
				<?php } else { ?>
				<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
				<?php } ?>
			</h3>

			<?php if ($portfolio_desc) { ?><p class="project-description"><?php echo do_shortcode(stripslashes($portfolio_desc)); ?></p><?php } ?>


			<footer class="entry-meta">
				
				<?php // show to which portfolio they are associated to...
				if ($portfolio_home_project == 'Select a portfolio:') { ?>
					<?php // http://codex.wordpress.org/Function_Reference/wp_get_object_terms
					$portfolio_terms = wp_get_object_terms($post->ID, 'portfolios');
					if(!empty($portfolio_terms)){ ?>
						<span class="cat-links portfolio-links">
						<?php
						if(!is_wp_error( $portfolio_terms )) {
							$project_category = array();
							foreach($portfolio_terms as $term) {
								$project_category[] = '<a href="'.get_term_link($term->slug, 'portfolios').'">'.$term->name.'</a>';
							}
							echo implode(' ', $project_category);
						}
						?>
						</span> <!-- /end .cat-links portfolio-links -->
						<br/> <!-- Stand -->
					<?php }
				} ?>

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

<?php endif; ?>

<?php
global $mav_data; //fetch options stored in $mav_data
global $post;

$showposts = $mav_data['related_projects_perpage'];

/*$portfolio_order_1 = $mav_data['portfolio_order_1']; // date, title
$portfolio_order_2 = $mav_data['portfolio_order_2']; // ASC, DESC*/

$post_img_width = 193;
$post_img_height = 135;

global $post;

$tags = wp_get_post_terms( $post->ID , array('project_tag') );
$cats = wp_get_post_terms( $post->ID , array('project_category') );
$ports = wp_get_post_terms( $post->ID , array('portfolios') );

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
if ( count( $ports ) >= 0 && ! empty( $ports ) ) {
	foreach($ports as $port) $port_slugs[] = $port->slug;
} else {
	$port_slugs = array('');
}

$do_not_duplicate[] = $post->ID;

switch ( $mav_data['portfolio_related_condition'] ) {

	case "Tags + Categories":

		$args =  array(
				'post_type' => 'project',
				'posts_per_page'	=> $showposts,
				// 'order'	=> $portfolio_order_2,
				// 'orderby'	=> $portfolio_order_1,
				'post__not_in' => array($post->ID),
				'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'project_tag',
						'field' => 'slug',
						'terms' => $tag_slugs
					),
					array(
						'taxonomy' => 'project_category',
						'field' => 'slug',
						'terms' => $cat_slugs
					)
				)
			);
		break;

	case "Tags":

		$args =  array(
				'post_type' => 'project',
				'posts_per_page'	=> $showposts,
				// 'order'	=> $portfolio_order_2,
				// 'orderby'	=> $portfolio_order_1,
				'post__not_in' => array($post->ID),
				'tax_query' => array(
					array(
						'taxonomy' => 'project_tag',
						'field' => 'slug',
						'terms' => $tag_slugs
					)
				)
			);
		break;

	case "Categories":

		$args =  array(
				'post_type' => 'project',
				'posts_per_page'	=> $showposts,
				// 'order'	=> $portfolio_order_2,
				// 'orderby'	=> $portfolio_order_1,
				'post__not_in' => array($post->ID),
				'tax_query' => array(
					array(
						'taxonomy' => 'project_category',
						'field' => 'slug',
						'terms' => $cat_slugs
					),
				)
			);
		break;

	case "Current Portfolio":

		$args =  array(
				'post_type' => 'project',
				'posts_per_page'	=> $showposts,
				// 'order'	=> $portfolio_order_2,
				// 'orderby'	=> $portfolio_order_1,
				'post__not_in' => array($post->ID),
				'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'portfolios',
						'field' => 'slug',
						'terms' => $port_slugs
					)
				)
			);
		break;

}

if (empty($args)) { $args = ''; } // DAHEX

$my_query = new wp_query( $args );

?>

<section id="related-projects">

	<h3 class="related-title"><span class="title-bg"><?php _e( 'Similar Projects', 'framework' ); ?></span></h3>

	<section class="related-list">

		<?php
		
		/*if ( ! empty( $my_query->posts ) ) :*/ // Mav
		
		if( $my_query->have_posts() ) {

			while( $my_query->have_posts() ) {
				$my_query->the_post();

				// Defines the variables from portfolio meta-box
				$custom = get_post_custom($post->ID);
				$project_img = $custom["project_img"][0];
				$project_img_ID = $custom["project_img_ID"][0];
				$project_link = $custom["project_link"][0];
				$project_link_text = $custom["project_link_text"][0];
				$label = get_post_meta( get_the_ID(), 'label_select', true );
				$portfolio_desc = $custom["project_desc"][0]; 

				// Need some proof check to ensure that no "notice" is thrown...
				if ( ! empty( $post ) ) {

					$term_slug = $post->post_name;

					if ( isset( $custom["lightbox_path"][0] ) ) {
						$lightbox_path = $custom["lightbox_path"][0];
					} else {
						$lightbox_path = '';
					}

					$empty_thumb = '<img id="portfolios_related_thumb-$term_slug" class="portfolios_related_thumb portfolio-image" src="' . get_template_directory_uri() . '/images/thumb.png" width="' . $post_img_width . '" height="' . $post_img_height . '" alt="' . $post->post_title . '" />';

					if ( isset( $project_img_ID ) ) {

						if ( is_numeric( $project_img_ID ) ) {

							$thumb_ID = $project_img_ID;
							$thumb = wp_get_attachment_image( $thumb_ID, 'mav-related-thumbnails', false, array( 'id' => "portfolios_related_thumb-$term_slug", 'class' => 'portfolios_related_post_image_thumb portfolio-image', 'alt' =>  $post->post_title ) );

							if ( empty ($thumb) ) {
								$thumb = $empty_thumb;
							}
						
						} elseif( $project_img_ID != "" ) {

							$thumb = '<div class="project_iframe_thumb-$term_slug"><iframe id="portfolios_related_thumb-$term_slug" width="' . $post_img_width . '" height="' . $post_img_height . '" src="' . $project_img . '" title="' . $project_img_ID . '" frameborder="0" allowfullscreen></iframe></div>';

						} else {

							$thumb = $empty_thumb;

						}

					} else {
						$thumb = $empty_thumb;
					}

				}
		?>

		<figure class="related-item">

			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
				<span class="overlay">
					<span class="view"><?php _e( 'View', 'framework' ); ?></span>
				</span>
				<?php framework_project_label( $post, array( 'related-project-label' ) ); ?>
				<?php echo( $thumb ); ?>
			</a>

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

			<p class="desc"><?php echo $portfolio_desc; ?></p>

		</figure> <!-- /end .related-item -->

		<?php

		}

	} else {
		echo 'No projects found';
	}

	// Restore original Query & Post Data
	wp_reset_query();
	wp_reset_postdata();

	?>
	
	<?php /*endif; */?>
	
	</section> <!-- /end .related-list -->

</section> <!-- /end #related-projects -->


<?php get_header(); ?>

	<?php if ( have_posts() ) the_post(); ?>

	<?php
	// Defines the variables from portfolio meta-box
	$custom = get_post_custom($post->ID);
	$project_img = $custom["project_img"][0];
	$project_img_ID = $custom["project_img_ID"][0];
	$client_name = $custom["client_name"][0];
	$client_name_link = $custom["client_name_link"][0];
	$portfolio_desc = $custom["project_desc"][0];
	$project_link = $custom["project_link"][0];
	$project_link_text = $custom["project_link_text"][0];
	$field_1 = $custom["field_1"][0];
	$field_2 = $custom["field_2"][0];
	$field_3 = $custom["field_3"][0];
	$field_4 = $custom["field_4"][0];
	$field_5 = $custom["field_5"][0];
	$field_6 = $custom["field_6"][0];
	$field_7 = $custom["field_7"][0];
	$field_8 = $custom["field_8"][0];
	$field_9 = $custom["field_9"][0];
	$label = get_post_meta( get_the_ID(), 'label_select', true );
	$img_copyrights = $custom["img_copyrights"][0];
	$img_copyrights_link = $custom["img_copyrights_link"][0];

	$post_img_width = 940;
	$post_img_height = 705;

	// Need some proof check to ensure that no "notice" is thrown ...
	if ( ! empty( $post ) ) {

		$term_slug = $post->post_name;

		if ( isset( $custom["lightbox_path"][0] ) ) {
			$lightbox_path = $custom["lightbox_path"][0];
		} else {
			$lightbox_path = '';
		}

		$empty_thumb = '<img class="portfolios_single_thumb project-image" src="' . get_template_directory_uri() . '/images/thumb.png" width="' . $post_img_width . '" height="' . $post_img_height . '" alt="' . $post->post_title . '" />';

		if ( isset( $project_img_ID ) ) {

			if ( is_numeric( $project_img_ID ) ) {

				$thumb_ID = $project_img_ID;
				$thumb = wp_get_attachment_image( $thumb_ID, 'mav-single-thumbnails', false, array( 'class' => 'portfolios_post_image_thumb portfolio-image', 'alt' =>  $post->post_title ) );

				/*if ( empty ($thumb) ) {
					$thumb = $empty_thumb;
				}*/

			} elseif( $project_img_ID != "" ) {

				$thumb = '<div class="project_iframe_thumb"><iframe width="' . $post_img_width . '" height="' . $post_img_height . '" src="' . $project_img . '" title="' . $project_img_ID . '" frameborder="0" allowfullscreen></iframe></div>';

			} else {

				$thumb = $empty_thumb;

			}

		} else {
			$thumb = $empty_thumb;
		}

	}

?>

<section id="project-content">

	<article id="project-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php
		if ( $thumb && $project_img ) {
			echo( '<div class="single_thumb_wrapper">' );
				framework_project_label($post); ?>
				<?php if ($img_copyrights) : ?><span class="img_copyrights"><?php endif; ?>
				<?php if ($img_copyrights_link) : ?><a href="<?php echo $img_copyrights_link; ?>" target="_blank"><?php echo $img_copyrights; ?></a><?php endif; ?>
				<?php if ($img_copyrights) : ?></span><?php endif; ?>
				<?php
				echo( $thumb );
			echo( '</div>' );
		}
		?>

		<header class="project-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php if ($portfolio_desc) { ?><p class="project-description"><?php echo $portfolio_desc ?></p><?php } ?>
		</header> <!-- /end .project-header -->

		<section class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'framework' ), 'after' => '</div>' ) ); ?>
		</section> <!-- /end .entry-content -->

		<footer class="entry-meta">

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
			<?php } ?>

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
			<?php } ?>

			<?php // project Tags
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

		<?php if ( is_user_logged_in() ) { ?><span class="edit-link"><?php edit_post_link('edit', '', ''); ?></span><?php } ?>

	</article> <!-- /end #post-## -->


	<?php
	/**
	 * Check if at least some info about the project exists, if not, hide the "project details" section and show default sidebar.
	 */

	if ( ( $project_link_text ) || ( $client_name ) || ( $field_1 ) || ( $field_2 ) || ( $field_3 ) || ( $field_4 ) || ( $field_5 ) || ( $field_6 ) || ( $field_7 ) || ( $field_8 ) || ( $field_9 ) ) :
	?>
	<aside id="project-details">

		<section class="custom-fields">

			<h4><?php _e( 'Project Details', 'framework' ); ?></h4>

			<ul class="fields">
				<?php if ($client_name) { ?><li><strong><?php _e( 'Client: ', 'framework' ); ?></strong>
				<?php if ($client_name_link) { ?><a href="<?php echo $client_name_link ?>" target="_blank"><?php echo $client_name ?></a>
				<?php } else {
					echo $client_name ?></li>
					<?php }
					} ?>
				<?php if ($field_1) { ?><li><strong><?php echo $field_1 ?></strong> <?php echo $field_2 ?></li><?php } ?>
				<?php if ($field_3) { ?><li><strong><?php echo $field_3 ?></strong> <?php echo $field_4 ?></li><?php } ?>
				<?php if ($field_5) { ?><li><strong><?php echo $field_5 ?></strong> <?php echo $field_6 ?></li><?php } ?>
				<?php if ($field_7) { ?><li><strong><?php echo $field_7 ?></strong> <?php echo $field_8 ?></li><?php } ?>
				<?php /*the_time('F d, Y');*/ ?>
			</ul>

			<?php if ($project_link_text) { ?>
			<section class="project-link">
				<a class="project-link-button" href="<?php echo $project_link ?>" target="_blank"><?php echo $project_link_text ?></a>
			</section>
			<?php } ?>

			<?php if ($field_9) { ?><p><?php echo $field_9 ?></p><?php } ?>

		</section> <!-- /end .custom-fields -->

	</aside> <!-- /end #project-details -->

	<?php endif; ?>

	<?php if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>
	<aside id="secondary" class="widget-area" role="complementary">
		<ul class="xoxo">
			<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
		</ul>
	</aside> <!-- /end #secondary -->
	<?php endif; ?>

	<?php /* Project Details ENDS */ ?>

	<section id="content" role="main">

		<?php
		if ( $mav_data['related_projects'] ) {
			get_template_part( '/inc/related-projects' );
		}
		?>

		<?php comments_template( '', true ); ?>

		<div id="navigation">
			<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous Project link', 'framework' ) . '</span> %title' ); ?></div>
			<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next Project link', 'framework' ) . '</span>' ); ?></div>
		</div>

	</section> <!-- /end #content -->


</section> <!-- /end #project-content -->

<?php get_footer(); ?>

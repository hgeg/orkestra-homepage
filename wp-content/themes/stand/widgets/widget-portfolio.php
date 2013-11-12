<?php
/**
 * Plugin Name: Widget Portfolio
 * Plugin URI: http://mattiaviviani.com
 * Description: Display your portfolios
 *
 * Author URI: http://mattiaviviani.com
 */

/*-----------------------------------------------------------------------------------*/
/* Widget class */
/*-----------------------------------------------------------------------------------*/

if ( ! class_exists( 'MAV_Portfolio' ) ) :

class MAV_Portfolio extends WP_Widget {


	/*-----------------------------------------------------------------------------------*/
	/* Widget Setup */
	/*-----------------------------------------------------------------------------------*/

    function mav_portfolio() {
        $widget_ops = array(
			'description' => "Display your portfolios",
			'classname' => 'widget-portfolio'
			);
        $this->WP_Widget('mav_portfolio', 'Mav Portfolios', $widget_ops);
    }


	/*-----------------------------------------------------------------------------------*/
	/* Front-end - Display Widget */
	/*-----------------------------------------------------------------------------------*/

    function widget( $args, $instance ) {

    	// Our variables from the widget settings
		$title = apply_filters('widget_title', $instance['title'] );

		// Set up default widget settings
		$defaults = array(
			'title' => 'Portfolio',
			'portfolio_name' => '',
			'project_description' => true,
			'order' => 'DESC',
			'orderby' => 'date',
			'posts_per_page' => -1
		);

        extract( $args );
		if (empty($instance['order'])){ // DAHEX If $instance['order'] is empty than load the default values
		// we may also use if(count($instance) <= 1){}
			$instance = wp_parse_args( $args, $defaults );
		}

		// Before widget (defined by themes)
		echo $before_widget;
		?>


		<?php

		// Display the widget title if one was input
		if ( $title )
			echo $before_title . $title . $after_title;
		?>

		<?php
		$order = $instance['order']; // date, title
		$orderby = $instance['orderby']; // ASC, DESC
		$posts_per_page = $instance['posts_per_page'];
		$portfolio_name = $instance['portfolio_name'];

		$tax_query[] = array(
				'taxonomy' => 'portfolios',
				'field' => 'slug',
				'terms' => array( $portfolio_name )
			);
		$args = array(
			'post_type'=>'project',
			'posts_per_page'=> $posts_per_page,
			'orderby' => $orderby,
			'order' => $order,
			'tax_query'	=> $tax_query
			);
		$projects = new WP_Query($args);


		if ( count( $projects->posts ) > 0 ) :

			echo('<ul>');

			foreach ( $projects->posts as $project ) {

				global $post;

				$post = $project;

				$post_img_width = 300;
				$post_img_height = 210;

				$custom = get_post_custom($project->ID);
				$project_img = $custom["project_img"][0];
				$project_img_ID = $custom["project_img_ID"][0];
				$project_link = $custom["project_link"][0];
				$project_link_text = $custom["project_link_text"][0];
				$label = get_post_meta( get_the_ID(), 'label_select', true );

				// Need some proof check to ensure that no "notice" is thrown ...
				if ( ! empty( $project ) ) {

					$term_slug = $project->post_title;

					$empty_thumb = '<img class="portfolios_widget_thumb portfolio-image" src="' . get_template_directory_uri() . '/images/thumb.png" width="' . $post_img_width . '" height="' . $post_img_height . '" alt="' . $project->post_title . '" />';

					if ( isset( $project_img_ID ) ) {

						if ( is_numeric( $project_img_ID ) ) {

							$thumb_ID = $project_img_ID;
							$thumb = wp_get_attachment_image( $thumb_ID, 'mav-widget-thumbnails', false, array( 'class' => 'portfolios_post_image_thumb portfolio-image', 'alt' =>  $project->post_title ) );

							if ( empty ($thumb) ) {
								$thumb = $empty_thumb;
							}

						} elseif( $project_img_ID != "" ) {

							$thumb = '<div class="project_iframe_thumb-$term_slug"><iframe id="project_widget_thumb-$term_slug" width="' . $post_img_width . '" height="' . $post_img_height . '" src="' . $project_img . '" title="' . $project_img_ID . '" frameborder="0" allowfullscreen></iframe></div>';

						} else {

							$thumb = $empty_thumb;

						}

					} else {
						$thumb = $empty_thumb;
					}

				}
				echo '<li class="widget-project">';
					if ($project_img) {
					echo '<figure class="thumb_img">
							<a href="' . get_permalink( $project->ID) . '">
								<span class="overlay">'; ?>
								<span class="view"><?php _e( 'View', 'framework' ); ?></span>
								<?php echo
								'</span>
									' . $thumb . '
							</a>
						  </figure> <!-- /end figure.thumb_img -->';
					}
				echo '<h3 class="entry-title"><a href="' . get_permalink( $project->ID) . '">' . $project->post_title . '</a></h3>
					<p>'
						. (isset($instance['project_description'])?$custom['project_desc'][0]:'') .
					'</p>';

					?>
			
				<?php
				$project_categories = wp_get_object_terms($post->ID, 'project_category');
				if ($project_categories) { ?>
				<footer class="entry-meta">
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
				</footer> <!-- /end footer.entry-meta -->
			<?php } ?>

			<?php
				echo '<a class="more-link" href="' . get_permalink( $project->ID) . '">' . __( 'View Case Study', 'framework' ) . '</a>
				</li>';
			}

			echo( '</ul>');

			else: // DAHEX if no records
			?>
			<p>No items to show at this time. To to use this widget go to Projects -> Portfolios and create at least one Portfolio.
				Then create some Projects and assign them to a Portfolio.</p>
			<?php
			endif;
		?>

		<?php

		// After widget (defined by themes)
		echo $after_widget;

    }


    function update($instance) {

        return $instance;

    }


	/*-----------------------------------------------------------------------------------*/
	/* Widget Settings (Displays the widget settings controls on the widget panel) */
	/*-----------------------------------------------------------------------------------*/

	function form( $instance ) {

		// Set up default widget settings
		$defaults = array(
			'title' => 'Latest Projects',
			'portfolio_name' => '',
			'project_description' => true,
			'order' => 'DESC',
			'orderby' => 'date',
			'posts_per_page' => 1
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		/**
		 * get portfolios taxonomy and related portfolios images (! not portfolios posts !)
		 */
		$portfolios = get_terms('portfolios', 'hide_empty=0');
		?>

		<div style="width:218px">

			<!-- Widget Title -->
			<p style="margin-bottom:3px;"><strong><?php _e('Widget Title', 'framework'); ?></strong></p>
			<p><input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" /></p>

			<?php
			if ( count( $portfolios ) > 0 ) :
			?>

			<!-- Portfolio Name -->
			<p style="margin-bottom:3px;"><strong><?php _e('Portfolio', 'framework'); ?></strong></p>
			<p>
				<select id="<?php echo $this->get_field_id( 'portfolio_name' ); ?>" name="<?php echo $this->get_field_name( 'portfolio_name' ); ?>" class="widefat" style="width:100%;">
					<?php foreach ( $portfolios as $portfolio ) : ?>
						<option value="<?php echo( $portfolio->slug ); ?>" <?php echo( $portfolio->slug == $instance['portfolio_name'] ) ? 'selected="selected"' : ''; ?>><?php echo( $portfolio->name ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>

			<!-- Post Number -->
			<p style="margin-bottom:3px;"><strong><?php _e('Number of Posts', 'framework'); ?></strong></p>
			<p>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo $instance['posts_per_page']; ?>" />
				<span style="margin-top:5px;display:block;"><?php _e('Define the number of posts you want to display within the selected Portfolio (-1 shows all posts).', 'framework'); ?></span>
			</p>

			<!-- Display Project Description -->
			<p>
				<input type="checkbox" id="<?php echo $this->get_field_id('project_description'); ?>" name="<?php echo $this->get_field_name('project_description'); ?>" value="1" <?php isset($instance['project_description']) ? checked( '1', $instance['project_description'] ) : checked('0', '1'); ?> >
				<span style="margin-left:5px;"><?php _e('Display the Project Description', 'framework'); ?></span>
			</p>

			<input type="hidden" class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" value="<?php echo $instance['order']; ?>" />

			<input type="hidden" class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" value="<?php echo $instance['orderby']; ?>" />

			<?php
			else :
			?>

			<!-- No Portfolio message -->
			<p style="margin-bottom:3px;"><strong>To to use this widget:</strong></p>
			<p>
				Go to Projects -> Portfolios and create at least one Portfolio.
				Then create some Projects and assign them to a Portfolio.
			</p>

			<?php
			endif;
			?>

		</div>

		<div style="clear:both;">&nbsp;</div>


		<?php
	}

}

endif;
?>

<?php
/**
 * Plugin Name: Widget Blog
 * Plugin URI: http://mattiaviviani.com
 * Description: Display your blog posts
 *
 * Author URI: http://mattiaviviani.com
 */

/*-----------------------------------------------------------------------------------*/
/* Widget class */
/*-----------------------------------------------------------------------------------*/

if ( ! class_exists( 'MAV_Blog' ) ) :

class MAV_Blog extends WP_Widget {


	/*-----------------------------------------------------------------------------------*/
	/* Widget Setup */
	/*-----------------------------------------------------------------------------------*/

	function mav_blog() {

		// Widget settings
		$widget_ops = array(
			'classname' => 'widget-blog',
			'description' => __('Display your blog posts', 'widget-blog')
		);

		// Create the widget
		$this->WP_Widget( 'mav_blog', __('Mav Blog Posts', 'widget-blog'), $widget_ops );

	}


	/*-----------------------------------------------------------------------------------*/
	/* Front-end - Display Widget */
	/*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {

		extract( $args );

		// Arguments for the query
		$args = array();

		// Widget title and things not in query arguments
		$title = apply_filters('widget_title', $instance['title'] );
		$display = $instance['display'];

		// Post Thumbnail
		$show_thumbnail = isset( $instance['show_thumbnail'] ) ? $instance['show_thumbnail'] : false;

		// Ordering and such
		if ( $instance['showposts'] ) $args['showposts'] = (int)$instance['showposts'];

		// Category arguments
		if ( $instance['category_name'] ) $args['category_name'] = $instance['category_name'];


		// Begin display of widget
		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		query_posts( $args );

		if ( $display == 'ul' || $display == 'ol' ) : ?>

			<<?php echo $display; ?>>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php the_title( '<li><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></li>' ); ?>
			<?php endwhile; endif; ?>
			</<?php echo $display; ?>>

		<?php else: ?>
			
			<?php global $more; // Declare global $more (before the loop). ?>
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); global $post; ?>

				<?php $more = 1; // Set (inside the loop) to display content above the more tag. ?>

				<?php
				// Retrieves the attachment for the lightbox. The image is automatically retrieved from the Media Library.
				$attachment_id = get_post_thumbnail_id($post->ID); // Defines ID for image
				$image_attributes = wp_get_attachment_image_src( $attachment_id ); // returns an array
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php if ($show_thumbnail == true) : ?>
						<?php if ($image_attributes) { ?>
						<figure class="feat_img">
							<a href="<?php the_permalink() ?>" rel="bookmark">
								<span class="overlay">
									<span class="view"><?php _e( 'Read', 'framework' ); ?></span>
								</span>
								<?php the_post_thumbnail(); ?>
							</a>
						</figure> <!-- /end figure.feat_img -->
						<?php } ?>
					<?php endif; ?>

					<header class="entry-meta">

						<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

						<?php
						
						// Load Post Formats
						$format = get_post_format();

							if ( false === $format )
								$format = 'standard';

						?>

						<a href="<?php the_permalink() ?>" class="entry-format <?php echo $format; ?>"><?php echo $format; ?></a>

						<span class="posted-on"><?php _e( '[:en]Posted on[:tr]Tarih: ', 'framework' ); ?> <a href="<?php the_permalink() ?>"><?php /* http://codex.wordpress.org/Formatting_Date_and_Time */ echo get_the_date('F j, Y'); ?></a></span>

						<span class="by-author"><?php _e( '[:en]by[:tr]Yazan: ', 'framework' ); ?> <?php the_author_posts_link(); ?></span>
<br/>
						<?php
						$categories_list = get_the_category_list( __( ' ', 'framework' ) );
						if ( $categories_list ): ?>
						<span class="cat-links">
							<?php printf( __( '%2$s', 'framework' ), '', $categories_list ); ?>
						</span>
						<?php endif; // if categories /ends ?>

					</header> <!-- /end header.entry-meta -->

					<?php the_excerpt(); ?>

				</article> <!-- /end .post-## -->

			<?php endwhile; endif; ?>

		<?php endif;

		echo $after_widget;
	}


	/*-----------------------------------------------------------------------------------*/
	/* Update Widget */
	/*-----------------------------------------------------------------------------------*/

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['display'] = $new_instance['display'];
		$instance['showposts'] = strip_tags( $new_instance['showposts'] );
		$instance['category_name'] = $new_instance['category_name'];
		$instance['show_thumbnail'] = $new_instance['show_thumbnail'];

		return $instance;

	}


	/*-----------------------------------------------------------------------------------*/
	/* Widget Settings (Displays the widget settings controls on the widget panel) */
	/*-----------------------------------------------------------------------------------*/

	function form( $instance ) {

		// Set up default widget settings
		$defaults = array(
			'showposts' => '1',
			'title' => 'From the Blog',
			'category_name' => 'uncategorized',
			'display' => 'the_excerpt',
			'post_type' => 'post',
			'post_status' => 'publish',
			'order' => 'DESC',
			'orderby' => 'date',
			/*'ignore_sticky_posts' => true,
			'wp_reset_query' => true*/
			'show_thumbnail' => true
		);

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div style="width:218px">

			<!-- Widget Title -->
			<p style="margin-bottom:3px;"><strong><?php _e('Widget Title', 'framework'); ?></strong></p>
			<p><input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" /></p>

			<!-- Category Name -->
			<p style="margin-bottom:3px;"><strong><?php _e('Category Name', 'framework'); ?></strong></p>
			<p>
				<select id="<?php echo $this->get_field_id( 'category_name' ); ?>" name="<?php echo $this->get_field_name( 'category_name' ); ?>" class="widefat" style="width:100%;">
					<option <?php if ( !$instance['category_name'] ) echo ' selected="selected"'; ?> value=""></option>
					<?php $cats = get_categories( array( 'type' => 'post' ) ); ?>
					<?php foreach ( $cats as $cat ) : ?>
						<option <?php if ( $cat->slug == $instance['category_name'] ) echo 'selected="selected"'; ?>><?php echo $cat->slug; ?></option>
					<?php endforeach; ?>
				</select>
			</p>

			<!-- Showposts -->
			<p style="margin-bottom:3px;"><strong><?php _e('Number of Posts', 'framework'); ?></strong></p>
			<p>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'showposts' ); ?>" name="<?php echo $this->get_field_name( 'showposts' ); ?>" value="<?php echo $instance['showposts']; ?>" />
				<span style="margin-top:5px;display:block;"><?php _e('Define the number of blog posts you want to display (-1 shows all posts).', 'framework'); ?></span>
			</p>

			<!-- Thumbnail -->
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['show_thumbnail'], true ); ?> <?php if ($instance['show_thumbnail'] == true) echo 'checked="checked" '; ?> id="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'show_thumbnail' ); ?>" />
				<label style="margin-left:5px;" for="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>"><?php _e('Show Post Thumbnail', 'framework'); ?></label>
			</p>

		</div>

		<div style="clear:both;">&nbsp;</div>

		<?php
	}

}

endif;
?>

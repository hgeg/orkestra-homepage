<?php 
/**
 * Plugin Name: Widget Twitter
 * Plugin URI: http://mattiaviviani.com
 * Description: Show your tweets
 *
 * Author URI: http://mattiaviviani.com
 */

/*-----------------------------------------------------------------------------------*/
/* Widget class */
/*-----------------------------------------------------------------------------------*/

if ( ! class_exists( 'MAV_Tweets' ) ) :

class MAV_Tweets extends WP_Widget {


	/*-----------------------------------------------------------------------------------*/
	/* Widget Setup */
	/*-----------------------------------------------------------------------------------*/

	function mav_tweets() {

		// Widget settings
		$widget_ops = array(
			'classname' => 'widget-latest-tweets',
			'description' => __('Show your tweets', 'widget-latest-tweets')
		);

		// Create the widget
		$this->WP_Widget( 'mav_tweets', __('Mav Tweets','widget-latest-tweets'), $widget_ops );

	}


	/*-----------------------------------------------------------------------------------*/
	/* Front-end - Display Widget */
	/*-----------------------------------------------------------------------------------*/
	
	function widget( $args, $instance ) {

		extract( $args );

		// Our variables from the widget settings
		$title = apply_filters('widget_title', $instance['title'] );
		$username = $instance['username'];
		$postcount = $instance['postcount'];
		$tweet_text = $instance['tweet_text'];

		// Before widget (defined by theme functions file)
		echo $before_widget;

		// Display the widget title if one was input
		if ( $title )
			echo $before_title . $title . $after_title;

		?>


		<!-- Twitter API 1.1 Update Jun 15, 2013 - https://twitter.com/settings/widgets -->
		<a class="twitter-timeline" href="https://twitter.com/<?php echo $username; ?>" data-widget-id="345962571343491072"><?php _e( 'Tweets by @', 'framework' ); ?><?php echo $username; ?></a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


		<?php
		// After widget (defined by theme functions file)
		echo $after_widget;
	}

	/*-----------------------------------------------------------------------------------*/
	/* Update Widget */
	/*-----------------------------------------------------------------------------------*/

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['postcount'] = strip_tags( $new_instance['postcount'] );
		$instance['tweet_text'] = strip_tags( $new_instance['tweet_text'] );

		return $instance;

	}


	/*-----------------------------------------------------------------------------------*/
	/* Widget Settings (Displays the widget settings controls on the widget panel) */
	/*-----------------------------------------------------------------------------------*/

	function form( $instance ) {

		// Set up default widget settings
		$defaults = array(
			'title' => 'Latest Tweets',
			'username' => 'MattiaViviani',
			'postcount' => '3',
			'tweet_text' => 'Follow us on Twitter',
		);

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div style="width:218px">

			<!-- Widget Title -->
			<p style="margin-bottom:3px;"><strong><?php _e('Widget Title', 'framework'); ?></strong></p>
			<p><input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" /></p>

			<!-- Username -->
			<p style="margin-bottom:3px;"><strong><?php _e('Username', 'framework'); ?></strong></p>
			<p><input type="text" class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" /></p>

			<!-- Postcount -->
			<p style="margin-bottom:3px;"><strong><?php _e('Number of Tweets', 'framework'); ?></strong></p>
			<p>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" value="<?php echo $instance['postcount']; ?>" />
				<span style="margin-top:5px;display:block;"><?php _e('Define the number of tweets you want to display (-1 shows all tweets - max 20).', 'framework'); ?></span>
			</p>

			<!-- Tweet_text -->
			<p style="margin-bottom:3px;"><strong><?php _e('Follow Link Text', 'framework'); ?></strong></p>
			<p>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tweet_text' ); ?>" name="<?php echo $this->get_field_name( 'tweet_text' ); ?>" value="<?php echo $instance['tweet_text']; ?>" />
				<?php /* <span style="margin-top:5px;display:block;"><?php _e('eg: Follow us on Twitter', 'framework'); ?></span> */ ?>
			</p>

		</div>

		<div style="clear:both;">&nbsp;</div>

		<?php
	}

}

endif;
?>

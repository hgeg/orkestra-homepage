<?php
/*
Plugin Name: Mav Icons
Plugin URI: http://mattiaviviani.com
Description: Show your social profiles with a beautiful set of icons
Version: 1.0.3
Author: Mattia Viviani
Author URI: http://mattiaviviani.com
License: GNU General Public License v2 or later
*/

/*  Copyright 2012  Mattia Viviani  (email : hello@mattiaviviani.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/************************** ON ACTIVE INIT ***********************************/

function mav_activate() {

	$profiles = array(
		'500px' => 'eg: http://500px.com/username',
		'AddThis' => 'eg: http://www.addthis.com',
		'Aol' => 'eg: http://username.aol.com/',
		'Bebo' => 'eg: http://www.bebo.com/username',
		'Behance' => 'eg: http://www.behance.net/username',
		'Blogger' => 'eg: http://username.blogspot.com',
		'Delicious' => 'eg: http://delicious.com/username',
		'DeviantART' => 'eg: http://username.deviantart.com/',
		'Digg' => 'eg: http://digg.com/username',
		'Dopplr' => 'eg: http://www.dopplr.com/traveller/username',
		'Dribbble' => 'eg: http://dribbble.com/username',
		'Envato' => 'eg: http://your_marketplace.com/user/username',
		'Evernote' => 'eg: http://www.evernote.com',
		'Facebook' => 'eg: http://www.facebook.com/username',
		'Flickr' => 'eg: http://www.flickr.com/photos/username',
		'Forrst' => 'eg: http://forrst.me/username',
		'Foursquare' => 'eg: http://foursquare.com/username',
		'GitHub' => 'eg: http://github.com/username',
		'Google+' => 'eg: http://plus.google.com/userID',
		'Grooveshark' => 'eg: http://grooveshark.com/username',
		'Instagram' => 'eg: http://instagr.am/p/picID',
		'LastFM' => 'eg: http://www.last.fm/user/username',
		'LinkedIn' => 'eg: http://www.linkedin.com/in/username',
		'Mail' => 'eg: mailto:user@name.com',
		'MySpace' => 'eg: http://www.myspace.com/userID',
		'Netvibes' => 'eg: http://username.newsvine.com',
		'Newsvine' => 'eg: http://username.newsvine.com/',
		'Photobucket' => 'eg: http://photobucket.com/user/username/profile/',
		'Pinterest' => 'eg: http://pinterest.com/username',
		'Picasa' => 'eg: http://picasaweb.google.com/userID',
		'Pinterest' => 'eg: http://pinterest.com/username',
		'Posterous' => 'eg: http://username.posterous.com',
		'Reddit' => 'eg: http://www.reddit.com/user/username',
		'RSS' => 'eg: http://example.com/feed',
		'Scribd' => 'eg: http://www.scribd.com/username',
		'ShareThis' => 'eg: http://sharethis.com',
		'Skype' => 'eg: skype:username',
		'SoundCloud' => 'eg: http://soundcloud.com/username',
		'Spotify' => 'eg: http://open.spotify.com/user/username',
		'StumbleUpon' => 'eg: http://www.stumbleupon.com/stumbler/username',
		'Technorati' => 'eg: http://technorati.com/people/username',
		'Tumblr' => 'eg: http://username.tumblr.com',
		'Twitter' => 'eg: http://twitter.com/username',
		'Viddler' => 'eg: http://www.viddler.com/explore/username',
		'Vimeo' => 'eg: http://vimeo.com/username',
		'WordPress' => 'eg: http://username.wordpress.com',
		'Yahoo' => 'eg: http://profile.yahoo.com/username',
		'Yelp' => 'eg: http://www.yelp.com/user_details?userid=userID',
		'YouTube' => 'eg: http://www.youtube.com/user/username'
    );

	update_option('profiles', $profiles );
}

register_activation_hook(__FILE__, 'mav_activate');

/************************************* WIDGET BLOCK ************************************/

add_action('widgets_init', create_function('', 'register_widget("Mav_Icons_Widget");'));

class Mav_Icons_Widget extends WP_Widget {

	function __construct() {
		parent::WP_Widget( 'mav_icons_widget', 'Mav Icons', array( 'description' => 'Displays your social profiles' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$desc = $instance['description'];

		echo $before_widget;
		if ( !empty( $title ) ) echo $before_title . $title . $after_title;

		if( $desc ) echo '<p>'. $desc .'</p>';

		echo do_icons();

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['description'] = strip_tags($new_instance['description'], '<a><b><strong><i><em>');
		return $instance;
	}

	function form( $instance ) {
		if ( $instance && isset($instance['title']) ) $title = esc_attr( $instance['title'] );
		else $title = '';
		if ( $instance && isset($instance['description']) ) $desc = esc_attr( $instance['description'] );
		else $desc = '';
		?>
		<p><?php _e( 'Set up Mav Icons plugin', 'mav' ); ?> <a href="admin.php?page=mav-icons"><?php _e( 'here', 'mav' ); ?></a></p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:'); ?></label>
			<textarea id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" cols="29" rows="5"><?php echo $desc; ?></textarea>
		</p>

		<?php
	}

}

/***************** ADMIN INIT ***********************/

add_action('admin_init', 'admin_init');

function admin_init() {
	//delete_option( 'mav_icons_settings' );
	register_setting( 'mav-icons', 'mav_icons_settings', 'settings_validate' );
	add_settings_section( 'mav-icons', '', 'section_intro', 'mav-icons' );
	$settings = get_option( 'mav_icons_settings' );

	add_settings_field( 'order', __( 'Preview and Sorting', 'mav' ), 'setting_order', 'mav-icons', 'mav-icons' );
	add_settings_field( 'links', __( 'Open Links', 'mav' ), 'setting_links', 'mav-icons', 'mav-icons' );

	$profiles = get_option('profiles');
	foreach($profiles as $profile => $help){
		add_profile( $profile, $profile, $help );
	}

	add_settings_field( 'instructions', __( 'Shortcode and Template Tag', 'mav' ), 'setting_instructions', 'mav-icons', 'mav-icons' );
}


/*-----------------------------------------------------------------------------------*/
/* Include Icons Styles (front-end) */
/*-----------------------------------------------------------------------------------*/

function icons_include_styles() {

	// Register the style like this for a theme:
	wp_register_style( 'icons_styles', plugins_url('css/style.css', __FILE__) );

	// For either a plugin or a theme, you can then enqueue the style:
	wp_enqueue_style( 'icons_styles' );

}

add_action( 'wp_print_styles', 'icons_include_styles' );


/***************** MENU CREATION **********************************/

add_action('admin_menu', 'admin_menu');

function admin_menu() {
	add_menu_page( __( 'Mav Icons Settings', 'mav' ), __( 'Mav Icons', 'mav' ), 'update_core', 'mav-icons', 'settings_page', plugins_url('/mav-icons/images/mav-icon.png') );
	add_submenu_page( 'mav-icons', __( 'Settings', 'mav' ), __( 'Mav Icons Settings', 'mav' ), 'update_core', 'mav-icons', 'settings_page' );
	add_submenu_page( 'mav', __( 'Mav Icons', 'mav' ), __( 'Mav Icons', 'mav' ), 'update_core', 'mav-icons', 'settings_page' );
}

/******************************************* INIT SHORTCODE *******************************/

add_shortcode('mav_icons',  'shortcode');

function shortcode( $atts ) {
	extract( shortcode_atts( array(
		'profiles' => ''
	), $atts ) );

	//$settings = get_option( 'mav_icons_settings' );

	$profiles_wl = array();
	if($profiles){
		$profiles_wl = explode(',', str_replace(' ', '', esc_attr($profiles)));
	}
	return do_icons( $profiles_wl);
}

/******************** ADDITIONAL FUNCTIONS ******************************************/

function settings_page() {
	?>
	<div class="wrap">
		<div id="icon-themes" class="icon32"></div>
		<h2>Mav Icons Settings</h2>
		<p>Mav Icons Plugin allow to display your social profiles with a beautiful set of icons. You may display your icons using Widget, Shortcodes or Template Tag.</p>
		<!-- <p>Let's check it out our <a href="http://mattiaviviani.com/plugins/" target="_blank">Plugins</a> and <a href="http://mattiaviviani.com/themes/" target="_blank">Themes</a></p> -->
		<?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] ){ ?>
		<div id="setting-error-settings_updated" class="updated settings-error">
			<p><strong><?php _e( 'Settings saved.', 'mav' ); ?></strong></p>
		</div>
		<?php } ?>
		<form action="options.php" method="post">
			<?php settings_fields( 'mav-icons' ); ?>
			<?php do_settings_sections( 'mav-icons' ); ?>
			<p class="submit"><input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'mav' ); ?>" /></p>
		</form>
	</div>
	<?php
}

function add_profile( $id, $title, $help = '' ) {
	$args = array(
		'id' => $id,
		'help' => $help
	);

	add_settings_field( $id, __( $title, 'mav' ), 'setting_profile', 'mav-icons', 'mav-icons', $args );
}

function setting_profile( $args ) {
	$settings = get_option( 'mav_icons_settings' );
	if( !isset($settings[$args['id']]) ) $settings[$args['id']] = '';

	echo '<input type="text" name="mav_icons_settings['. $args['id'] .']" class="regular-text" value="'. $settings[$args['id']] .'" /> ';
	if($args['help']) echo '<span class="description">'. $args['help'] .'</span>';
}

function setting_links() {
	$settings = get_option( 'mav_icons_settings' );
	if( !isset($settings['links']) ) $settings['links'] = 'new_window';

	echo '<select name="mav_icons_settings[links]">
	<option value="new_window"'. (($settings['links'] == 'new_window') ? ' selected="selected"' : '') .'>In new window</option>
	<option value="same_window"'. (($settings['links'] == 'same_window') ? ' selected="selected"' : '') .'>In same window</option>
	</select>';
}

function setting_preview() {
	$settings = get_option( 'mav_icons_settings' );
	if($settings) echo do_icons();
}

function setting_order() {
	$res_arr = array();
	$out_ordered = array();
	$settings = get_option( 'mav_icons_settings' );

	echo '<p>Simply drag & drop for sorting the icons.</p>';

	// values from list
	if( $settings ){
		foreach( $settings as $name => $value ){
			if( $name == 'order' || $name == 'links' ||  strlen($value ) == 0) continue;
				if( isset( $value ) && strlen( $value ) > 5 ) {
					$res_arr[] = $name;
				}
		}
	}

	// values from order
	if( $settings['order'] ){
		$ordered_arr = explode( ',', $settings['order'] );
		foreach( $ordered_arr as $single){
			if( strlen($single) == 0 ){

			}else{
				$out_ordered[] = $single;
			}
		}
	}

	// from out arr
	$out_final = array();
	if( $out_ordered ){
		foreach( $out_ordered as $single_order ){
			if( in_array( $single_order, $res_arr ) ){
				// add item to final array
				$out_final[] = $single_order;
				// remove added item from global array
				$key = array_search( $single_order, $res_arr );
				if($key!==false){
					unset($res_arr[$key]);
				}
			}
		}
	}

	if( $out_final ){
		$array_to_use = array_merge($out_final, $res_arr  );
	} else {
		$array_to_use = $res_arr;
	}
	//var_dump( $array_to_use );
	echo '
	<ul id="sortable">';
	if( $array_to_use ){
		foreach( $array_to_use as $single_value ){
			echo '<li class="ui-state-default" style="" id="'. $single_value .'"><img src="'. plugins_url( '/images/icons/'. $single_value .'.png', __FILE__ ) .'" alt="'. $single_value .'" /> </li>';
		}
	}
	echo '
		<div style="clear:both;"></div>
	</ul>
	<input type="hidden" name="mav_icons_settings[order]" value="'.( $array_to_use ? implode( ',', $array_to_use ) : '' ).'" id="settings_order" />
	<style>
		.ui-state-default {
			width: 35px;
			float: left;
			cursor:pointer;
			/* @since 1.0.2 - sc compatibility */
			background: transparent;
			border: none;
		}
		.ui-state-highlight {
			width: 35px;
			height: 35px;
			float: left;
			border:dotted 1px #ccc;
		}
		.form-table th { font-weight: bold; }
		.description { margin-left: 10px; }
	</style>
	<script>
		jQuery(document).ready( function($){
			$( "#sortable" ).sortable({
				placeholder: "ui-state-highlight",
				update: function(event, ui) {
                    var result = $(this).sortable(\'toArray\');
                    $("#settings_order").val( result.join(",") );
                    }
			});
		})
	</script>';
}

function setting_instructions() {
	echo '<p>To use Mav Icons in your posts and pages you can use the shortcode:</p>
	<p><code>[mav_icons]</code></p>
	<p>To use Mav Icons in your theme template use the following PHP code:</p>
	<p><code>&lt;?php if( function_exists(\'mav_icons\') ) mav_icons(); ?&gt;</code></p>';
}

function settings_validate($input) {
	$profiles = get_option('profiles');
	foreach($profiles as $profile => $help){
		$input[$profile] = strip_tags($input[$profile]);
		if($profile != 'Skype') $input[$profile] = esc_url_raw($input[$profile]);
	}
	return $input;
}

function do_icons( $profiles_wl = array() ) {
	/*echo'<style type="text/css"></style>';*/

	$options = get_option( 'mav_icons_settings' );

	if( !isset($options['links']) ) $options['links'] = 'same_window';

	$output = '<ul class="mav-icons">';

	$profiles = get_option('profiles');
	$settings = get_option( 'mav_icons_settings' );

	//var_dump( $settings['order'] );

	if(empty($profiles_wl)){

		if( $settings['order'] ){

			$tmp_out_list = explode( ',', $settings['order'] );
			foreach( $tmp_out_list as $single_item ){
				@$out_list[$single_item] = $profiles[$single_item];
			}

		}else{
			$out_list = $profiles;
		}
		//var_dump( $profiles );
		foreach($out_list as $profile => $help){
			if(isset($options[$profile]) && $options[$profile]){
				$output .= '<li class="mav-icon"><a href="'. $options[$profile] .'" class="'. $profile .'"'. (($options['links'] == 'new_window') ? ' target="_blank"' : '') .'><img src="'. plugins_url( '/images/icons/'. $profile .'.png', __FILE__ ) .'" alt="'. $profile .'" /></a></li> ';
			}
		}
	} else {
		foreach($profiles_wl as $profile){
			if(isset($options[$profile]) && $options[$profile]){
				$output .= '<a href="'. $options[$profile] .'" class="'. $profile .'"'. (($options['links'] == 'new_window') ? ' target="_blank"' : '') .'><img src="'. plugins_url( '/images/icons/'. $profile .'.png', __FILE__ ) .'" alt="'. $profile .'" /></a> ';
			}
		}
	}

	$output .= '</ul>';
	return $output;
}

function section_intro() {}

function mav_icons(  $profiles_wl = array() ) {
	echo do_icons( $profiles_wl);
}

add_action('admin_init', 'fn_add_jquery');

function fn_add_jquery() {
	wp_enqueue_script('jquery-ui-sortable', '', array('jquery', 'jquery-ui-core'));
}

function my_plugin_admin_action_links($links, $file) {
	static $my_plugin;
	if (!$my_plugin) {
		$my_plugin = plugin_basename(__FILE__);
	}
	if ($file == $my_plugin) {
		$settings_link = '<a href="admin.php?page=mav-icons">Settings</a>';
		array_unshift($links, $settings_link);
	}
	return $links;
}

add_filter('plugin_action_links', 'my_plugin_admin_action_links', 10, 2);

?>

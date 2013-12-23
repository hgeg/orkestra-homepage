<?php
/*
Plugin Name: Mav Shortcodes
Plugin URI: http://mattiaviviani.com/
Description: A simple and pixel-care shortcodes generator. Easily add buttons, tabs, columns, and more things to your website.
Version: 1.0.4
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


/*-----------------------------------------------------------------------------------*/
/* Define Constants */
/*-----------------------------------------------------------------------------------*/

if( !defined( 'IS_ADMIN' ) )
    define( 'IS_ADMIN',  is_admin() );

define( 'MAV_PREFIX',   'mav_' );
define( 'MAV_VERSION',  '1.0.1' );
define( 'MAV_URL',      plugin_dir_url( __FILE__ ) );
define( 'MAV_DIR',      plugin_dir_path( __FILE__ ) );


/*-----------------------------------------------------------------------------------*/
/* Mav-Shortcode Class */
/*-----------------------------------------------------------------------------------*/

class MavShortcodes {

	function __construct() {

		add_action( 'admin_init', array( &$this, 'action_admin_init' ) );

		// wp_ajax_mav_check_url_action (for logged users only).
		add_action( 'wp_ajax_mav_check_url_action', array( &$this, 'ajax_action_check_url' ) );

        require_once( 'functions/shortcodes.php' );
	}

	function action_admin_init() {

		if ( current_user_can( 'edit_posts' )
		  && current_user_can( 'edit_pages' )
		  && get_user_option('rich_editing') == 'true' )  {

			add_filter( 'mce_buttons',          array( &$this, 'filter_mce_buttons'          ) );
			add_filter( 'mce_external_plugins', array( &$this, 'filter_mce_external_plugins' ) );


			/*-----------------------------------------------------------------------------------*/
		    /* Include jQuery-UI Styles */
			/*-----------------------------------------------------------------------------------*/

			wp_register_style( 'mav-jquery-ui-style', MAV_URL . 'css/base/jquery.ui.all.css', true);
			wp_enqueue_style( 'mav-jquery-ui-style' );

			wp_register_style( 'mav-jquery-ui-theme', MAV_URL . 'css/smoothness/jquery-ui-1.9.2.custom.css', true);
			wp_enqueue_style( 'mav-jquery-ui-theme' );


			/*-----------------------------------------------------------------------------------*/
		    /* Include TinyMCE Styles */
			/*-----------------------------------------------------------------------------------*/

			wp_register_style( 'tinymce_styles', $this->plugin_url() . 'tinymce/css/tinymce.css' );
			wp_enqueue_style( 'tinymce_styles' );

			// Register the script like this for a theme:
			wp_register_script(
						'jquery.validate',
						MAV_URL . '/js/jquery.validate.js',
						array(
							'jquery'
							),
						MAV_VERSION,
						true
					);
			wp_register_script(
						'shortcodes_js',
						MAV_URL . 'js/shortcodes.js',
						array(
							'jquery',
							'jquery.validate',
							'jquery-ui-core',
							'jquery-effects-core',
							'jquery-ui-button',
							'jquery-ui-dialog',
							'jquery-ui-sortable',
							'jquery-ui-tabs',
							'jquery-ui-accordion'
							),
						MAV_VERSION,
						true
					);

			// For either a plugin or a theme, you can then enqueue the script:
			wp_enqueue_script( 'shortcodes_js' );

		}
	}


	function filter_mce_buttons( $buttons ) {

		array_push( $buttons, '|', 'mav_button');
		return $buttons;
	}

	function filter_mce_external_plugins( $plugins ) {

        $plugins['MavShortcodes'] = $this->plugin_url() . 'tinymce/editor_plugin.js';
        return $plugins;
	}


	/**** Returns the full URL of this plugin including trailing slash. ****/

	function plugin_url() {
		return WP_PLUGIN_URL . '/' . str_replace( basename( __FILE__ ), "", plugin_basename( __FILE__ ) );
	}


	/**
	 * AJAX ACTION.
	 *
	 * Checks if a given url (via GET or POST) exists.
	 * Returns JSON
	 *
	 * NOTE: for users that are not logged in this is not called.
	 *       The client recieves <code>-1</code> in that case.
	 */
	function ajax_action_check_url() {

		$hadError = true;

		$url = isset( $_REQUEST['url'] ) ? $_REQUEST['url'] : '';

		if ( strlen( $url ) > 0  && function_exists( 'get_headers' ) ) {

			$file_headers = @get_headers( $url );
			$exists       = $file_headers && $file_headers[0] != 'HTTP/1.1 404 Not Found';
			$hadError     = false;
		}

		echo '{ "exists": '. ($exists ? '1' : '0') . ($hadError ? ', "error" : 1 ' : '') . ' }';

		die();
	}

}


/*-----------------------------------------------------------------------------------*/
/* Include Shortcode Styles (front-end and preview) */
/*-----------------------------------------------------------------------------------*/

function shortcodes_include_styles() {


	/*-----------------------------------------------------------------------------------*/
    /* Include jQuery-UI Styles */
	/*-----------------------------------------------------------------------------------*/

	wp_register_style( 'mav-jquery-ui-style', MAV_URL . 'css/base/jquery.ui.all.css', true);
	wp_enqueue_style( 'mav-jquery-ui-style' );

	wp_register_style( 'mav-jquery-ui-theme', MAV_URL . 'css/smoothness/jquery-ui-1.9.2.custom.css', true);
	wp_enqueue_style( 'mav-jquery-ui-theme' );

	// Register the style like this for a theme:
	wp_register_style( 'shortcodes_styles', plugins_url('css/shortcodes.css', __FILE__), array( 'mav-jquery-ui-style', 'mav-jquery-ui-theme' ), MAV_VERSION, 'all' );

	// For either a plugin or a theme, you can then enqueue the style:
	wp_enqueue_style( 'shortcodes_styles' );

}

add_action( 'wp_print_styles', 'shortcodes_include_styles' );


/*-----------------------------------------------------------------------------------*/
/* Include Shortcode Scripts (front-end and preview) */
/*-----------------------------------------------------------------------------------*/

function shortcodes_include_js() {

	// Register the script like this for a theme:
	wp_register_script(
				'shortcodes_js',
				MAV_URL . 'js/shortcodes.js',
				array(
					'jquery',
					'jquery-ui-core',
					'jquery-effects-core',
					'jquery-ui-button',
					'jquery-ui-dialog',
					'jquery-ui-sortable',
					'jquery-ui-tabs',
					'jquery-ui-accordion',
					// And here are the effects for Tabs and Accordion - you can remove them if you like
					// Documentation here: http://docs.jquery.com/UI/Effects - setup in shortcode.php
					'jquery-effects-core',
					'jquery-effects-blind',
					'jquery-effects-bounce',
					'jquery-effects-clip',
					'jquery-effects-drop',
					'jquery-effects-explode',
					'jquery-effects-fade',
					'jquery-effects-fold',
					'jquery-effects-highlight',
					'jquery-effects-pulsate',
					'jquery-effects-scale',
					'jquery-effects-shake',
					'jquery-effects-slide',
					'jquery-effects-transfer'
					),
				MAV_VERSION,
				true
			);

	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'shortcodes_js' );

}

add_action( 'wp_enqueue_scripts', 'shortcodes_include_js' );


/*-----------------------------------------------------------------------------------*/

$mav_shortcodes = new MavShortcodes();

?>

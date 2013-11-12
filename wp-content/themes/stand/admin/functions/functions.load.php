<?php
/**
 * Functions Load
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.4.0
 * @author      Syamil MJ
 */

$admin_functions = get_stylesheet_directory() . '/admin/functions/functions.php';

if ( is_child_theme() && file_exists( $admin_functions ) ) { // Mav
	require_once( $admin_functions );
} else {
	require_once( ADMIN_PATH . 'functions/functions.php' );
}

require_once( ADMIN_PATH . 'functions/functions.interface.php' );
require_once( ADMIN_PATH . 'functions/functions.options.php' );
require_once( ADMIN_PATH . 'functions/functions.admin.php' );
require_once( ADMIN_PATH . 'functions/functions.mediauploader.php' );
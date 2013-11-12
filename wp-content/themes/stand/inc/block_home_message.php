<?php
/**
 * Block Template for the Homepage Message
 */
global $mav_data;
?>
<?php if ( $mav_data['home_message_title'] ) : ?>
<h1><?php echo do_shortcode(stripslashes($mav_data['home_message_title'])); ?></h1>
<?php endif; ?>
<?php if ( $mav_data['home_message_text'] ) : ?>
<p><?php echo do_shortcode(stripslashes($mav_data['home_message_text'])); ?></p>
<?php endif; ?>

<?php if ( has_nav_menu( 'secondary' ) ) : ?>
<?php
wp_nav_menu( array(
	'container_class' => 'custom-menu',
	'theme_location'  => 'secondary',
	'fallback_cb'     => false
) );
?>
<?php endif; ?>
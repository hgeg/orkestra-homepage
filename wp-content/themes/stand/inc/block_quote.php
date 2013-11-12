<?php
/**
 * Block Template for the Homepage Quote
 */
global $mav_data;
?>
<?php if ( $mav_data['quote_text'] ) : ?>
<p><?php echo do_shortcode(stripslashes($mav_data['quote_text'])); ?></p>
<?php endif; ?>
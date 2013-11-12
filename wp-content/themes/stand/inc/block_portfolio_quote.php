<?php
/**
 * Block Template for the Portfolio Quote
 */
global $mav_data;
?>
<?php if ( $mav_data['portfolio_quote_text'] ) : ?>
<p><?php echo do_shortcode(stripslashes($mav_data['portfolio_quote_text'])); ?></p>
<?php endif; ?>
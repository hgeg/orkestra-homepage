
	</div> <!-- /end .wrapper -->
</div> <!-- /end #main -->

<?php get_sidebar( 'footer' ); ?>

<footer id="footer">
	<div class="wrapper clearfix">

		<?php global $mav_data; // fetch options stored in $mav_data ?>

		<section id="site-generator">
			<?php
			if ( has_nav_menu( 'third' ) ) :
				wp_nav_menu( array(
					'container_class' => 'custom-menu',
					'theme_location' => 'third',
					'fallback_cb' => false
				) );
			endif; ?>
			<?php if ( $mav_data['footer_text_right'] ) : ?>
			<p class="footer-text">
			<?php echo do_shortcode(stripslashes($mav_data['footer_text_right'])); ?>
			</p> <!-- /end .footer-text -->
			<?php endif; ?>
		</section> <!-- /end #site-generator -->

		<section id="site-info">
			<?php if ( $mav_data['footer_text_left'] ) : ?>
			<p class="footer-text">
			<?php echo do_shortcode(stripslashes($mav_data['footer_text_left'])); ?>
			</p> <!-- /end .footer-text -->
			<?php endif; ?>
		</section> <!-- /end #site-info -->

	</div> <!-- /end .wrapper -->
</footer> <!-- /end #footer -->

<p id="back-top"><a href="#top"><span></span></a></p>

<?php // Allow slider to display srcollbar color and avoid js conflicts.
$scrollbar_color = $mav_data['primary_color']; /*'#fff'*/ ?>
<script type="text/javascript">
	var color = "<?php echo $scrollbar_color; ?>";
</script>

<?php wp_footer(); ?>

</body>
</html>

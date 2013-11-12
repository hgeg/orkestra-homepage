
<?php if ( is_active_sidebar( 'primary-blog-widget-area' ) ) : ?>
<aside id="primary" class="widget-area" role="complementary">
	<ul class="xoxo">
		<?php dynamic_sidebar( 'primary-blog-widget-area' ); ?>
	</ul>
</aside> <!-- /end #primary -->
<?php endif; ?>

<?php if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>
<aside id="secondary" class="widget-area" role="complementary">
	<ul class="xoxo">
		<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
	</ul>
</aside> <!-- /end #secondary -->
<?php endif; ?>

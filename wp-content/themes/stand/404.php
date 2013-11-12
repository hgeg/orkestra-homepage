<?php /*
<script type="text/javascript">
	top.location.href = '<?php echo home_url(); ?>';
</script> */ ?>

<?php get_header(); ?>

<section id="content" role="main">

	<header class="page-header">
		<h1 class="entry-title"><?php _e( 'Nothing Found', 'framework' ); ?></h1>
	</header> <!-- /end .page-header -->

	<section class="entry-content">
		<p><?php _e( 'Sorry, but the page you were trying to reach could not be found. Perhaps searching will help find a related article.', 'framework' ); ?></p>
		<?php get_search_form(); ?>
	</section> <!-- /end .entry-content -->

</section> <!-- /end #content -->

<script type="text/javascript">
	// focus on search field after it has loaded
	document.getElementById('s') && document.getElementById('s').focus();
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

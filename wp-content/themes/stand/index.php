
<?php get_header(); ?>

<section id="content" role="main">
	<?php get_template_part( 'loop' ); // Run the loop to output the posts, it makes the frontpage blog. ?>
</section> <!-- /end #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

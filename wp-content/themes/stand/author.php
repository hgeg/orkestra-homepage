
<?php get_header(); ?>

<section id="content" role="main">

	<?php if ( have_posts() ) the_post(); ?>

	<header class="page-header">
		<h1 class="page-title author"><?php printf( __( 'Author Archive: %s', 'framework' ), "<span class='vcard'>" . get_the_author() . "</span>" ); ?></h1>
	</header> <!-- /end .page-header -->

	<?php
	// If a user has filled out their description, show a bio on their entries.
	if ( get_the_author_meta( 'description' ) ) : ?>
	<div class="author-info">
		<div class="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'framework_author_bio_avatar_size', 80 ) ); ?>
		</div> <!-- .author-avatar -->
		<div class="author-description">
			<h3><?php printf( __( 'About %s', 'framework' ), get_the_author() ); ?></h3>
			<span class="author-meta-url"><a href="<?php the_author_meta( 'url' ); ?>" target="_blank"><?php the_author_meta( 'url' ); ?></a></span>
			<p><?php the_author_meta( 'description' ); ?></p>
		</div> <!-- .author-description	-->
	</div> <!-- .author-info -->
	<?php endif; ?>

	<?php
		/* Since we called the_post() above, we need to
 	 	 * rewind the loop back to the beginning that way
 	 	 * we can run the loop properly, in full.
 	 	 */
		rewind_posts();

		/* Run the loop for the author archive page to output the authors posts
 	 	 * If you want to overload this in a child theme then include a file
 	 	 * called loop-author.php and that will be used instead.
 	 	 */
 		get_template_part( 'loop', 'author' );
	?>

</section><!-- /end #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>


<?php get_header(); ?>

<section id="content" role="main">

	<?php if ( have_posts() ) the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php

		// Load Post Formats
		$format = get_post_format();

		if ( false === $format )
			$format = 'standard';

		get_template_part( 'format', $format );

		?>
	
		<?php
		// If a user has filled out their description, show a bio on their entries.
		if ( get_the_author_meta( 'description' ) ) : ?>
		<div class="author-info">
			<div class="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'framework_author_bio_avatar_size', 80 ) ); ?>
			</div> <!-- .author-avatar -->
			<div class="author-description">
				<h3><?php printf( __( 'Author: %s', 'framework' ), get_the_author() ); ?></h3>
				<span class="author-meta-url"><a href="<?php the_author_meta( 'url' ); ?>" target="_blank"><?php the_author_meta( 'url' ); ?></a></span>
				<p><?php the_author_meta( 'description' ); ?></p>
			</div> <!-- .author-description	-->
		</div> <!-- .author-info -->
		<?php endif; ?>

	</article> <!-- #post-<?php the_ID(); ?> -->

	<?php
	if ( $mav_data['related_posts'] ) {
		get_template_part( 'inc/related-posts' );
	}
	?>

	<?php comments_template( '', true ); ?>

	<div id="navigation">
		<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'framework' ) . '</span> %title' ); ?></div>
		<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'framework' ) . '</span>' ); ?></div>
	</div>

</section> <!-- /end #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>


<?php get_header(); ?>

<section id="content" class="one-column" role="main">
	
	<?php if ( have_posts() ) the_post(); ?>

	<header class="entry-meta">
		<h2 class="entry-title"><?php the_title(); ?></h2>

		<?php if ( ! empty( $post->post_parent ) ) : ?>
		<h3><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php esc_attr( printf( __( 'Return to %s', 'framework' ), get_the_title( $post->post_parent ) ) ); ?>" rel="gallery">
			<?php /* translators: %s - title of parent post */
				printf( __( '%s', 'framework' ), get_the_title( $post->post_parent ) );?></a>
		</h3>
		<?php endif; ?>

		<span class="posted-on"><?php _e( 'Posted on', 'framework' ); ?> <a href="<?php the_permalink() ?>"><?php /* http://codex.wordpress.org/Formatting_Date_and_Time */ echo get_the_date('F j, Y'); ?></a></span>

		<span class="by-author"><?php _e( 'by', 'framework' ); ?> <?php the_author_posts_link(); ?></span>

		<?php if ( comments_open() ) : ?>
		<span class="comments-link">
			<?php comments_popup_link( '<span class="leave-reply">' . __( 'Add Comment', 'framework' ) . '</span>', __( '<strong>1</strong> Comment', 'framework' ), __( '<strong>%</strong> Comments', 'framework' ) ); ?>
		</span> <!-- /end .comments-link -->
		<?php endif; ?>

		<span class="image-size">
		<?php
		if ( wp_attachment_is_image() ) {
				echo '<span class="meta-sep">(</span> ';
				$metadata = wp_get_attachment_metadata();
				printf( __( 'full size is %s pixels', 'framework' ),
				sprintf( '<a href="%1$s" title="%2$s">%3$s &times; %4$s</a>',
				wp_get_attachment_url(),
				esc_attr( __( 'Link to full-size image', 'framework' ) ),
					$metadata['width'],
					$metadata['height']
				)
			);
			echo ' <span class="meta-sep">)</span> ';
		}
		?>
		</span> <!-- /end .image-size -->

	</header> <!-- /end .entry-meta -->

	<section class="entry-content">

		<div class="entry-attachment">
			<?php if ( wp_attachment_is_image() ) :
			$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
			foreach ( $attachments as $k => $attachment ) {
				if ( $attachment->ID == $post->ID )
					break;
			}
			$k++;
			// If there is more than 1 image attachment in a gallery
			if ( count( $attachments ) > 1 ) {
				if ( isset( $attachments[ $k ] ) )
					// get the URL of the next image attachment
				$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
				else
				// or get the URL of the first image attachment
				$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
			} else {
				// or, if there's only 1 image attachment, get the URL of the image
				$next_attachment_url = wp_get_attachment_url();
			}
			?>
			<p class="attachment">
				<a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
				$attachment_width  = apply_filters( 'framework_attachment_size', 940 );
				$attachment_height = apply_filters( 'framework_attachment_height', 940 );
				echo wp_get_attachment_image( $post->ID, array( $attachment_width, $attachment_height ) ); // filterable image width with, essentially, no limit for image height.
				?></a>
			</p>

		</div>

		<div class="entry-caption"><?php if ( !empty( $post->post_excerpt ) ) the_excerpt(); ?></div>

		<?php the_content( __( 'Read More', 'framework' ) ); ?>

	</section><!-- /end .entry-content -->
	

	<?php /*comments_template( '', true );*/ ?>

	<?php // http://codex.wordpress.org/Function_Reference/previous_image_link 
	/*
	<div id="navigation">
		<div class="nav-previous"><?php previous_image_link( false ); ?></div>
		<div class="nav-next"><?php next_image_link( false ); ?></div>
	</div>
	*/ ?>
	<?php else : ?>
	<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
	<?php endif; ?>


	<?php if ( is_user_logged_in() ) { ?><span class="edit-link"><?php edit_post_link('edit', '', ''); ?></span><?php } ?>

</section> <!-- /end #content -->

<?php get_footer(); ?>

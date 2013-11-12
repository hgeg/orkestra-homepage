
<?php $quote = get_post_meta( get_the_ID(), 'of_quote', true ); ?>
<?php $label = get_post_meta( get_the_ID(), 'of_label', true ); ?>

<?php if ( is_sticky() ) : ?>
<hgroup class="post-labels">
	<span href="<?php the_permalink() ?>" class="entry-format sticky"><?php _e( 'Featured', 'framework' ); ?></span>
	<?php /*if ($label) { ?><span href="<?php the_permalink() ?>" class="entry-format <?php echo $label ?>"><?php _e( $label, 'framework' ); ?></span><?php }*/ ?>
</hgroup> <!-- /end .post-labels -->
<?php endif; ?>

<header class="entry-meta">	

	<span class="format-label"><a href="<?php the_permalink() ?>" class="entry-format quote"><?php _e( 'Quote', 'framework' ); ?></a></span>

<?php if ( 'post' == get_post_type() ) : ?>

	<?php if ( comments_open() ) : ?>
	<span class="comments-link">
		<?php comments_popup_link( '<span class="leave-reply">' . __( 'Add Comment', 'framework' ) . '</span>', __( '<span>1</span> Comment', 'framework' ), __( '<span>%</span> Add Comments', 'framework' ) ); ?>
	</span> <!-- /end .comments-link -->
	<?php endif; ?>

	<span class="posted-on"><?php _e( 'Posted on', 'framework' ); ?> <a href="<?php the_permalink() ?>"><?php /* http://codex.wordpress.org/Formatting_Date_and_Time */ echo get_the_date('F j, Y'); ?></a></span>

	<span class="by-author"><?php _e( 'by', 'framework' ); ?> <?php the_author_posts_link(); ?></span>
<br/>
	<?php
	$categories_list = get_the_category_list( __( ' ', 'framework' ) );
	if ( $categories_list ): ?>
	<span class="cat-links">
		<?php printf( __( '%2$s', 'framework' ), '', $categories_list ); ?>
	</span>
	<?php endif; // if categories /ends ?>

<?php endif; ?>

	<h1 class="quote"><?php echo $quote; ?></h1>

	<?php if ( is_single() ) { ?>
	<h3 class="entry-title"><?php the_title(); ?></h3>
	<?php } else { ?>
	<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'framework' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
	<?php } ?>

</header> <!-- /end header.entry-meta -->

<?php if ( is_single() ) { ?>
<section class="entry-content">
	<?php //the_content(); ?>
	<?php the_content( __( 'Read More', 'framework' ) ); ?>
</section> <!-- /end .entry-content -->
<?php } ?>

<?php if ( is_single() ) : ?>
<footer class="entry-meta">

<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>

	<?php
	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', __( ', ', 'framework' ) );
	if ( $tags_list ): ?>
	<span class="tag-links">
		<?php printf( __( '<span class="tagged">Tagged:</span> %2$s', 'framework' ), '', $tags_list ); ?>
	</span>
	<?php endif; ?>

<?php endif; ?>

</footer> <!-- /end footer.entry-meta -->
<?php endif; ?>

<?php if ( is_user_logged_in() ) { ?><span class="edit-link"><?php edit_post_link('edit', '', ''); ?></span><?php } ?>

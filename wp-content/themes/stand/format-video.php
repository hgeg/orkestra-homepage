
<?php $video_poster = get_post_meta( get_the_ID(), 'of_video_poster', true ); ?>
<?php $video_mp4 = get_post_meta( get_the_ID(), 'of_video_mp4', true ); ?>
<?php $video_ogg = get_post_meta( get_the_ID(), 'of_video_ogg', true ); ?>
<?php $video_webm = get_post_meta( get_the_ID(), 'of_video_webm', true ); ?>
<?php $video_embedded = get_post_meta( get_the_ID(), 'of_video_embedded', true ); ?>
<?php $video_sub = get_post_meta( get_the_ID(), 'of_video_sub', true ); ?>
<?php $video_sub_src = get_post_meta( get_the_ID(), 'of_video_sub_src', true ); ?>
<?php $label = get_post_meta( get_the_ID(), 'of_label', true ); ?>
<?php $video_width = 560; ?>
<?php //$video_height = get_post_meta( get_the_ID(), 'of_video_height', true ); ?>
<?php $video_height = 361; ?>

<?php if ( is_sticky() ) : ?>
<hgroup class="post-labels">
	<span href="<?php the_permalink() ?>" class="entry-format sticky"><?php _e( 'Featured', 'framework' ); ?></span>
	<?php /*if ($label) { ?><span href="<?php the_permalink() ?>" class="entry-format <?php echo $label ?>"><?php _e( $label, 'framework' ); ?></span><?php }*/ ?>
</hgroup> <!-- /end .post-labels -->
<?php endif; ?>

<?php if ( ( $video_mp4 ) || ( $video_webm ) || ( $video_ogg ) ) { ?>
<video id="player-video" width="<?php echo $video_width; ?>" height="<?php echo $video_height; ?>" controls="controls" preload="none" poster="<?php echo $video_poster; ?>">
	<?php if ($video_mp4) { ?><!-- MP4 source must come first for iOS, Safari, IE9, Android, and Windows Phone 7 -->
	<source type="video/mp4" src="<?php echo $video_mp4; ?>" /><?php } ?>
	<?php if ($video_webm) { ?><!-- WebM/VP8 for Firefox4, Opera, and Chrome -->
	<source type="video/webm" src="<?php echo $video_webm; ?>" /><?php } ?>
	<?php if ($video_ogg) { ?><!-- Ogg/Vorbis for older Firefox and Opera versions -->
	<source type="video/ogg" src="<?php echo $video_ogg; ?>" /><?php } ?>
	<?php if ($video_sub) { ?><!-- Optional: Add subtitles for each language -->
	<track kind="subtitles" src="<?php echo $video_sub; ?>" srclang="<?php echo $video_sub_src; ?>" /><?php } ?>
	<!-- Fallback flash player for no-HTML5 browsers with JavaScript turned off -->
	<object width="<?php echo $video_width; ?>" height="<?php echo $video_height; ?>" type="application/x-shockwave-flash" data="<?php echo get_template_directory_uri(); ?>/js/flashmediaelement.swf"> 		
		<param name="movie" value="<?php echo get_template_directory_uri(); ?>/js/flashmediaelement.swf" />
		<param name="flashvars" value="controls=true&amp;file=<?php echo $video_mp4; ?>" /> 		
		<!-- Image fall back for non-HTML5 browser with JavaScript turned off and no Flash player installed -->
		<img src="<?php echo $video_poster; ?>" width="<?php echo $video_width; ?>" height="<?php echo $video_height; ?>" alt="Here we are" title="No video playback capabilities" />
	</object>
</video>
<?php
} else {
	if ($video_embedded) { ?>
<section class="embedded">
	<?php echo $video_embedded; // Not self hosted videos ?>
</section>
<?php }
} ?>

<header class="entry-meta">
	
	<?php if ( is_single() ) { ?>
	<h2 class="entry-title"><?php the_title(); ?></h2>
	<?php } else { ?>
	<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'framework' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<?php } ?>

	<span class="format-label"><a href="<?php the_permalink() ?>" class="entry-format video"><?php _e( 'Video', 'framework' ); ?></a></span>

<?php if ( 'post' == get_post_type() ) : ?>

	<?php if ( comments_open() ) : ?>
	<span class="comments-link">
		<?php comments_popup_link( '<span class="leave-reply">' . __( 'Add Comment', 'framework' ) . '</span>', __( '<span>1</span> Comment', 'framework' ), __( '<span>%</span> Comments', 'framework' ) ); ?>
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

</header> <!-- /end header.entry-meta -->


<section class="entry-content">
	<?php the_content( __( 'Read More', 'framework' ) ); ?>
</section> <!-- /end .entry-content -->


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

</footer> <!-- /end header.entry-meta -->
<?php endif; ?>

<?php if ( is_user_logged_in() ) { ?><span class="edit-link"><?php edit_post_link('edit', '', ''); ?></span><?php } ?>

<script type="text/javascript">
jQuery('audio').mediaelementplayer({
	defaultVideoWidth: <?php echo $video_width; ?>,
	defaultVideoHeight: <?php echo $video_height; ?>
});
</script>

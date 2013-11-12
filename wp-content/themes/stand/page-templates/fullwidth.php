<?php

/* Template Name: Full Width */

get_header();

?>

<section id="content" class="one-column" role="main">

	<?php if ( have_posts() ) the_post(); ?>

	<header class="page-header">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</header> <!-- /end .page-header -->

	<section class="entry-content">
		<?php the_content(); ?>
	</section> <!-- /end .entry-content -->

	<span class="edit-link"><?php edit_post_link('edit', '', ''); ?></span>

	<?php comments_template( '', true ); ?>

</section> <!-- /end #content .one-column -->

<?php get_footer(); ?>

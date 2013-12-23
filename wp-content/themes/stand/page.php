
<?php get_header(); ?>

<section id="content" role="main">
	
	<?php if ( have_posts() ) the_post(); ?>
	
	<header class="page-header">
		<?php if ( is_front_page() ) { ?>
		<h2 class="entry-title"><?php the_title(); ?></h2>
		<?php } else { ?>
		<h1 class="page-title"><?php the_title(); ?></h1>
		<?php } ?>
	</header> <!-- /end .page-header -->

	<section class="entry-content">
		<?php the_content( __( '[:en]Read More[:tr]Devamını Oku', 'framework' ) ); ?>
	</section> <!-- /end .entry-content -->
	
	<?php comments_template( '', true ); ?>

	<span class="edit-link"><?php edit_post_link('edit', '', ''); ?></span>

</section> <!-- /end #content -->

<?php get_sidebar('page'); ?>
<?php get_footer(); ?>

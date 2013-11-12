<?php

/* Template Name: Archives */

get_header();

?>

<section id="content" class="archives" role="main">

	<?php if ( have_posts() ) the_post(); ?>

	<header class="page-header">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</header> <!-- /end .page-header -->

	<?php if( $post->post_content == "" ) : ?>
	<?php /* Do stuff with empty posts (or leave blank to skip empty posts) */ ?>
	<?php else : ?>
	<section class="entry-content">
		<?php the_content(); ?>
	</section> <!-- /end .entry-content -->
	<?php endif; ?>

	<aside id="archives-content">

		<section class="archives-block-first">

			<section class="archives-content-blog-posts">
				<h3><?php _e( 'Latest 30 Posts', 'framework' ); ?></h3>
				<ul>
					<?php
					$args = array( 'numberposts' => '30' );
					$recent_posts = wp_get_recent_posts( $args );
					foreach( $recent_posts as $post ){
						echo '<li><a href="' . get_permalink($post["ID"]) . '" title="Look '.$post["post_title"].'" >' .   $post["post_title"].'</a> </li> ';
					}
					?>
				</ul>
			</section> <!-- /end .archives-content-blog-posts -->

			<section class="archives-content-categories">
				<h3><?php _e( 'Categories Archives', 'framework' ); ?></h3>
				<ul>
					<?php wp_list_categories( 'title_li=' ); ?>
				</ul>
			</section> <!-- /end .archives-content-categories -->

			<section class="archives-content-month">
				<h3><?php _e( 'Monthly Archives', 'framework' ); ?></h3>
				<ul>
					<?php wp_get_archives( 'type=monthly' ); ?>
				</ul>
			</section> <!-- /end .archives-content-month -->

			<?php
			global $of_set;
			if ( $of_set['portfolio'] == true ) :
			?>
			<section class="archives-content-portfolio">
				<h3><?php _e( 'Portfolio Archives', 'framework' ); ?></h3>

				<?php
				$custom_terms = get_terms('portfolios');

				foreach($custom_terms as $custom_term) {
					wp_reset_query();
					$args = array(
						'post_type' => 'project',
						'tax_query' => array(
							array(
								'taxonomy' => 'portfolios',
								'field' => 'slug',
								'terms' => $custom_term->slug,
								),
							),
						);

					$loop = new WP_Query($args);

					if($loop->have_posts()) {
						echo '<span class="archive-portfolios">'.$custom_term->name.'</span>';
						echo '<ul>';
						while($loop->have_posts()) : $loop->the_post();
						echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
						endwhile;
						echo '</ul>';
						}
					}
				?>

			</section> <!-- /end .archives-content-portfolio -->
			<?php endif; ?>

		</section> <!-- /end .archives-block-first -->

	</aside> <!-- /end .archives-content -->

	<span class="edit-link"><?php edit_post_link('edit', '', ''); ?></span>

</section> <!-- /end #content -->

<?php get_sidebar('page'); ?>
<?php get_footer(); ?>

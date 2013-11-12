<?php
/**
 * Block Template for Homepage Portfolios
 */

global $mav_data; // fetch options stored in $mav_data

$portfolios_home_title = $mav_data['portfolios_home_title'];
// $portfolios_home_postperpage = $mav_data['portfolios_home_postperpage'];
$portfolio_order_1 = $mav_data['portfolio_order_1']; // date, title
$portfolio_order_2 = $mav_data['portfolio_order_2']; // ASC, DESC
$portfolios_img_width = 300;
$portfolios_img_height = 210;
// $portfolio_home_project = $mav_data['portfolio_home_page'];
$portfolios_desc = $mav_data['portfolios_desc'];

/**
 * Get Portfolios Taxonomy and related Portfolios Images (! not Portfolios Posts !)
 */
$portfolios = get_terms('portfolios', 'hide_empty=0');
if ( count( $portfolios ) <= 0 ) return;
?>

<header class="page-header">
	<?php if ($portfolios_home_title) { ?><h1 class="entry-title"><?php echo do_shortcode(stripslashes($portfolios_home_title)); ?></h1><?php } ?>
	<?php if ($portfolios_desc) { ?><p class="portfolio-header-description"><?php echo do_shortcode(stripslashes( $portfolios_desc )); ?></p><?php } ?>
</header> <!-- /end .page-header -->

<section id="portfolios">
	<?php
	foreach ($portfolios as $portfolio) {

		// Get description/ uri/ etc
		$portfolio_permalink = esc_attr(get_term_link($portfolio->name, 'portfolios'));
		$portfolio_desc = $portfolio->description;

		$tag_extra_fields = get_option('portfolios_fields');
		// Need some proof check to ensure that no "notice" is thrown ...
		if ( ! empty( $portfolio ) ) {
			if ( isset( $tag_extra_fields[$portfolio->term_id] ) ) {

				$term_slug = $portfolio->slug;

				if ( isset( $tag_extra_fields[$portfolio->term_id]['_portfolios_lightbox_uri'] ) ) {
					$lightbox_path = $tag_extra_fields[$portfolio->term_id]['_portfolios_lightbox_uri'];
				} else {
					$lightbox_path = '';
				}

				if ( $tag_extra_fields[$portfolio->term_id]['portfolios_image_id'] ) {

					$thumb_ID = $tag_extra_fields[$portfolio->term_id]['portfolios_image_id'];
					$thumb = wp_get_attachment_image( $thumb_ID, 'mav-thumbnails', false, array( 'id' => "portfolios_post_image_thumb-$term_slug", 'class' => 'portfolios_post_image_thumb portfolios_post_image_thumb_visible', 'alt' =>  $portfolio->name ) );

					if ( empty ($thumb) ) {
						$thumb = $empty_thumb;
					}

				} else {
					$thumb = '<img id="portfolios_post_image_thumb-$term_slug" class="portfolios_post_image_thumb" src="' . get_template_directory_uri() . '/images/thumb.png" width="' . $portfolios_img_width . '" height="' . $portfolios_img_height . '" alt="' . $portfolio->name . '" />';
				}
			} else {
				$thumb = '<img id="portfolios_post_image_thumb-$term_slug" class="portfolios_post_image_thumb" src="' . get_template_directory_uri() . '/images/thumb.png" width="' . $portfolios_img_width . '" height="' . $portfolios_img_height . '" alt="' . $portfolio->name . '" />';
			}
		} else {
			$thumb = '<img id="portfolios_post_image_thumb-$term_slug" class="portfolios_post_image_thumb" src="' . get_template_directory_uri() . '/images/thumb.png" width="' . $portfolios_img_width . '" height="' . $portfolios_img_height . '" alt="' . $portfolio->name . '" />';
		}
	?>

	<article class="element <?php //foreach ($terms as $term) { echo strtolower(preg_replace('/\s+/', '-', $term->name)). ' '; } ?>">

		<?php
		if ( $lightbox_path != '' ) { ?>
			<div class="lightbox">
				<a href="<?php echo $lightbox_path ?>" data-rel="prettyPhoto" title="<?php the_title_attribute(); ?>">
					<span class="overlay lightbox"></span>
					<?php echo( $thumb ); ?>
				</a>
			</div>
		<?php
		} elseif ($portfolio_permalink) {
		?>
			<a href="<?php echo $portfolio_permalink ?>" rel="bookmark">
				<span class="overlay">
					<span class="view"><?php _e( 'View', 'framework' ); ?></span>
				</span>
				<?php echo( $thumb ); ?>
			</a>

		<?php
		} else {
			echo( $thumb );
		}
		?>

		<h3 class="entry-title">
			<?php if ($portfolio_permalink) { ?>
			<a href="<?php echo $portfolio_permalink ?>" rel="bookmark"><?php echo( $portfolio->name ); ?></a>
			<?php } else { ?>
			<a href="<?php the_permalink() ?>" rel="bookmark"><?php echo( $portfolio->name ); ?></a>
			<?php } ?>
		</h3>

		<?php if ($portfolio_desc) { ?><p class="project-description"><?php echo do_shortcode(stripslashes($portfolio_desc)); ?></p><?php } ?>

	</article> <!-- /end .element -->

	<?php
	}
?>

</section> <!-- /end #portfolios -->

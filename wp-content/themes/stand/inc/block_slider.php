<?php
/**
 * Block Template for Homepage Slider
 */

global $mav_data; // fetch options stored in $mav_data

$mav_slider_height = $mav_data['slider_height'];
$mav_slider_arrows = $mav_data['slider_arrows'];
$mav_slider_buttons = $mav_data['slider_buttons'];
?>
<section id="slider-default" class="slider-default" style="height:<?php echo $mav_slider_height ?>px">

	<div class="slider">
		<?php

		$slides = $mav_data['slider_home']; // get the slides array

		foreach ($slides as $slide) { ?>
		<figure class="item">
			<div class="inner">
				<?php if ($slide['title'] or $slide['description']) { ?>
				<section class="slider-text">
					<?php if ($slide['title'] != '') { ?><h2 class="title"><?php echo do_shortcode(stripslashes($slide['title'])); ?></h2><?php } ?>
					<?php if ($slide['description'] != '') { ?><p class="desc"><?php echo do_shortcode(stripslashes($slide['description'])); ?></p><?php } ?>
				</section>
				<?php } ?>

				<?php if ($slide['url'] != '') { ?>
					<?php if ($slide['link']) { ?><a href="<?php echo $slide['link']; ?>" target="<?php echo( $slide['link_behaviour'] == 'New Window' ? "_blank" : "_self" ); ?>"><?php } ?>					
					<img src="<?php echo $slide['url']; ?>" data-thumb="<?php echo $slide['url']; ?>" alt="<?php echo $slide['title']; ?>">
					<?php if ($slide['link']) { ?></a><?php } ?>
					<?php } else { ?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/slider.png" alt="Slider">
				<?php } ?>

			</div> <!--  /end .inner -->
		</figure> <!--  /end .item -->
		<?php } // end foreach ?>

	</div> <!-- /end .slider -->

	<div class="slider-selectors">

		<?php if ($mav_slider_buttons == "true") { ?>
		<div class="slider-buttons">
			<?php foreach ($slides as $slide) { ?>
			<div class="button"></div>
			<?php } // end foreach ?>
		</div>
		<?php } ?>

		<?php if ($mav_slider_arrows == "true") { ?>
		<div class="prevButton unselectable"></div>
		<div class="nextButton unselectable"></div>
		<?php } ?>

	</div> <!-- /end .slider-selectors -->

	<div class="scrollbar-container"></div>

</section> <!-- /end #slider-default -->

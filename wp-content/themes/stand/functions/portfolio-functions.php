<?php

/*-------------------------------------------------------------------------------------------*/
/* Project Post Type */
/*-------------------------------------------------------------------------------------------*/

function projectposttype_activation() {
	projectposttype();
}

register_activation_hook( __FILE__, 'projectposttype_activation' );


/*-------------------------------------------------------------------------------------------*/
/* Enable the project custom post type */
/*-------------------------------------------------------------------------------------------*/

/**
 * Register the project custom post type
 * http://codex.wordpress.org/Function_Reference/register_post_type
 */

function projectposttype() {

	$labels = array(
		'name' => __( 'Projects', 'framework' ),
		'singular_name' => __( 'Project', 'framework' ),
		'add_new' => __( 'Add New Project', 'framework' ),
		'add_new_item' => __( 'Add New Project', 'framework' ),
		'edit_item' => __( 'Edit Project Post', 'framework' ),
		'new_item' => __( 'Add New Project', 'framework' ),
		'view_item' => __( 'View Project', 'framework' ),
		'search_items' => __( 'Search Project', 'framework' ),
		'not_found' => __( 'No Projects found', 'framework' ),
		'not_found_in_trash' => __( 'No Project found in trash', 'framework' ),
		'all_items' => __( 'All Projects', 'framework' ),
		'menu_name' => __( 'Projects', 'portfolios', 'framework' )
	);

	$args = array(
    	'labels' => $labels,
    	'public' => true,
		'publicly_queryable' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions' ),
		'capability_type' => 'post',
		'rewrite' => array( "slug" => "project", 'with_front' => true ),//false,
		'menu_position' => 4,
		'has_archive' => true,
        'query_var' => "project"
	);

	register_post_type( 'project', $args );

}

add_action( 'init', 'projectposttype' );



/**
 * Register project categoies tax
 */

function register_project_category() {

    $taxonomy_project_category_labels = array(
		'name' => _x( 'Project Categories', 'projectposttype', 'framework' ),
		'singular_name' => _x( 'Project Category', 'projectposttype', 'framework' ),
		'search_items' => _x( 'Search Project Categories', 'projectposttype', 'framework' ),
		'popular_items' => _x( 'Popular Project Categories', 'projectposttype', 'framework' ),
		'all_items' => _x( 'All Project Categories', 'projectposttype', 'framework' ),
		'parent_item' => _x( 'Parent Project Category', 'projectposttype', 'framework' ),
		'parent_item_colon' => _x( 'Parent Project Category:', 'projectposttype', 'framework' ),
		'edit_item' => _x( 'Edit Project Category', 'projectposttype', 'framework' ),
		'update_item' => _x( 'Update Project Category', 'projectposttype', 'framework' ),
		'add_new_item' => _x( 'Add New Project Category', 'projectposttype', 'framework' ),
		'new_item_name' => _x( 'New Project Category Name', 'projectposttype', 'framework' ),
		'separate_items_with_commas' => _x( 'Separate Project Categories with commas', 'projectposttype', 'framework' ),
		'add_or_remove_items' => _x( 'Add or remove Project Categories', 'projectposttype', 'framework' ),
		'choose_from_most_used' => _x( 'Choose from the most used Project Categories', 'projectposttype', 'framework' ),
		'menu_name' => _x( 'Categories', 'projectposttype', '' )
    );

    $taxonomy_project_category_args = array(
		'labels' => $taxonomy_project_category_labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'hierarchical' => true,
		'rewrite' => array( "slug" => "categories", 'with_front' => false ),
		'query_var' => true,
		'has_archive' => true
    );

    register_taxonomy( 'project_category', array( 'project' ), $taxonomy_project_category_args );

}

add_action( 'init', 'register_project_category' );


/**
 * Register project tags tax
 */

function register_project_tag() {

	$taxonomy_project_tag_labels = array(
		'name' => _x( 'Project Tags', 'projectposttype', 'framework' ),
		'singular_name' => _x( 'Project Tag', 'projectposttype', 'framework' ),
		'search_items' => _x( 'Search Project Tags', 'projectposttype', 'framework' ),
		'popular_items' => _x( 'Popular Project Tags', 'projectposttype', 'framework' ),
		'all_items' => _x( 'All Project Tags', 'projectposttype', 'framework' ),
		'parent_item' => _x( 'Parent Project Tag', 'projectposttype', 'framework' ),
		'parent_item_colon' => _x( 'Parent Project Tag:', 'projectposttype', 'framework' ),
		'edit_item' => _x( 'Edit Project Tag', 'projectposttype', 'framework' ),
		'update_item' => _x( 'Update Project Tag', 'projectposttype', 'framework' ),
		'add_new_item' => _x( 'Add New Project Tag', 'projectposttype', 'framework' ),
		'new_item_name' => _x( 'New Project Tag Name', 'projectposttype', 'framework' ),
		'separate_items_with_commas' => _x( 'Separate Project Tags with commas', 'projectposttype', 'framework' ),
		'add_or_remove_items' => _x( 'Add or remove Project Tags', 'projectposttype', 'framework' ),
		'choose_from_most_used' => _x( 'Choose from the most used Project Tags', 'projectposttype', 'framework' ),
		'menu_name' => _x( 'Tags', 'projectposttype', '' )
	);

	$taxonomy_project_tag_args = array(
		'labels' => $taxonomy_project_tag_labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'hierarchical' => false,
		'rewrite' => array( "slug" => "tags", 'with_front' => false ),
		'query_var' => true,
		'has_archive' => true
	);

	register_taxonomy( 'project_tag', array( 'project' ), $taxonomy_project_tag_args );

}

add_action( 'init', 'register_project_tag' );


/**
 * Register project portfolio tax
 */

function register_project_portfolios() {

    $labels = array(
        'name' => _x( 'Portfolios', 'portfolios', 'framework' ),
        'singular_name' => _x( 'Portfolios', 'portfolios', 'framework' ),
        'search_items' => _x( 'Search Portfolios', 'portfolios', 'framework' ),
        'popular_items' => _x( 'Popular Portfolios', 'portfolios', 'framework' ),
        'all_items' => _x( 'All Portfolios', 'portfolios', 'framework' ),
        'parent_item' => _x( 'Parent Portfolio', 'portfolios', 'framework' ),
        'parent_item_colon' => _x( 'Parent Portfolio:', 'portfolios', 'framework' ),
        'edit_item' => _x( 'Edit Portfolio', 'portfolios', 'framework' ),
        'update_item' => _x( 'Update Portfolio', 'portfolios', 'framework' ),
        'add_new_item' => _x( 'Add New Portfolio', 'portfolios', 'framework' ),
        'new_item_name' => _x( 'New Portfolio', 'portfolios', 'framework' ),
        'separate_items_with_commas' => _x( 'Separate portfolios with commas', 'portfolios', 'framework' ),
        'add_or_remove_items' => _x( 'Add or remove portfolios', 'portfolios', 'framework' ),
        'choose_from_most_used' => _x( 'Choose from the most used portfolios', 'portfolios', 'framework' ),
        'menu_name' => _x( 'Portfolios', 'portfolios', 'framework' )
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
		'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,
		'rewrite' => array( "slug" => "portfolio", 'with_front' => false ),	// vlad - original
		// 'rewrite' => array( "slug" => "", 'with_front' => true ), // Mav
        'query_var' => true
    );

    register_taxonomy( 'portfolios', array('project'), $args );

}

add_action( 'init', 'register_project_portfolios' );


/**
* Add additional fields to the portfolios taxonomy add view
*/

// the option name
define('PORTFOLIO_IMAGE', 'portfolios_fields');

// your fields (the form)
add_filter('portfolios_add_form_fields', 'portfolios_add_form_fields');
add_filter('portfolios_edit_form_fields', 'portfolios_edit_form_fields');

// Functions to add the extra fields
function portfolios_enqueue_scripts() {
	wp_enqueue_style('thickbox');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
}

function portfolios_add_form_fields($tag) {
	portfolios_enqueue_scripts();
	$tag_extra_fields = get_option(PORTFOLIO_IMAGE);
	?>

	<div class="form-field">
		<label for="_portfolios_image_uri">Portfolio Image</label>
		<input name="_portfolios_image_uri" id="_portfolios_image_uri" type="text" size="40" aria-required="false" value="" />
		<p class="description">The portfolio image.</p>
		<input name="_portfolios_image_id" id="_portfolios_image_id" type="hidden" size="40" aria-required="false" value="" />
		
		<label for="_portfolios_lightbox_uri">URL Link for Lightbox</label>
		<input name="_portfolios_lightbox_uri" id="_portfolios_lightbox_uri" type="text" size="40" aria-required="false" value="" />
		<p class="description">It can be image or video, it will be opened in the portfolio page.</p>

		<label for="_custom_bg_image_url">Custom Background Image URL</label>
		<input name="_custom_bg_image_url" id="_custom_bg_image_url" type="text" size="40" aria-required="false" value="" />
		<p class="description">Add a custom background image to this portfolio.</p>
	</div>

	<?php
}
function portfolios_edit_form_fields($tag) {
	portfolios_enqueue_scripts();
	$tag_extra_fields = get_option(PORTFOLIO_IMAGE);
	$width = 150;
	$height = 150;
	// Need some proof check to ensure that no "notice" is thrown ...
	if ( isset( $tag_extra_fields[$tag->term_id] ) ) {
		if ( $tag_extra_fields[$tag->term_id]['portfolios_image_id'] ) {
			$thumb_ID = $tag_extra_fields[$tag->term_id]['portfolios_image_id'];
			$thumb = wp_get_attachment_image( $thumb_ID, array($width, $height), false, array( 'id' => 'portfolios_image_thumb' ) );
		} else {
			$thumb_ID = '';
			$thumb = '<img id="portfolios_image_thumb" src="" width="150px" />';
		}
		if ( $tag_extra_fields[$tag->term_id]['portfolios_image_uri'] ) {
			$portfolios_image_uri = $tag_extra_fields[$tag->term_id]['portfolios_image_uri'];
		} else {
			$portfolios_image_uri = '';
		}
	} else {
		$thumb_ID = '';
		$thumb = '<img id="portfolios_image_thumb" src="" width="' . $width . '" height="' . $height . '" style="display:none;" />';
		$portfolios_image_uri = '';
	}
	?>

	<table class="form-table">
		<tr class="form-field">
			<th scope="row" valign="top"><label for="_portfolios_image_uri">Portfolio Image URL</label></th>
			<td><input name="_portfolios_image_uri" id="_portfolios_image_uri" type="text" size="40" aria-required="false" value="<?php echo( $portfolios_image_uri ); ?>" />
			<p class="description">The portfolio thumbnail.</p></td>
		</tr>
		<tr class="form-field">
			<td><input name="_portfolios_image_id" id="_portfolios_image_id" type="hidden" size="40" aria-required="false" value="<?php echo( $thumb_ID ); ?>" /></td>
			<td>
				<?php echo( $thumb ); ?>
				<br/><span class="button mav_remove_button_portfolio" id="reset_<?php echo $thumb_ID ?>" title="<?php echo $thumb_ID ?>" style="display:none;"><?php _e('Remove Media', 'framework') ?></span>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="_portfolios_lightbox_uri">URL Link for Lightbox</label></th>
			<td><input name="_portfolios_lightbox_uri" id="_portfolios_lightbox_uri" type="text" size="40" aria-required="false" value="<?php echo( $tag_extra_fields[$tag->term_id]['_portfolios_lightbox_uri'] ); ?>" />
			<p class="description">It can be image or video, it will be opened in the portfolio page.</p></td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="_custom_bg_image_url">Custom Background Image URL</label></th>
			<td><input name="_custom_bg_image_url" id="_custom_bg_image_url" type="text" size="40" aria-required="false" value="<?php echo( $tag_extra_fields[$tag->term_id]['_custom_bg_image_url'] ); ?>" />
			<p class="description">Add a custom background image to this portfolio.</p></td>
		</tr>
	</table>

	<?php
}


// When the form gets submitted, and the portfolios tax gets updated (in your case the option will get updated with the values of your custom fields above
add_filter('edited_portfolios', 'update_portfolios_fields');
add_filter('created_portfolios', 'update_portfolios_fields');
function update_portfolios_fields($term_id) {
	if( isset($_POST['taxonomy']) == 'portfolios'):
		$tag_extra_fields = get_option(PORTFOLIO_IMAGE);
		$tag_extra_fields[$term_id]['portfolios_image_uri'] = strip_tags(@$_POST['_portfolios_image_uri']);
		$tag_extra_fields[$term_id]['portfolios_image_id'] = strip_tags(@$_POST['_portfolios_image_id']);
		$tag_extra_fields[$term_id]['_portfolios_lightbox_uri'] = strip_tags(@$_POST['_portfolios_lightbox_uri']);
		$tag_extra_fields[$term_id]['_custom_bg_image_url'] = strip_tags(@$_POST['_custom_bg_image_url']);
		update_option(PORTFOLIO_IMAGE, $tag_extra_fields);
	endif;
}


// when a portfolios tax extra is removed
add_filter('deleted_term_taxonomy', 'remove_portfolios_fields');
function remove_portfolios_fields($term_id) {
  if( isset($_POST['taxonomy']) == 'portfolios'):
	$tag_extra_fields = get_option(PORTFOLIO_IMAGE);
	unset($tag_extra_fields[$term_id]);
	update_option(PORTFOLIO_IMAGE, $tag_extra_fields);
  endif;
}


/**
 * Edit Portfolio Post Page "Portfolio" metabox (dropdown to chose the portfolio of which the Portfolio Post belongs to)
 */

function framework_add_portfolios_box() {
	add_meta_box('portfolios', __( 'Portfolio', 'framework'), 'framework_portfolios_metabox_styling_function', 'project', 'side', '');

	/* Use the save_post action to save new post data */
	add_action('save_post', 'framework_portfolios_save_taxonomy_data');
}

function framework_add_portfolios_menus() {

	if ( ! is_admin() )
		return;

	add_action('admin_menu', 'framework_add_portfolios_box');
}

framework_add_portfolios_menus();


// This function gets called in edit-form-advanced.php
function framework_portfolios_metabox_styling_function($post, $box) {
	$defaults = array('taxonomy' => 'portfolios', 'id' => 'portfolios_categorydiv');
	if ( !isset($box['args']) || !is_array($box['args']) )
		$args = array();
	else
		$args = $box['args'];
	extract( wp_parse_args($args, $defaults), EXTR_SKIP );
	$tax = get_taxonomy($taxonomy);

	// Get all portfolios taxonomy terms
	$portfolios = get_terms('portfolios', 'hide_empty=0');

	?>
	<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">
		<ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
			<li class="tabs"><a href="#<?php echo $taxonomy; ?>-all"><?php echo $tax->labels->all_items; ?></a></li>
		</ul>
		<div id="<?php echo $taxonomy; ?>-all" class="tabs-panel" style="overflow: hidden;">

			<select name='post_portfolio' id='post_portfolio' class='postform'>
				<!-- Display portfolios as options -->
				<?php
					$names = wp_get_object_terms($post->ID, 'portfolios');

					if ( count( $portfolios ) <= 0 ) {
						echo( '<option class="theme-options" value="">None</option>' );
					} else {
						echo( '<option class="theme-options" value="">None</option>' );
						foreach ($portfolios as $portfolio) {
							if (!is_wp_error($names) && !empty($names) && !strcmp($portfolio->slug, $names[0]->slug)) {
								echo "<option class='theme-options' value='" . $portfolio->slug . "' selected>" . $portfolio->name . "</option>\n";
							} else {
								echo "<option class='theme-options' value='" . $portfolio->slug . "'>" . $portfolio->name . "</option>\n";
							}
						}
					}
			   ?>
			</select>

			<?php
			/*
			 * Portfolios Post Image
			 */
			?>
			<div id="portfolios-post-image">

				<?php
				$portfolios_img_width = 120;
				$portfolios_img_height = 120;
				if ( count( $portfolios ) <= 0 ) {
					echo( '<img src="" width="' . $portfolios_img_width . '" height="' . $portfolios_img_height . '" style="display: none;" />' );
				} else {
					foreach ($portfolios as $portfolio) {

						$tag_extra_fields = get_option('portfolios_fields');
						// Need some proof check to ensure that no "notice" is thrown ...
						if ( ! empty( $portfolio ) ) {
							if ( isset( $tag_extra_fields[$portfolio->term_id] ) ) {
								$term_slug = $portfolio->slug;
								if ( $tag_extra_fields[$portfolio->term_id]['portfolios_image_id'] ) {
									if (!is_wp_error($names) && !empty($names) && !strcmp($portfolio->slug, $names[0]->slug)) {
										$thumb_ID = $tag_extra_fields[$portfolio->term_id]['portfolios_image_id'];
										$thumb = wp_get_attachment_image( $thumb_ID, array($portfolios_img_width, $portfolios_img_height), false, array( 'id' => "portfolios_post_image_thumb-$term_slug", 'class' => 'portfolios_post_image_thumb portfolios_post_image_thumb_visible' ) );
									} else {
										$thumb_ID = $tag_extra_fields[$portfolio->term_id]['portfolios_image_id'];
										$thumb = wp_get_attachment_image( $thumb_ID, array($portfolios_img_width, $portfolios_img_height), false, array( 'id' => "portfolios_post_image_thumb-$term_slug", 'class' => 'portfolios_post_image_thumb portfolios_post_image_thumb_hidden' ) );
									}
								} else {
									$thumb = '<img id="portfolios_post_image_thumb" class="portfolios_post_image_thumb" src="" width="' . $portfolios_img_width . '" height="' . $portfolios_img_height . '" style="display: none;" />';
								}
							} else {
								$thumb = '<img id="portfolios_post_image_thumb" class="portfolios_post_image_thumb" src="" width="' . $portfolios_img_width . '" height="' . $portfolios_img_height . '" style="display: none;" />';
							}
						} else {
							$thumb = '<img id="portfolios_post_image_thumb" class="portfolios_post_image_thumb" src="" width="' . $portfolios_img_width . '" height="' . $portfolios_img_height . '" style="display: none;" />';
						}

						echo( $thumb );

					}
				}
				?>

			</div> <?php // end portfolios image ?>

		</div> <?php // end #$taxonomy-all ?>
	<?php
	echo '<input type="hidden" name="taxonomy_portfolios" id="taxonomy_portfolios" value="' .
			wp_create_nonce( 'taxonomy_portfolios' ) . '" />';
	?>
	</div>
<?php
}

function framework_portfolios_save_taxonomy_data($post_id) {

	if ( ! isset( $_POST['taxonomy_portfolios'] ) || ! wp_verify_nonce( $_POST['taxonomy_portfolios'], 'taxonomy_portfolios')) {
		return $post_id;
	}

	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;


	// Check permissions
	if ( 'project' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_posts', $post_id ) ) {
			return $post_id;
		}
	}

	// OK, we're authenticated: we need to find and save the data
	$post = get_post($post_id);
	if ( ($post->post_type == 'project') ) {
		$portfolio = $_POST['post_portfolio'];
		wp_set_object_terms( $post_id, $portfolio, 'portfolios', false );
	}

}

// Add Portfolios (taxonomy) image
function portfolios_edit_columns($portfolios_columns) {

	$portfolios_columns["thumbnail"] = __('Thumbnail', 'framework' );

	return $portfolios_columns;

}

add_filter( 'manage_edit-portfolios_columns', 'portfolios_edit_columns' );


function portfolios_columns_display($portfolios_columns, $column_name, $tag_id) {

		$width = 100;
		$height = 100;
		$tag_extra_fields = get_option('portfolios_fields');
		// Need some proof check to ensure that no "notice" is thrown ...
		if ( isset( $tag_extra_fields[$tag_id] ) ) {
			if ( $tag_extra_fields[$tag_id]['portfolios_image_id'] ) {
				$thumb_ID = $tag_extra_fields[$tag_id]['portfolios_image_id'];
				$thumb = wp_get_attachment_image( $thumb_ID, array($width, $height), false, array( 'id' => "portfolios_image_thumb-$tag_id", 'class' => 'portfolio_table_thumb' ) );
			} else {
				$thumb = __('None', 'framework');
			}
		} else {
			$thumb = __('None', 'framework');
		}

	if ( $column_name == 'thumbnail' ) {
		// Display the featured image in the column view if possible
		echo $thumb;
	}
}

add_action( 'manage_portfolios_custom_column',  'portfolios_columns_display', 10, 3 );



// Allow thumbnails to be used on portfolio post type
add_theme_support( 'post-thumbnails', array( 'project' ) );


/**
 * Add Columns to project Edit Screen
 * http://wptheming.com/2010/07/column-edit-pages/
 */

function projectposttype_edit_columns($project_columns) {

	$project_columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => _x('Title', 'column name', 'framework' ),
		"author" => __('Author', 'framework' ),
		"project_category" => __('Categories', 'framework' ),
		"project_tag" => __('Tags', 'framework' ),
		"comments" => __('Comments', 'framework' ),
		"date" => __('Date', 'framework' ),
		"thumbnail" => __('Thumbnail', 'framework' ),
		"portfolio" => __('Portfolio', 'framework' )
	);

	$project_columns['comments'] = '<div class="vers"><img alt="Comments" src="' . esc_url( admin_url( 'images/comment-grey-bubble.png' ) ) . '" /></div>';

	return $project_columns;

}

add_filter( 'manage_edit-project_columns', 'projectposttype_edit_columns' );


function projectposttype_columns_display($project_columns, $post_id) {

	switch ( $project_columns ) {

		// Code from: http://wpengineer.com/display-post-thumbnail-post-page-overview

		case "thumbnail":
			$width = (int) 50;
			$height = (int) 50;
			$thumbnail_id = get_post_meta( $post_id, 'project_img_ID', true );

			// Display the featured image in the column view if possible
			if (is_numeric($thumbnail_id)) {
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), false );
			}
			if ( isset($thumb) ) {
				echo $thumb;
			} else {
				echo __('None', 'framework');
			}
			break;

		case "portfolio":
			$width = (int) 50;
			$height = (int) 50;
			$portfolio = wp_get_post_terms( $post_id, 'portfolios' );
			$portfolio_list = get_the_term_list( $post_id, 'portfolios', '', ', ', '' );	// MAV
			$tag_extra_fields = get_option('portfolios_fields');
			$thumb_name = '';
			$thumb = '';

			// Need some proof check to ensure that no "notice" is thrown ...
			if ( ! empty( $portfolio ) ) {
				if ( isset( $tag_extra_fields[$portfolio[0]->term_id] ) ) {
					if ( $tag_extra_fields[$portfolio[0]->term_id]['portfolios_image_id'] ) {
						$thumb_ID = $tag_extra_fields[$portfolio[0]->term_id]['portfolios_image_id'];
						$thumb_slug = $portfolio[0]->slug;
						$thumb = wp_get_attachment_image( $thumb_ID, array($width, $height), false, array( 'id' => "portfolios_image_thumb-$thumb_slug" ) );
						// $thumb_name = '<span style="width:100%;float:left;">' .$portfolio[0]->name.'</span>';	// MAV
						$thumb_name = '<span style="width:100%;float:left;">' . $portfolio_list .'</span>';

					} else {
						// $thumb_name = $portfolio[0]->name;	// MAV
						$thumb_name = $portfolio_list;
					}
				} else {
					// $thumb_name = $portfolio[0]->name;	// MAV
					$thumb_name = $portfolio_list;
				}
			} else {
				$thumb_name = __('None', 'framework');
			}

			// Display the featured image in the column view if possible
			if ($thumb != '') {
				echo $thumb;
			}
			echo $thumb_name;
			break;

		// Display the project tags in the column view
		case "project_category":

			if ( $category_list = get_the_term_list( $post_id, 'project_category', '', ', ', '' ) ) {
				echo $category_list;
			} else {
				echo __('None', 'projectposttype');
			}
			break;

		// Display the project tags in the column view
		case "project_tag":

			if ( $tag_list = get_the_term_list( $post_id, 'project_tag', '', ', ', '' ) ) {
				echo $tag_list;
			} else {
				echo __('None', 'projectposttype');
			}
			break;
	}
}

add_action( 'manage_posts_custom_column',  'projectposttype_columns_display', 10, 2 );


/**
 * Add project count to "Right Now" Dashboard Widget
 */

function add_project_counts() {

    if ( ! post_type_exists( 'project' ) ) {
         return;
    }

    $num_posts = wp_count_posts( 'project' );
    $num = number_format_i18n( $num_posts->publish );
    $text = _n( 'Project Post', 'Project Posts', intval($num_posts->publish) );
    if ( current_user_can( 'edit_posts' ) ) {
        $num = "<a href='edit.php?post_type=project'>$num</a>";
        $text = "<a href='edit.php?post_type=project'>$text</a>";
    }
    echo '<td class="first b b-project">' . $num . '</td>';
    echo '<td class="t project">' . $text . '</td>';
    echo '</tr>';

    if ($num_posts->pending > 0) {
        $num = number_format_i18n( $num_posts->pending );
        $text = _n( 'Project Post Pending', 'Project Posts Pending', intval($num_posts->pending) );
        if ( current_user_can( 'edit_posts' ) ) {
            $num = "<a href='edit.php?post_status=pending&post_type=project'>$num</a>";
            $text = "<a href='edit.php?post_status=pending&post_type=project'>$text</a>";
        }
        echo '<td class="first b b-project">' . $num . '</td>';
        echo '<td class="t project">' . $text . '</td>';

        echo '</tr>';
    }

}

add_action( 'right_now_content_table_end', 'add_project_counts' );


function project_rewrites_overrides() {

	// ...
	add_rewrite_rule('^portfolio/([^/]*)/([^/]*)/?','index.php?taxonomy=portfolios&portfolios=$matches[1]&project=$matches[2]','top');

}

add_filter('generate_rewrite_rules', 'project_rewrites_overrides', 11);


function project_permalink_structure($post_link, $post, $leavename, $sample)
{
    if ( false !== strpos( $post_link, 'project' ) ) {

        $project_term = get_the_terms( $post->ID, 'portfolios' );

        if ( is_array($project_term) && ! empty( $project_term ) )
			$post_link = str_replace( '/project/', '/portfolio/' . array_pop( $project_term )->slug . '/', $post_link );	// vlad - original
			// $post_link = str_replace( '', '/' . array_pop( $project_term )->slug . '/', $post_link );	// Mav
        if ( strpos( $post_link, 'archives/' ) ) $post_link = str_replace( 'archives/', '', $post_link );

    }
    return $post_link;
}

add_filter('post_type_link', 'project_permalink_structure', 10, 4);

flush_rewrite_rules();


/*-----------------------------------------------------------------------------------*/
/* Add Portfolio Meta box */
/*-----------------------------------------------------------------------------------*/

include('metabox-project.php');


/*-----------------------------------------------------------------------------------*/
/* Sort Portfolio Categories */
/*-----------------------------------------------------------------------------------*/

Class Sorter {

	private $key;

	public function __construct($key) {
		$this->key = $key;
	}

	public function sort($a, $b) {
		return strnatcmp($a[$this->key], $b[$this->key]);
	}
}

?>
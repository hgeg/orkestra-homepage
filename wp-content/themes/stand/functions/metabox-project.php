<?php

/*-------------------------------------------------------------------------------------------*/
/* Portfolio Meta box */
/*-------------------------------------------------------------------------------------------*/

// Remove "Featured Image" metabox (to not interfere with "Project Image")!
add_action( 'admin_head' , 'framework_remove_project_featured_image' );

function framework_remove_project_featured_image() {
	global $post_type;
	remove_meta_box( 'postimagediv', 'project', 'side' );

	// Also remove the "Portofolio" side metabox as we created a new one!
	remove_meta_box( 'portfoliosdiv', 'project', 'side' );
}

// Adding the Meta Box
add_action( 'add_meta_boxes', 'framework_project_meta_box_add' );

function framework_project_meta_box_add() {
	add_meta_box( 'project-meta-box', 'Project Options', 'framework_project_meta_box_cb', 'project', 'normal', 'high' );
}

// Rendering the Meta Box
function framework_project_meta_box_cb( $post ) {

	global $post;

	$values = get_post_custom( $post->ID );

	$project_img = isset( $values['project_img'] ) ? esc_attr( $values['project_img'][0] ) : '';
	$project_img_ID = isset( $values['project_img_ID'] ) ? esc_attr( $values['project_img_ID'][0] ) : '';
	$img_copyrights = isset( $values['img_copyrights'] ) ? esc_attr( $values['img_copyrights'][0] ) : '';
	$img_copyrights_link = isset( $values['img_copyrights_link'] ) ? esc_attr( $values['img_copyrights_link'][0] ) : '';
	$client_name = isset( $values['client_name'] ) ? esc_attr( $values['client_name'][0] ) : '';
	$client_name_link = isset( $values['client_name_link'] ) ? esc_attr( $values['client_name_link'][0] ) : '';
	$project_desc = isset( $values['project_desc'] ) ? esc_attr( $values['project_desc'][0] ) : '';
	$project_link_text = isset( $values['project_link_text'] ) ? esc_attr( $values['project_link_text'][0] ) : '';
	$project_link = isset( $values['project_link'] ) ? esc_attr( $values['project_link'][0] ) : '';
	$lightbox_path = isset( $values['lightbox_path'] ) ? esc_attr( $values['lightbox_path'][0] ) : '';
	$field_1 = isset( $values['field_1'] ) ? esc_attr( $values['field_1'][0] ) : '';
	$field_2 = isset( $values['field_2'] ) ? esc_attr( $values['field_2'][0] ) : '';
	$field_3 = isset( $values['field_3'] ) ? esc_attr( $values['field_3'][0] ) : '';
	$field_4 = isset( $values['field_4'] ) ? esc_attr( $values['field_4'][0] ) : '';
	$field_5 = isset( $values['field_5'] ) ? esc_attr( $values['field_5'][0] ) : '';
	$field_6 = isset( $values['field_6'] ) ? esc_attr( $values['field_6'][0] ) : '';
	$field_7 = isset( $values['field_7'] ) ? esc_attr( $values['field_7'][0] ) : '';
	$field_8 = isset( $values['field_8'] ) ? esc_attr( $values['field_8'][0] ) : '';
	$field_9 = isset( $values['field_9'] ) ? esc_attr( $values['field_9'][0] ) : '';
	$project_permalink = isset( $values['project_permalink'] ) ? esc_attr( $values['project_permalink'][0] ) : '';
	$selected = isset( $values['label_select'] ) ? esc_attr( $values['label_select'][0] ) : 'none';

	wp_nonce_field( 'project-meta-box_nonce', 'meta_box_nonce' );
?>

<p style="margin-top:15px">
	<label for="project_desc"><strong>Description</strong></label><br/>
	<textarea style="width:98%;margin:6px 0 3px 0" name="project_desc" id="project_desc" type="text" rows="3" cols=""><?php echo $project_desc; ?></textarea>
	<label><span style="color:#808995;margin-bottom:25px;display:block">Write the project description in this field.</span></label>
</p>

<p>
	<!-- <label for="project_img"><strong>Project Image/ Video URL</strong></label><br/> --> <!-- // MAV - Review in 1.0.1 -->
	<label for="project_img"><strong>Project Image URL</strong></label><br/>
	<input style="width:98%;margin:6px 0 5px 0" type="text" name="project_img" id="project_img" value="<?php echo $project_img; ?>" />
	<input style="width:98%;margin:6px 0 5px 0" type="hidden" name="project_img_ID" id="project_img_ID" value="<?php echo $project_img_ID; ?>" />
	<!-- <label><span style="color:#808995;margin-bottom:25px;display:block">Minimun image with 940px.</span></label> -->
	<!--<label>
		<span style="color:#808995;margin-bottom:25px;display:block">For video, when the Media Uploader opens, go to "From URL", chose "Audio, Video, or Other File" and enter your link.</span>
	</label>-->
</p>

<p>
	<?php
	/*
	 * Project Image Thumb
	 */
	if ( $project_img_ID != '' ) {

		if ( is_numeric( $project_img_ID ) ) {
			$attr_project_img = array(
				'id'	=> 'project_img_thumb'
				// 'id'	=> 'image_' . $project_img_ID
				);
			echo( wp_get_attachment_image( $project_img_ID, array(150, 150), '', $attr_project_img ) );
		} else {
			echo( '<iframe id="project_img_thumb" width="300" height="200" src="' . $project_img . '" title="' . $project_img_ID . '" frameborder="0" allowfullscreen></iframe>' );
		}

	} else {
		echo( '<img id="project_img_thumb" src="" width="150px" />' ); // to make the preview works
	}
?>
</p>

<span class="button mav_remove_button" id="reset_<?php echo $project_img_ID ?>" title="<?php echo $project_img_ID ?>" style="display:none;"><?php _e('Remove Media', 'framework') ?></span>


<p>
	<label for="img_copyrights"><strong>Image Copyright</strong></label><br/>
	<input style="width:98%;margin:6px 0 5px 0" type="text" name="img_copyrights" id="img_copyrights" value="<?php echo $img_copyrights; ?>" />
	<?php /* <textarea style="width:98%;margin:6px 0 3px 0" name="img_copyrights" id="img_copyrights" type="text" rows="1" cols=""><?php echo $img_copyrights; ?></textarea> */ ?>
	<label><span style="color:#808995;margin-bottom:18px;display:block">Example: "<i>Image courtesy by John Doe</i>".</span></label>

	<label for="img_copyrights_link"><strong>Copyright Link URL</strong></label><br/>
	<input style="width:98%;margin:6px 0 15px 0" type="text" name="img_copyrights_link" id="img_copyrights_link" value="<?php echo $img_copyrights_link; ?>" />
</p>


<p style="margin-bottom:25px;">
	<label for="label_select" style="margin-right:5px"><strong>Post Label</strong></label>
	<select name="label_select" id="label_select">
		<option value="none" <?php selected( $selected, 'none' ); ?>>None</option>
		<option value="new" <?php selected( $selected, 'new' ); ?>>New</option>
		<option value="free" <?php selected( $selected, 'free' ); ?>>Free</option>
	</select>
</p>

<p>
	<label for="project_link_text"><strong>Button Link Text</strong></label><br/>
	<input style="width:98%;margin:6px 0 5px 0" type="text" name="project_link_text" id="project_link_text" value="<?php echo $project_link_text; ?>" />
	<!-- <label><span style="color:#808995;margin-top:3px;margin-bottom:25px;display:block">Enter the project link button text.</span></label> -->
</p>

<p>
	<label for="project_link"><strong>Button Link URL</strong></label><br/>
	<input style="width:98%;margin:6px 0 5px 0" type="text" name="project_link" id="project_link" value="<?php echo $project_link; ?>" />
	<label><span style="color:#808995;margin-top:3px;margin-bottom:25px;display:block">Enter the URL you wish to link your project to (eg: http://domain.com).</span></label>
</p>

<p>
	<label for="client_name"><strong>Client Name</strong></label><br/>
	<input style="width:98%;margin:6px 0 5px 0" type="text" name="client_name" id="client_name" value="<?php echo $client_name; ?>" />
	<!-- <label><span style="color:#808995;margin-top:3px;margin-bottom:25px;display:block">Your Client Name.</span></label> -->
</p>

<p>
	<label for="client_name_link"><strong>Client Link URL</strong></label><br/>
	<input style="width:98%;margin:6px 0 5px 0" type="text" name="client_name_link" id="client_name_link" value="<?php echo $client_name_link; ?>" />
	<label><span style="color:#808995;margin-top:3px;margin-bottom:25px;display:block">Enter the Client Link URL (eg: http://domain.com).</span></label>
</p>

<p>
	<label><strong>Custom Fields</strong></label><br/>

	<input style="width:49%;margin:6px 0 3px 0" type="text" name="field_1" id="field_1" value="<?php echo $field_1; ?>" />
	<input style="width:49%;margin:6px 0 3px 0" type="text" name="field_2" id="field_2" value="<?php echo $field_2; ?>" />
	<input style="width:49%;margin:6px 0 3px 0" type="text" name="field_3" id="field_3" value="<?php echo $field_3; ?>" />
	<input style="width:49%;margin:6px 0 3px 0" type="text" name="field_4" id="field_4" value="<?php echo $field_4; ?>" />
	<input style="width:49%;margin:6px 0 3px 0" type="text" name="field_5" id="field_5" value="<?php echo $field_5; ?>" />
	<input style="width:49%;margin:6px 0 3px 0" type="text" name="field_6" id="field_6" value="<?php echo $field_6; ?>" />
	<input style="width:49%;margin:6px 0 3px 0" type="text" name="field_7" id="field_7" value="<?php echo $field_7; ?>" />
	<input style="width:49%;margin:6px 0 10px 0" type="text" name="field_8" id="field_8" value="<?php echo $field_8; ?>" />
	<textarea style="width:98%;margin:0px 0 3px 0" name="field_9" id="field_9" type="text" rows="3" cols=""><?php echo $field_9; ?></textarea>
</p>

<p style="margin-bottom:25px">
	<label for="lightbox_path"><strong>URL Link for Lightbox</strong></label><br/>
	<label><span style="color:#808995;margin-top:5px;margin-bottom:3px;display:block">It can be image or video, it will be opened in the project page.</span></label>
	<input style="width:98%;margin:6px 0 15px 0" type="text" name="lightbox_path" id="lightbox_path" value="<?php echo $lightbox_path; ?>" />
	<strong>Sample formats:</strong><br/>
	<label><span style="color:#808995;">Image: http://yourdomain.com/image.jpg</span></label><br/>
	<label><span style="color:#808995;">Vimeo: http://vimeo.com/23534361</span></label><br/>
	<label><span style="color:#808995;">YouTube: http://www.youtube.com/watch?v=UX7GycmeQVo</span></label><br/>
	<label><span style="color:#808995;">More at:</span> <a href="http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/">http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/</a></label>
	<br/>
</p>

<p>
	<label for="project_permalink"><strong>Custom Permalink</strong></label><br/>
	<label><span style="color:#808995;margin-top:5px;margin-bottom:3px;display:block">Enter the URL path to link your project post to somewhere else (eg: http://domain.com).</span></label>
	<input style="width:98%;margin:6px 0 15px 0" type="text" name="project_permalink" id="project_permalink" value="<?php echo $project_permalink; ?>" />
</p>

<?php
}

// Saving the Data
add_action( 'save_post', 'cd_meta_box_save' );

function cd_meta_box_save( $post_id ) {

	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'project-meta-box_nonce' ) ) return;

	// if our current user can't edit this post, bail
	$post_type = get_post_type_object( get_post( $post_id )->post_type );
	if( !current_user_can( $post_type->cap->edit_post, $post_id ) ) return;

	// now we can actually save the data
	$allowed = array(
		'a' => array( // on allow a tags
			'href' => array() // and those anchords can only have href attribute
		)
	);

	// Probably a good idea to make sure your data is set before trying to save it
	if( isset( $_POST['project_img'] ) )
		update_post_meta( $post_id, 'project_img', wp_kses( $_POST['project_img'], $allowed ) );

	if( isset( $_POST['project_img_ID'] ) )
		update_post_meta( $post_id, 'project_img_ID', wp_kses( $_POST['project_img_ID'], $allowed ) );

	if( isset( $_POST['img_copyrights'] ) )
		update_post_meta( $post_id, 'img_copyrights', wp_kses( $_POST['img_copyrights'], $allowed ) );

	if( isset( $_POST['img_copyrights_link'] ) )
		update_post_meta( $post_id, 'img_copyrights_link', wp_kses( $_POST['img_copyrights_link'], $allowed ) );

	if( isset( $_POST['label_select'] ) )
        update_post_meta( $post_id, 'label_select', esc_attr( $_POST['label_select'] ) );

	if( isset( $_POST['project_desc'] ) )
		update_post_meta( $post_id, 'project_desc', wp_kses( $_POST['project_desc'], $allowed ) );

	if( isset( $_POST['project_link_text'] ) )
		update_post_meta( $post_id, 'project_link_text', wp_kses( $_POST['project_link_text'], $allowed ) );

	if( isset( $_POST['project_link'] ) )
		update_post_meta( $post_id, 'project_link', wp_kses( $_POST['project_link'], $allowed ) );

	if( isset( $_POST['client_name'] ) )
		update_post_meta( $post_id, 'client_name', wp_kses( $_POST['client_name'], $allowed ) );

	if( isset( $_POST['client_name_link'] ) )
		update_post_meta( $post_id, 'client_name_link', wp_kses( $_POST['client_name_link'], $allowed ) );

	if( isset( $_POST['lightbox_path'] ) )
		update_post_meta( $post_id, 'lightbox_path', wp_kses( $_POST['lightbox_path'], $allowed ) );

	if( isset( $_POST['field_1'] ) )
		update_post_meta( $post_id, 'field_1', wp_kses( $_POST['field_1'], $allowed ) );
	if( isset( $_POST['field_2'] ) )
		update_post_meta( $post_id, 'field_2', wp_kses( $_POST['field_2'], $allowed ) );
	if( isset( $_POST['field_3'] ) )
		update_post_meta( $post_id, 'field_3', wp_kses( $_POST['field_3'], $allowed ) );
	if( isset( $_POST['field_4'] ) )
		update_post_meta( $post_id, 'field_4', wp_kses( $_POST['field_4'], $allowed ) );
	if( isset( $_POST['field_5'] ) )
		update_post_meta( $post_id, 'field_5', wp_kses( $_POST['field_5'], $allowed ) );
	if( isset( $_POST['field_6'] ) )
		update_post_meta( $post_id, 'field_6', wp_kses( $_POST['field_6'], $allowed ) );
	if( isset( $_POST['field_7'] ) )
		update_post_meta( $post_id, 'field_7', wp_kses( $_POST['field_7'], $allowed ) );
	if( isset( $_POST['field_8'] ) )
		update_post_meta( $post_id, 'field_8', wp_kses( $_POST['field_8'], $allowed ) );
	if( isset( $_POST['field_9'] ) )
		update_post_meta( $post_id, 'field_9', wp_kses( $_POST['field_9'], $allowed ) );

	if( isset( $_POST['project_permalink'] ) )
		update_post_meta( $post_id, 'project_permalink', wp_kses( $_POST['project_permalink'], $allowed ) );

}

?>

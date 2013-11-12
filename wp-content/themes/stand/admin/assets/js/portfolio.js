
/*-----------------------------------------------------------------------------------*/
/* Portfolio Project Image */
/*-----------------------------------------------------------------------------------*/

jQuery(document).ready(function($) {

	// DAHEX START
	// On a "new project" if there is image url 
	// show the "remove" button
	// otherwise fadeout the "remove" button
	if($("#project_img").val()){
		$('.mav_remove_button').fadeIn();
		} else {
		$('.mav_remove_button').fadeOut();
	}
	var orig_send_to_editor = window.send_to_editor;
	// DAHEX END


	$('#project_img').live( 'click', function ( ) {

		tb_show('Upload Project Image', 'media-upload.php?type=image&amp;TB_iframe=true&amp;post_id=0', false);

		window.send_to_editor = function(html, post) {

			// If is an Image
			if( $( html ).find("img").is('img') ) {//html.split(' ')[0] == '<a' ) {//$( html ).is("a") ) {
				var imgurl = jQuery('img',html).attr('src');
				//console.log(imgurl);
				$('#project_img').val(imgurl);
				$('#project_img_thumb').replaceWith('<img id="project_img_thumb" src="" width="150px">');
				$('#project_img_thumb').attr({
					src	:	imgurl,
					class:	''
				});
				var imgClass = jQuery('img',html).attr('class').split(' ');

				var index, value, result;
				for (index = 0; index < imgClass.length; ++index) {
					value = imgClass[index];
					if (value.substring(0, 9) === "wp-image-") {
						$('#project_img_ID').val( value.replace('wp-image-', '') );
						break;
					}
				}

				// If is an embedded video
				} else {

				/* -->>> START COMMENTING TO REMOVE THE V I D E O FEATURE <<<-- */
				var imgurl = $( html ).attr('href');
				var imgTitle = $( html ).html();
				$('#project_img').val(imgurl);
				$('#project_img_ID').val(imgTitle);
				$('#project_img_thumb').replaceWith('<iframe id="project_img_thumb" width="300" height="210" src="' + imgurl + '" title="' + imgTitle + '" frameborder="0" allowfullscreen></iframe>');
				/* -->>> STOP COMMENTING TO REMOVE THE V I D E O FEATURE <<<-- */
				// Don`t forget of metabox-project.php to change to "Project Video/Image URL" <label> \\
			}

			tb_remove();

		window.send_to_editor = orig_send_to_editor;

		}

		return false;
	});

});


/** --- Project Remove Image + Button --- **/

jQuery( document ).ready( function ($) {
  
 	$('.mav_remove_button').live('click', function(event) { 
		var clickedObject = $(this);
		var theID = $(this).attr('title');
		var image_to_remove = $('#project_img_thumb');
		var button_to_hide = $('#reset_' + theID);
	    
		image_to_remove.fadeOut(500,function(){ $(this).remove(); });
		button_to_hide.fadeOut();
		//console.log(	clickedObject.parent().prev('input').val()); //DEBUG
		$("input[id=project_img]").val('');
		$("input[id=project_img_ID]").val('');
	});

});



/*-----------------------------------------------------------------------------------*/
/* Portfolio (portfolios taxonomy) image (add/edit on "Portfolio" tax page ...) */
/*-----------------------------------------------------------------------------------*/

jQuery(document).ready(function($) {

	// DAHEX START
	// On a "new project" if there is image url 
	// show the "remove" button
	// otherwise fadeout the "remove" button
	if($("#_portfolios_image_uri").val()){
		$('.mav_remove_button_portfolio').fadeIn();
		} else {
		$('.mav_remove_button_portfolio').fadeOut();
	}
	var orig_send_to_editor = window.send_to_editor;
	// DAHEX END


	$('#_portfolios_image_uri').live( 'click', function ( ) {
		
		tb_show('Upload Portfolio Image', 'media-upload.php?type=image&amp;TB_iframe=true&amp;post_id=0', false);

		window.send_to_editor = function(html, post) {
			var imgurl = jQuery('img',html).attr('src');
			$('#_portfolios_image_uri').val(imgurl);
			$('#portfolios_image_thumb').attr({
				src	:	imgurl,
				class:	''
			}).css('display', 'block');
			var imgClass = jQuery('img',html).attr('class').split(' ');

			var index, value, result;
			for (index = 0; index < imgClass.length; ++index) {
				value = imgClass[index];
				if (value.substring(0, 9) === "wp-image-") {
					$('#_portfolios_image_id').val( value.replace('wp-image-', '') );
					break;
				}
			}

			tb_remove();

		window.send_to_editor = orig_send_to_editor;

		}

		return false;
	});

});


/** --- Portfolio Remove Image + Button --- **/

jQuery(document).ready(function($) {
  
 	$('.mav_remove_button_portfolio').live('click', function(event) { 
		var clickedObject = $(this);
		var theID = $(this).attr('title');
		var image_to_remove = $('#portfolios_image_thumb');
		var button_to_hide = $('#reset_' + theID);
	    
		image_to_remove.fadeOut(500,function(){ $(this).remove(); });
		button_to_hide.fadeOut();
		//console.log(	clickedObject.parent().prev('input').val()); //DEBUG
		$("input[id=_portfolios_image_uri]").val('');
		$("input[id=_portfolios_image_id]").val('');
	});

});


/** --- Portfolios' Edit Post page Image --- **/

jQuery(document).ready(function($) {
	$( '#post_portfolio' ).live( 'change', function () {
		var slug = $( this ).val()
		$( '.portfolios_post_image_thumb' ).css( 'display', 'none' );
		$( '#portfolios_post_image_thumb-' + slug ).css( 'display', 'block' );
	});
});


<?php

/*-------------------------------------------------------------------------------------------*/
/* Post Meta box */
/*-------------------------------------------------------------------------------------------*/

$prefix = 'of_';

$meta_boxes = array();

// Image
$meta_boxes[] = array(
    'id' => 'framework-meta-box-image',
    'title' => 'Format Image Options',
    'pages' => array('post', 'page'), // Multiple post type
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => '<strong>Image</strong>',
            'desc' => '<span style="color:#808995;margin-top:3px;margin-left:2px;float:left;line-height:18px;">Enter the image path URL.</span>',
            'id' => $prefix . 'image',
            'type' => 'text',
            'std' => ''
        )
    )
);

// Link
$meta_boxes[] = array(
    'id' => 'framework-meta-box-link',
    'title' => 'Format Link Options',
    'pages' => array('post', 'page'), // Multiple post type
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => '<strong>Link</strong>',
            'desc' => '<span style="color:#808995;margin-top:3px;margin-left:2px;float:left;line-height:18px;">Enter the URL you wish to link to.</span>',
            'id' => $prefix . 'link',
            'type' => 'text',
            'std' => ''
        )
    )
);

// Quote
$meta_boxes[] = array(
    'id' => 'framework-meta-box-quote',
    'title' => 'Format Quote Options',
    'pages' => array('post', 'page'), // Multiple post type
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => '<strong>Quote</strong>',
            'desc' => '<span style="color:#808995;margin-top:0;margin-left:2px;float:left;line-height:18px;">Write your quote in this field.</span>',
            'id' => $prefix . 'quote',
            'type' => 'textarea',
            'std' => ''
        )
    )
);

// Video
$meta_boxes[] = array(
    'id' => 'framework-meta-box-video',
    'title' => 'Format Video Options',
    'pages' => array('post', 'page'), // Multiple post type
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        // array(
        //     'name' => '<strong>Video Height</strong>',
        //     'desc' => '<span style="color:#808995;margin-top:3px;margin-left:2px;float:left;line-height:18px;">Please indicate the height of your video (default 350).</span>',
        //     'id' => $prefix . 'video_height',
        //     'type' => 'text',
        //     'std' => '350'
        // ),
        array(
            'name' => '<strong>Poster Image</strong>',
            'desc' => '<span style="color:#808995;margin-top:3px;margin-left:2px;float:left;line-height:18px;">The preview image of your video (620px x 400px).</span>',
            'id' => $prefix . 'video_poster',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => '<strong>MP4</strong>',
            'desc' => '<span style="color:#808995;margin-top:3px;margin-left:2px;float:left;line-height:18px;">The URL of the .mp4 video file (iOS).</span>',
            'id' => $prefix . 'video_mp4',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => '<strong>WebM</strong>',
            'desc' => '<span style="color:#808995;margin-top:3px;margin-left:2px;float:left;line-height:18px;">The URL of the .webm video file (Firefox 4 and Opera).</span>',
            'id' => $prefix . 'video_webm',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => '<strong>OGG</strong>',
            'desc' => '<span style="color:#808995;margin-top:3px;margin-left:2px;float:left;line-height:18px;">The URL of the .ogv video file (Firefox 3).</span>',
            'id' => $prefix . 'video_ogg',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => '<strong>Subtitles (srt)</strong>',
            'desc' => '<span style="color:#808995;margin-top:3px;margin-left:2px;float:left;line-height:18px;">The URL of the .srt subtitle file.</span>',
            'id' => $prefix . 'video_sub',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => '<strong>Subtitles Language</strong>',
            'desc' => '<span style="color:#808995;margin-top:3px;margin-left:2px;float:left;line-height:18px;">The language of the subtitle file.</span>',
            'id' => $prefix . 'video_sub_src',
            'type' => 'text',
            'std' => 'en'
        ),
        array(
            'name' => '<strong>Embedded Code</strong>',
            'desc' => '<span style="color:#808995;margin-top:0;margin-left:2px;float:left;line-height:18px;">If you don\'t use a self hosted video you may use embedded code (eg: YouTube or Vimeo).</span>',
            'id' => $prefix . 'video_embedded',
            'type' => 'textarea',
            'std' => ''
        )
    )
);


// Audio
$meta_boxes[] = array(
    'id' => 'framework-meta-box-audio',
    'title' => 'Format Audio Options',
    'pages' => array('post', 'page'), // Multiple post type
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => '<strong>Album Cover</strong>',
            'desc' => '<span style="color:#808995;margin-top:3px;margin-left:2px;float:left;line-height:18px;">The URL of the album cover image.</span>',
            'id' => $prefix . 'album_cover',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => '<strong>.mp3 File</strong>',
            'desc' => '<span style="color:#808995;margin-top:3px;margin-left:2px;float:left;line-height:18px;">The URL of the .mp3 audio file.</span>',
            'id' => $prefix . 'audio_mp3',
            'type' => 'text',
            'std' => ''
        )
    )
);

/*// Label
$meta_boxes[] = array(
    'id' => 'framework-meta-box-label',
    'title' => 'Post Label',
    'pages' => array('post'), // Multiple post type
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => '<strong>Label</strong>',
            'id' => $prefix . 'label',
            'type' => 'select',
            'options' => array(
                'none',
                'new',
                'free'
            )
        ),
    )
);*/

// Background Image
$meta_boxes[] = array(
    'id' => 'framework-meta-box-bg-image',
    'title' => 'Custom Background Image',
    'pages' => array('post', 'page'), // Multiple post type
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => '<strong>Background Image URL</strong>',
            'desc' => '<span style="color:#808995;margin-top:3px;margin-left:2px;float:left;line-height:18px;">Add your custom background image.</span>',
            'id' => $prefix . 'bg_image',
            'type' => 'text',
            'std' => ''
        )
    )
);


// Add meta box
function framework_add_box() {
    global $meta_box;
    foreach ($meta_box['pages'] as $page) {
        add_meta_box($meta_box['id'], $meta_box['title'], 'framework_show_box', $page, $meta_box['context'], $meta_box['priority']);
    }
}

add_action('admin_menu', 'framework_add_box');


foreach ($meta_boxes as $meta_box) {
    $framework_box = new framework_meta_box($meta_box);
}


class framework_meta_box {

    protected $_meta_box;
 
    // Create meta box based on given data
    function __construct($meta_box) {
        $this->_meta_box = $meta_box;
        add_action('admin_menu', array(&$this, 'add'));
        add_action('save_post', array(&$this, 'save'));
        // add_action('save_page', array(&$this, 'save')); // Mav
    }
 
    // Add meta box for multiple post types
    function add() {
        foreach ($this->_meta_box['pages'] as $page) {
            add_meta_box($this->_meta_box['id'], $this->_meta_box['title'], array(&$this, 'show'), $page, $this->_meta_box['context'], $this->_meta_box['priority']);
        }
    }
 
    // Callback function to show fields in meta box
    function show() {
        global $post;
 
        // Use nonce for verification
        echo '<input type="hidden" name="framework_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
        echo '<table class="form-table">';
 
        foreach ($this->_meta_box['fields'] as $field) {
            // get current post meta data
            $meta = get_post_meta($post->ID, $field['id'], true);
 
            echo '<tr>',
                    '<th style="width:23%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                    '<td>';
            switch ($field['type']) {
                case 'text':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />',
                    // '<img style="margin-top:10px;" src="', $meta ? $meta : $field['std'], '" width="150px">',
                        '<br/>', $field['desc'];

                        // MAV STARTS
                        /*if ( $field['id'] == 'of_image' ) { 
                            echo '<img id="image_'. $field['id'] . '" style="margin-top:10px;" src="', $meta ? $meta : $field['std'], '" width="150px">';
                            } elseif ($field['id'] == 'of_album_cover') {
                                echo '<img id="image_'. $field['id'] . '" style="margin-top:10px;" src="', $meta ? $meta : $field['std'], '" width="150px">';
                        }
                        echo '<span class="button mlu_remove_button" id="reset_'. $field['id'] . '" title="'. $field['id'] . '">Remove Media</span>';*/
                        // MAV ENDS

                    break;
                case 'textarea':
                    echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
                        '<br />', $field['desc'];
                    break;
                case 'select':
                    echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                    foreach ($field['options'] as $option) {
                        echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                    }
                    echo '</select>';
                    break;
                case 'radio':
                    foreach ($field['options'] as $option) {
                        echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                    }
                    break;
                case 'checkbox':
                    echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                    break;
            }
            echo     '<td>',
                '</tr>';
        }
 
        echo '</table>';
    }

    // Save data from meta box
    function save($post_id) {
        // verify nonce
        if (@!wp_verify_nonce($_POST['framework_meta_box_nonce'], basename(__FILE__))) { /* added @ to prevent notice */
            return $post_id;
        }
 
        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
 
        // check permissions
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
 
        foreach ($this->_meta_box['fields'] as $field) {
            $old = get_post_meta($post_id, $field['id'], true);
            $new = $_POST[$field['id']];
 
            if ($new && $new != $old) {
                update_post_meta($post_id, $field['id'], $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        }
    }
}


/*-------------------------------------------------------------------------------------------*/
/* Switch Meta box */
/*-------------------------------------------------------------------------------------------*/

function meta_box_switch() {
    if ( is_admin() ) {
        $script = <<< EOF
<script type='text/javascript'>

    jQuery(document).ready(function($) {

	    $('#framework-meta-box-link').hide();
	    $('#framework-meta-box-quote').hide();
	    $('#framework-meta-box-video').hide();
        $('#framework-meta-box-audio').hide();

	    /* Standard, Aside, Gallery */
        $('#post-format-0, #post-format-aside, #post-format-gallery, #post-format-image').click(function() {
            $('#framework-meta-box-image').hide();
            $('#framework-meta-box-link').hide();
            $('#framework-meta-box-quote').hide();
            $('#framework-meta-box-video').hide();
            $('#framework-meta-box-audio').hide();
        });

        /* Image */
        $('#post-format-image').is(':checked') ? $("#framework-meta-box-image").show() : $("#framework-meta-box-image").hide();
        $('#post-format-image').click(function() {
            $("#framework-meta-box-image").toggle(this.checked);
            $('#framework-meta-box-link').hide();
            $('#framework-meta-box-video').hide();
            $('#framework-meta-box-quote').hide();
            $('#framework-meta-box-audio').hide();
        });

        /* Link */
        $('#post-format-link').is(':checked') ? $("#framework-meta-box-link").show() : $("#framework-meta-box-link").hide();
        $('#post-format-link').click(function() {
            $('#framework-meta-box-image').hide();
            $("#framework-meta-box-link").toggle(this.checked);
            $('#framework-meta-box-video').hide();
            $('#framework-meta-box-quote').hide();
            $('#framework-meta-box-audio').hide();
        });

        /* Quote */
        $('#post-format-quote').is(':checked') ? $("#framework-meta-box-quote").show() : $("#framework-meta-box-quote").hide();
        $('#post-format-quote').click(function() {
            $('#framework-meta-box-image').hide();
            $('#framework-meta-box-link').hide();
            $("#framework-meta-box-quote").toggle(this.checked);
            $('#framework-meta-box-video').hide();
            $('#framework-meta-box-audio').hide();
        });

        /* Video */
        $('#post-format-video').is(':checked') ? $("#framework-meta-box-video").show() : $("#framework-meta-box-video").hide();
        $('#post-format-video').click(function() {
            $('#framework-meta-box-image').hide();
            $('#framework-meta-box-link').hide();
            $('#framework-meta-box-quote').hide();
            $("#framework-meta-box-video").toggle(this.checked);
            $('#framework-meta-box-audio').hide();
        });

        /* Audio */
        $('#post-format-audio').is(':checked') ? $("#framework-meta-box-audio").show() : $("#framework-meta-box-audio").hide();
        $('#post-format-audio').click(function() {
            $('#framework-meta-box-image').hide();
            $('#framework-meta-box-link').hide();
            $('#framework-meta-box-quote').hide();
            $('#framework-meta-box-video').hide();
            $("#framework-meta-box-audio").toggle(this.checked);
        });

    });
</script>
EOF;
        echo $script;
    }
}
add_action('admin_footer', 'meta_box_switch');


/*-------------------------------------------------------------------------------------------*/
/* Remove wp default meta box (posts and pages) */
/* http://codex.wordpress.org/Function_Reference/remove_meta_box */
/*-------------------------------------------------------------------------------------------*/

function remove_post_custom_fields() {
    remove_meta_box( 'postexcerpt', 'post', 'normal' );
    remove_meta_box( 'postcustom', 'post', 'normal' );
}
add_action( 'admin_menu' , 'remove_post_custom_fields' );


function remove_page_excerpt_field() {
    remove_meta_box( 'postexcerpt', 'page', 'normal' );
    remove_meta_box( 'postcustom', 'page', 'normal' );
}
add_action( 'admin_menu' , 'remove_page_excerpt_field' );


?>

<?php

require_once( dirname(__FILE__) . '/../../../../wp-load.php' );

// Only if the plugins works with Mav's themes only.
// $woo_shortcode_css = content_url() . '/themes/' . basename(get_template_directory()) . '/functions/css/shortcodes.css';
?>
<html>
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js" ></script>
<?php /* <link rel="stylesheet" href="<?php echo $woo_shortcode_css; ?>"> */ ?>
<link rel="stylesheet" href="../css/shortcodes.css">
</head>
<body>
<?php

$shortcode = isset($_REQUEST['shortcode']) ? $_REQUEST['shortcode'] : '';

// WordPress automatically adds slashes to quotes
// http://stackoverflow.com/questions/3812128/although-magic-quotes-are-turned-off-still-escaped-strings
$shortcode = stripslashes($shortcode);

echo do_shortcode($shortcode);

?>
<script type="text/javascript">
    jQuery('#mav-preview h3:first', window.parent.document).removeClass('mav-loading');
</script>
</body>
</html>

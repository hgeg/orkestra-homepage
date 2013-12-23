<?php

require_once( dirname(__FILE__) . '/../../../../wp-load.php' );

?>

<div id="mav-dialog" title="Mav Shortcodes">

	<div id="mav-options">

		<h3>Insert the Shortcode</h3>

		<form id="mav-option-form" action="">

			<table id="mav-options-table"></table>

		</form>

	</div>

	<div id="mav-preview">
    	<h3>Preview</h3>
    	<iframe id="mav-preview-iframe" frameborder="0" style="width:100%;height:250px"></iframe>
	</div>

	<script type="text/javascript" src="../wp-content/plugins/mav-shortcodes/tinymce/js/dialog.js"></script>

</div> <!-- /end #mav-dialog -->

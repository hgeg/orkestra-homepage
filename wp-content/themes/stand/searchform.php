<?php
/**
 * The template for displaying search forms
 *
 */
?>
<form class="searchform" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="field" name="s" id="s" onblur="if (this.value == '') {this.value = 'To search, type and hit enter';}" onfocus="if (this.value == 'To search, type and hit enter') {this.value = '';}" value="To search, type and hit enter"  />
</form>

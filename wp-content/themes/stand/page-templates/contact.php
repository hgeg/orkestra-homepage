<?php

/* Template Name: Contact */

get_header();

?>

<?php

/* http://www.joepettersson.com/accessible-php-and-jquery-contact-form/ */

// If the form is submitted
if(isset($_POST['submit'])) {

	// Check to make sure that the name field is not empty
	if(trim($_POST['contact_name']) == '') {
		$hasError = true;
	} else {
		$name = trim($_POST['contact_name']);
	}

	// Check to make sure sure that a valid email address is submitted
	if(trim($_POST['contact_email']) == '')  {
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['contact_email']))) {
		$hasError = true;
	} else {
		$email = trim($_POST['contact_email']);
	}

	// Check to make sure comments were entered
	if(trim($_POST['contact_message']) == '') {
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['contact_message']));
		} else {
			$comments = trim($_POST['contact_message']);
		}
	}

	// If there is no error, send the email
	if(!isset($hasError)) {
		
		$emailTo = $mav_data['contact_email'];
		
		if ( !isset($emailTo) || ($emailTo == '') ) {
			$emailTo = get_option('admin_email');
		}
		
		$website_name = get_bloginfo( 'name' );
		
		$headers = 'From: '.$name.' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email;
		$subject = 'Message from ' .$website_name;
		$body = "$comments \n\n\n $name \n $email \n";

		mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}
}
?>

<section id="content" class="contact" role="main">

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

	<section id="contact-form">
		<?php if(isset($hasError)) { // If errors are found ?>
		<div class="error">
			<p><?php _e( 'Something went wrong! Please check if you\'ve filled all the fields with valid informations and try again.', 'framework' ); ?></p>
		</div>
		<?php } ?>

		<?php if(isset($emailSent) && $emailSent == true) { // If email is sent ?>
		<div class="success">
			<h3><?php _e( 'Thank you for contacting us!', 'framework' ); ?></h3>
			<p><?php _e( 'Your email was successfully sent and we\'ll get back to you shortly.<br/>Sometimes if we are quite busy it may take us longer, but we promise to get back to you.', 'framework' ); ?></p>
		</div>
		<?php } ?>

		<form method="post" action="<?php the_permalink(); ?>" id="contact_form">

			<div class="contact-name">
				<label for="contact_name"><?php _e( 'Name', 'framework' ); ?></label>
				<input type="text" name="contact_name" id="contact_name" value="" class="required" role="input" aria-required="true" />
			</div>

			<div class="contact-email">
				<label for="contact_email"><?php _e( 'Email', 'framework' ); ?></label>
				<input type="text" name="contact_email" id="contact_email" value="" class="required" role="input" aria-required="true" />
			</div>

			<div class="contact-message">
				<label for="contact_message"><?php _e( 'Message', 'framework' ); ?></label>
				<textarea rows="8" name="contact_message" id="contact_message" class="required" role="textbox" aria-required="true"></textarea>
			</div>
			
			<input type="submit" value="Send Message" name="submit" id="submitButton" title="" />

		</form>
	</section> <!-- /end #contact-form -->

	<span class="edit-link"><?php edit_post_link('edit', '', ''); ?></span>

</section> <!-- /end #content -->

<?php get_sidebar('page'); ?>
<?php get_footer(); ?>

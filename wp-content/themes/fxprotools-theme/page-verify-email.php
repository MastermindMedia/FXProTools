<?php
$verification_code = isset( $_GET['code'] ) ? $_GET['code'] : '';
?>
<?php get_header(); ?>
	<div class="container">
		<?php if( isset($_GET['action']) && $_GET['action'] == 'resend' ): resend_email_verification();?>
			<p>Verification email has been sent to your email. </p>
		<?php elseif( verify_email_address($verification_code) ): ?>
			<p>Your email has been been verified.</p>
			<a href="<?php bloginfo('url');?>/dashboard/">Back to dashboard.</a>
		<?php else: ?>
			<p>Verification has been sent to your email. Click <a href="<?php bloginfo('url');?>/verify-email/?action=resend">here</a> to resend.</p>
		<?php endif;?>
	</div>
<?php get_footer(); ?>
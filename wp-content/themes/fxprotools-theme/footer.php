
		<?php $exclude_pages = array('login', 'forgot-password', 'f3', 'f4'); ?>
		<?php if(!is_page($exclude_pages)): ?>
		<div class="fx-footer">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-4 col-md-4">
						<?php
							// Metabox Page Template Option
							echo get_mb_multi_pto( 'footer_left_menu' );

						?>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4">
						<?php
							// Metabox Page Template Option
							echo get_mb_multi_pto( 'footer_middle_menu' );
						?>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4">
						<?php
							// Metabox Page Template Option
							echo get_mb_multi_pto( 'footer_right_menu' );
						?>
					</div>
					<div class="clearfix"></div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<hr/>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="text-center">
							<span>support@copyprofitsuccess.com | +1-800-781-0000 (M-F 10am-10pm EST)</span>
							<img src="<?php bloginfo('template_url'); ?>/assets/img/credit-cards.png" class="img-responsive inline-block credit-cards">
							<span>&copy; 2017 <?php echo get_bloginfo('name'); ?>. All Rights Reserved</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="fx-disclosure">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<p>FULL RISK DISCLOSURE: Trading contains substantial risk and is not for every investor. An investor could potentially lose all or more than the initial investment. Risk capital is money that can be lost without jeopardizing ones financial security or life style. Only risk capital should be used for trading and only those with sufficient risk capital should consider trading. Past performance is not necessarily indicative of future results.</p>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<?php get_sidebar('alert');?>

	</div><!-- /fx-wrapper-content -->
</div><!-- /fx-wrapper -->

<?php
/**
 * Intercom setting
 * 
 */
if (is_user_logged_in()): ?>
    <?php $user = wp_get_current_user(); ?>
    <script>
    window.intercomSettings = {
        app_id: "tyotu8pw",
        email: "<?= $user->user_email ; ?>",
        user_hash: "<?= get_user_intercom_HMAC($user); ?>"
    };
    </script>
<?php endif; ?>
<?php wp_footer(); ?>

</body>
</html>

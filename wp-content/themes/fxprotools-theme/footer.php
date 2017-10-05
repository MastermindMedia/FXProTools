	</div><!-- /fx-wrapper -->
	
	<?php if(!is_page(array('login', 'forgot-password')) ): ?>
	<div class="fx-footer">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<ul class="footer-nav">
						<?php dynamic_sidebar( 'footer_menu_1' ); ?>
						<!-- 
						<li><a href="#">Become A Customer</a></li>
						<li><a href="#">Become A Distributor</a></li>
						<li><a href="#">Member Login</a></li>
						-->
					</ul>
				</div>
				<div class="col-md-4">
					<ul class="footer-nav">
						<?php dynamic_sidebar( 'footer_menu_2' ); ?>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">Terms of Service</a></li>
						<li><a href="#">Policies &amp; Procedures</a></li>
					</ul>
				</div>
				<div class="col-md-4">
					<ul class="footer-nav">
						<?php dynamic_sidebar( 'footer_menu_3' ); ?>
						<li><a href="#">IBO Agreement</a></li>
						<li><a href="#">Earnings Disclaimer</a></li>
						<li><a href="?php echo wp_logout_url('/login/'); ?>">Logout</a></li>
					</ul>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-12">
					<hr/>
				</div>
				<div class="col-md-12">
					<div class="text-center">
						<span>support@fxprotools.com | +1-800-781-0187 (M-F 10am-10pm EST)</span>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/credit-cards.png" class="img-responsive inline-block credit-cards">
						<span>&copy; 2017 FX Pro Tools. All Rights Reserved</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="fx-disclosure">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>FULL RISK DISCLOSURE: Trading contains substantial risk and is not for every investor. An investor could potentially lose all or more than the initial investment. Risk capital is money that can be lost without jeopardizing ones financial security or life style. Only risk capital should be used for trading and only those with sufficient risk capital should consider trading. Past performance is not necessarily indicative of future results.</p>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

<?php get_sidebar('alert');?>
<?php wp_footer(); ?>

</body>
</html>
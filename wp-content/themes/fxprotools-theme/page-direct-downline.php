<?php get_header(); ?>

	<?php get_template_part('inc/templates/nav-team'); ?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="fx-header-title">
					<h1>Direct Downline</h1>
					<p>Check Below For Your Available Contacts</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo do_shortcode('[afl_eps_unilevel_reffered_downlines]'); ?>
			</div>
		</div>
	</div>
	
<?php get_footer(); ?>
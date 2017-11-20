<?php get_header(); ?>

	<?php get_template_part('inc/templates/nav-team'); ?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="fx-header-title">
					<h1>Your Matrix Tree</h1>
					<p>Check Below For Your Full Matrix Tree</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo do_shortcode('[afl_eps_matrix_genealogy_tree]'); ?>
			</div>
		</div>
	</div>



	<div class="row">
		<div class="col-md-12">
			<div class="fx-header-title">
				<h1>Your Holding Tank</h1>
				<p>Check Below For Distributors Waiting for Placement</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php echo do_shortcode('[afl_eps_unilevel_holding_tank]'); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>

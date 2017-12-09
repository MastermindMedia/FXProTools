<?php get_header(); ?>

	<?php get_template_part('inc/templates/nav-team'); ?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="fx-header-title">
					<h1>Your Unilevel Tree</h1>
					<p>Check Below For Your Full Unilevel Tree</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo do_shortcode('[afl_unilevel_holding_tank_genealogy_toggle_placement]'); ?>
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


	<div class="row">
		<div class="col-md-12">
			<div class="fx-header-title">
				<h1>Direct Downline Members</h1>
				<p>Check Below For Direct Downline Members</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php echo do_shortcode('[afl_eps_unilevel_downlines]'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="fx-header-title">
				<h1>Direct Upline</h1>
				<p>Check Below Direct Upline</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php echo do_shortcode('[afl_eps_unilevel_direct_uplines_shortcode]'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="fx-header-title">
				<h1>Referred Members</h1>
				<p>Check Below For Referred Members</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php echo do_shortcode('[afl_eps_unilevel_reffered_downlines]'); ?>
		</div>
	</div>


<?php get_footer(); ?>

<?php get_header(); ?>

	<?php get_template_part('inc/templates/nav-team'); ?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="fx-header-title">
					<h1>Genealogy Tree</h1>
					<p>Check Below Direct Upline</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo do_shortcode('[afl_eps_matrix_genealogy_tree]'); ?>
			</div>
		</div>
	</div>
	
<?php get_footer(); ?>
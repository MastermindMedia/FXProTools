<?php 
$trial_end_date = get_trial_end_date();
if( $trial_end_date ){
	$trial_remaining_days = floor( (strtotime( $trial_end_date ) - time()) / (60 * 60 * 24));
}
$market_scanner =  wcs_user_has_subscription( '', 47, 'active');
$distributor_package =  wcs_user_has_subscription( '', 48, 'active');
$auto_trader = wcs_user_has_subscription( '', 49, 'active');
$coaching = wc_customer_bought_product( '', get_current_user_id(), 50);
?>
<?php get_header(); ?>

	<?php get_template_part('inc/templates/nav-dashboard'); ?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="fx-header-title">
					<h1>Awesome! You Can Now Access Your Products</h1>
					<p>Step#2 - Accessing Your FX Pro Tools Products</p>
				</div>
			</div>
			<div class="col-md-8">
				<div class="fx-video-container"></div>
			</div>
			<div class="col-md-4">
				<div class="fx-board">
					<div class="fx-board-title w-text">
						<span>Your Products</span>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua.</p>
					</div>
					<div class="fx-board-content">
						<ol>
							<?php if( isset($trial_remaining_days) ): ?><li>Free Trial (<?php echo $trial_remaining_days; ?> Days / Active)</li><?php endif;?>
							<li>Distributor Package (<?php echo $distributor_package  || current_user_can('administrator') ? 'Active' : 'Upgrade'; ?>)</li>
							<li>FX Auto Trader (<?php echo $auto_trader || current_user_can('administrator')  ? 'Active' : 'Upgrade'; ?>)</li>
							<li>Coaching (<?php echo $coaching || current_user_can('administrator')  ? 'Active' : 'Upgrade'; ?>)</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="fx-mid-header">
					<h2>Get The Most Out Of FX Pro Tools</h2>
					<p>Supercharge your learning experience using FX Pro Tools</p>
				</div>
			</div>
			<div class="col-md-12">
				<ul class="fx-list-training">
					<li>
						<span>Basic Training</span>
						<a href="<?php bloginfo('url');?>/basic-training/" class="action">Access Now</a>
					</li>
					<li>
						<span>Expert Training</span>
						<a href="<?php bloginfo('url');?>/advanced-training/" class="action">Access Now</a>
					</li>
					<li>
						<span>Market Scanner</span>
						<a href="<?php bloginfo('url');?>/scanner/" class="action"><?php echo $market_scanner || current_user_can('administrator') ? 'Access Now' : 'Upgrade Now <i class="fa fa-shopping-cart"></i>';?></a>
					</li>
					<li>
						<span>FX Auto Trader</span>
						<a href="<?php bloginfo('url');?>/auto-trader/" class="action"><?php echo $auto_trader || current_user_can('administrator')  ? 'Access Now' : 'Upgrade Now <i class="fa fa-shopping-cart"></i>';?></a>
					</li>
					<li>
						<span>1 on 1 Coaching</span>
						<a href="<?php bloginfo('url');?>/coaching/" class="action"><?php echo $coaching || current_user_can('administrator')  ? 'Access Now' : 'Upgrade Now <i class="fa fa-shopping-cart"></i>';?></a>
					</li>
				</ul>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
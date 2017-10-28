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
					<p><span class="label-red">Step 2:</span> - Supercharge your learning experience using our products</p>
				</div>
			</div>
			<div class="col-md-8">
				<?php 
					// Metabox Page Template Option - Video Embed 
					echo get_mb_pto1('video_embed');
				?>
			</div>
			<div class="col-md-4">
				<div class="fx-board access-products">
					<div class="fx-board-header">
						Your Membership Package
					</div>
					<div class="fx-board-content">
						<p class="text-center">You are currently subscribed to the <strong>Customer Package</strong> at <strong>$140/Month</strong></p>
						<ul class="list-status">
							<li><label>Status</label> <span>Active</span></li>
							<li><label>Start Date</label> <span>2 mins ago</span></li>
							<li><label>Next Payment</label> <span>November 10, 2017</span></li>
							<li><label>End Date</label> <span>December 10, 2018</span></li>
						</ul>
					</div>
					<p class="text-center small">Auto Renew is Enabled. To change this, go to Account Settings</p>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="fx-mid-header">
					<h2>Select Product From The List Below:</h2>
				</div>
			</div>
			<div class="col-md-12">
				<ul class="fx-list-training">
					<li>
						<span>Basic Training</span>
						<a href="<?php bloginfo('url');?>/basic-training/" class="action btn btn-danger fx-btn">Explore Product</a>
					</li>
					<li>
						<span>Expert Training</span>
						<a href="<?php bloginfo('url');?>/advanced-training/" class="action btn btn-danger fx-btn">Explore Product</a>
					</li>
					<li>
						<span>Market Scanner</span>
						<a href="<?php bloginfo('url');?>/scanner/" class="action btn btn-danger fx-btn"><?php echo $market_scanner || current_user_can('administrator') ? 'Explore Product' : 'Upgrade Now <i class="fa fa-shopping-cart"></i>';?></a>
					</li>
					<li>
						<span>FX Auto Trader</span>
						<a href="<?php bloginfo('url');?>/auto-trader/" class="action btn btn-danger fx-btn"><?php echo $auto_trader || current_user_can('administrator')  ? 'Explore Product' : 'Upgrade Now <i class="fa fa-shopping-cart"></i>';?></a>
					</li>
					<li>
						<span>1 on 1 Coaching</span>
						<a href="<?php bloginfo('url');?>/coaching/" class="action btn btn-danger fx-btn"><?php echo $coaching || current_user_can('administrator')  ? 'Explore Product' : 'Upgrade Now <i class="fa fa-shopping-cart"></i>';?></a>
					</li>
				</ul>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
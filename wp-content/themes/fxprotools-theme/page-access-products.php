<?php 
$subscription_details = get_user_subscription_details();

$subscription = [];
$trial_remaining_days = 0;
if ( ! empty ( $subscription_details ) ) {
	$subscription = $subscription_details[0];
	foreach ( $subscription_details as $detail ) {
		if ( strtolower( $detail['package_type'] ) == 'business' ) {
			$subscription = $detail;
			break;
		}
	}
	if ( isset( $subscription_details['trial_expiry_date'] ) ) {
		$trial_remaining_days = floor( ( strtotime( $subscription_details['trial_expiry_date'] ) - time() ) / ( 60 * 60 * 24 ) );
	}
}

$market_scanner =  wcs_user_has_subscription( '', 47, 'active') || is_user_fx_distributor();
$auto_trader = wcs_user_has_subscription( '', 49, 'active');
$coaching = wcs_user_has_subscription( '', 50, 'active');
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
					echo get_mb_pto1( 'video_embed', 'pto1' );
				?>
			</div>
			<div class="col-md-4">
				<div class="fx-board access-products">
					<div class="fx-board-header">
						Your Membership Package
					</div>
					<div class="fx-board-content">
                        <?php if (!empty($subscription)) : ?>
						<p class="text-center">You are currently subscribed to the <strong><?php echo $subscription['package_type'];?> Package</strong> at <strong>$<?php echo $subscription['monthly_fee'];?>/Month</strong></p>
						<ul class="list-status">
							<li><label>Status</label> <span><?php echo ucfirst($subscription['status']);?></span></li>
							<li><label>Start Date</label> <span><?php echo date('F d, Y', strtotime($subscription['start_date']) );?></span></li>
							<li><label>Next Payment</label> <span><?php echo date('F d, Y', strtotime($subscription['next_payment_date']) );?></span></li>
							<?php if( $subscription['trial_expiry_date'] ):?><li><label>Trial End</label> <span><?php echo date('F d, Y', strtotime($subscription['trial_expiry_date']) );?></span></li><?php endif;?>
						</ul>
                        <?php else: ?>
                            <p class="text-center">You don't have any package subscription</p>
                        <?php endif; ?>
					</div>
					<?php if (!empty($subscription)) : ?>
					    <p class="text-center small">Auto Renew is Enabled. To change this, go to Account Settings</p>
					<?php endif; ?>
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
<?php
$step = 'accessed_products';
$checklist = get_user_checklist();
if ( isset( $checklist[ $step ] ) && ! $checklist[ $step ] && ! empty( $subscription ) ) : ?>
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                var ajaxUrl = fx.ajax_url;
                var data = {
                    'action': 'checklist_pass',
                    'step': '<?= $step; ?>'
                };
                $.post(ajaxUrl, data);
            }, 5000);
        });
    </script>
<?php endif; ?>
<?php get_footer(); ?>

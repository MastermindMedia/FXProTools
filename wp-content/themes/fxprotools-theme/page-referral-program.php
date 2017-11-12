<?php
$checklist = get_user_checklist();
$active_referrals = get_user_active_referrals();
$referral_count = count( $active_referrals);
$username = wp_get_current_user()->user_login;
$referral_link = get_highest_converting_funnel_link();

$accomplished = $referral_count;
define( 'GAUGE_BASE', 237 );
define( 'GAUGE_MAX', 470 );
define( 'MAX_STEP', 3 );
$average = ceil( ( GAUGE_MAX - GAUGE_BASE ) / MAX_STEP );
$angle = GAUGE_BASE + ( $average * $accomplished );
?>
<?php get_header(); ?>

	<?php get_template_part('inc/templates/nav-dashboard'); ?>

	<div class="container page-dashboard">
		<div class="row">
			<div class="col-md-12">
				<div class="fx-header-title">
					<h1>Wait! Did You Know Your Access Could Be Free</h1>
					<p><span class="label-red">Step 3:</span> - Refer 3 People To FX Pro Tools Products & Yours Become Free</p>
				</div>
			</div>
			<div class="col-md-8">
				<?php 
					// Metabox Page Template Option - Video Embed 
					echo get_mb_pto1( 'video_embed', 'pto1' );
				?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4">
				<div class="fx-board checklist">
					<div class="fx-board-header w-text">
                        <div class="group-title">
                            <span class="title">Refer 3 & Your Free</span>
                            <span class="sub">With Our Referral program You Can Gain Access To Your Membership For Free!</span>
                        </div>
                        <div class="group-counter">
                            <svg id="meter" viewBox="0 0 217.36 118.8">
                                <circle r="75" cx="50%" cy="95%" stroke="#DDD"
                                        stroke-width="60" fill="none"></circle>
                                <circle r="75" cx="50%" cy="95%" stroke="#03ae78"
                                        stroke-width="60" fill="none" stroke-dasharray="<?= $angle; ?>, 943"></circle>
								<?php if ( $accomplished < MAX_STEP ): ?>
                                    <circle r="75" cx="50%" cy="94%" stroke="#DDD"
                                            stroke-width="60" fill="none" stroke-dasharray="<?php echo $accomplished > 0 ? 200 : 240; ?>, 943"></circle>
								<?php endif; ?>
                                <g class="danger-dial-tuner" transform="rotate(126 108.93 111.42)" style="transform: rotate(<?= ceil( $accomplished / MAX_STEP * 180 ); ?>deg);transform-origin: 108.93px 111.42px 0px;">
                                    <path class="danger-dial-tuner__needle"
                                          d="M109.82,104.28l-1.6-.13h0c-18-1.25-55.68,7.26-55.68,7.26s37.66,8.51,55.69,7.26h0.16a7.3,7.3,0,0,0,1.45-.15c5.22-.4,7.16-7.12,7.16-7.12S115,104.67,109.82,104.28Z"
                                          transform="translate(0 0.01)"></path>
                                    <circle class="danger-dial-tuner__knob" cx="108.93" cy="111.42" r="4.1" style="fill: #fff;"></circle>
                                </g>
                            </svg>
                            <span class="number"><?= $accomplished; ?></span> of <span class="number"><?= MAX_STEP; ?></span>
                        </div>
                        <div class="clearfix"></div>
					</div>
					<ul class="fx-board-list">
						<li>
							<span class="fx-checkbox <?php echo $referral_count > 0 ? 'checked' : '';?>"></span>
							<span class="fx-text">Refer First Friend</span>
						</li>
						<li>
							<span class="fx-checkbox <?php echo $referral_count > 1 ? 'checked' : '';?>"></span>
							<span class="fx-text">Refer Second Friend</span>
						</li>
						<li>
							<span class="fx-checkbox <?php echo $referral_count > 2 ? 'checked' : '';?>"></span>
							<span class="fx-text">Refer Third Friend</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="fx-ref-links">
					<div class="row">
						<div class="col-md-6">
							<div class="fx-ref-link">
								<div class="fx-ref-title">
									<h3>Option 1: Refer To Someone</h3>
									<p>Tell your friends and coworkers about FX Pro Tools</p>
								</div>
								<div class="box">
									Share your unique referral link
									<div class="link">
										<?php  
											if(strpos(get_the_author_meta('user_login', get_current_user_id()), ' ') > 0){
												echo $referral_link; ?>?ref=<?php echo affwp_get_affiliate_id(wp_get_current_user()->ID);
											}else{
												echo $referral_link; ?>?ref=<?php echo urlencode($username);
											}
										?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="fx-ref-link">
								<div class="fx-ref-title">
									<h3>Option 2: With Our Sales Funnels</h3>
									<p>Promoting your business should be easy</p>
								</div>
								<div class="box">
									<div class="text-center">
										We provide you with all the Marketing Sales <br/>Funnels you need to explain FX Pro tools
									</div>
									<a href="<?php bloginfo('url');?>/markting/funnels" class="btn btn-danger block padding-md">
										Access Your Sales Funnels
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<br/>
			<div class="col-md-12">
				<a href="<?php bloginfo('url');?>/product/professional" class="btn btn-danger block p-m">Thanks For Letting Me Know.. Continue To Your Products</a>
			</div>
		</div>
	</div>

<?php get_footer(); ?>

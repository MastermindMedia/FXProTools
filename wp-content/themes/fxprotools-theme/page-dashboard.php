<?php
$checklist = get_user_checklist();

// Get Your Free Shirt
if ( ! $checklist['got_shirt'] ) {
	if ( Woocommerce_Settings::has_claimed_shirt() ) {
		pass_onboarding_checklist( 'got_shirt' );
	}
}

// Share Video && Refer a friend
if ( ! $checklist['shared_video'] ) {
	$funnels = get_funnels();
	$shared_video = $checklist['shared_video'];
	foreach ( $funnels as $funnel ) {
		$stats = get_funnel_stats( $funnel->ID );

		foreach ( $stats as $stat ) {
			if ( isset($stat['page_views']) && $stat['page_views']['unique'] >= 1 && ! $shared_video ) {
				pass_onboarding_checklist( 'shared_video' );
				$shared_video = true;
			}

			// exit the second loop as soon as both are satisfied
			if ( $shared_video ) {
				break;
			}
		}
		// exit the first loop
		if ( $shared_video ) {
			break;
		}
	}
}

// Refer a friend
if ( ! $checklist['referred_friend'] ) {
	$active_referrals = get_user_active_referrals();
	if ( count( $active_referrals ) > 0 ) {
		pass_onboarding_checklist( 'referred_friend' );
	}
}

// Refresh the checklist
$checklist = get_user_checklist();

$accomplished = 0;
if ( ! empty( $checklist ) ) {
	foreach ( $checklist as $list ) {
		if ( $list ) {
			$accomplished ++;
		}
	}
}

$dashboard_checklist = [
	'verified_email'    => [
		'title'   => 'Verify your e-mail',
		'subtext' => 'Check your inbox and confirm your email to gain access'
	],
	'verified_profile'  => [
		'title'   => 'Update/Verify Profile (SMS #)',
		'subtext' => 'Add your Phone Number to your profile to get instant notifications.'
	],
	'scheduled_webinar' => [
		'title'   => 'Schedule For Webinar',
		'subtext' => 'Don\'t miss out weekly Q&A webinars to answer all your questions.'
	],
	'accessed_products' => [
		'title'   => 'Access your product',
		'subtext' => 'Full Access to the products you purchased 24/7.'
	],
	'got_shirt'         => [
		'title'   => 'Get your free shirt',
		'subtext' => 'Receive one FREE T-shirt from our store with coupon code: XXXXXX'
	],
	'shared_video'      => [
		'title'   => 'Share Video',
		'subtext' => 'Use our special invitation video to share this valuable skillset with someone.'
	],
	'referred_friend'   => [
		'title'   => 'Refer A Friend',
		'subtext' => 'When you refer people to our platform, we reward you!'
	],
];
?>
<?php get_header(); ?>

<?php get_template_part( 'inc/templates/nav-dashboard' ); ?>

<div class="container page-dashboard">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="fx-header-title">
				<?php if ( is_user_fx_customer() ) : ?>
                    <h1>Welcome! Thanks for Being A Loyal Customer</h1>
                    <p><span class="label-red">Step 1:</span> Onboarding Message &amp; Getting The Most Out Of CopyProfitShare!</p>
				<?php elseif ( is_user_fx_distributor() ) : ?>
                    <h1>Welcome! Thanks for Being A Loyal Distributor</h1>
                    <p><span class="label-red">Step 1:</span> Onboarding Message &amp; Getting The Most Out Of CopyProfitShare!</p>
				<?php else : ?>
                    <h1>Welcome! Thanks for Being A Loyal Distributor</h1>
                    <p><span class="label-red">Step 1:</span> Onboarding Message &amp; Getting The Most Out Of CopyProfitShare!</p>
				<?php endif; ?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-8">
							<?php
							// Metabox Page Template Option - Video Embed
							echo get_mb_pto1( 'video_embed', 'pto1' );
							?>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <a href="#" class="btn btn-danger btn-lg btn-lg-w-text block btn-ico-lg btn-one">
                                        <div class="left">
                                            <img src="<?php bloginfo( 'template_url' ); ?>/assets/img/ico1.png" class="img-responsive">
                                        </div>
                                        <div class="right">
                                            Reserve A Seat
                                            <span>** Seats Are Limited **</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <a href="/<?php echo Woocommerce_Settings::POST_NAME_FREE_SHIRT; ?>" class="btn btn-danger btn-lg block btn-ico-lg btn-two"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="fx-board checklist">
                                <div class="fx-board-header">
                                    <div class="group-title">
                                        <span class="title">Onboarding Checklist</span>
                                        <span class="sub">Learn More About CPS 3.0</span>
                                    </div>
                                    <div class="group-counter">
	                                    <?php echo display_fx_gauge(count($dashboard_checklist), $accomplished); ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <ul class="fx-board-list w-toggle">
									<?php
									foreach ( $dashboard_checklist as $step => $dashboard_checklist ):
										?>
                                        <li>
                                            <span class="fx-checkbox <?php echo ! empty( $checklist[ $step ] ) ? 'checked' : ''; ?>"></span>
                                            <span class="fx-text"><?= $dashboard_checklist['title']; ?></span>
                                            <div class="content">
												<?= $dashboard_checklist['subtext']; ?>
                                            </div>
                                            <span class="fa fa-angle-down icon"></span>
                                        </li>
									<?php endforeach; ?>
                                    <li><a href="<?php echo get_checklist_next_step_url(); ?>" class="btn btn-danger btn-lg fx-btn block">I'm ready for the next step</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

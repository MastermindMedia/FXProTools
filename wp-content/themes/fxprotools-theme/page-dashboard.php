<?php
$checklist = get_user_checklist();
?>
<?php get_header(); ?>

	<?php get_template_part('inc/templates/nav-dashboard'); ?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<div class="fx-header-title">
                <?php if( is_user_fx_customer() ) : ?>
					<h1>Welcome! Thanks for Being A Loyal Customer</h1>
					<p><span class="label-red">Step 1:</span> Onboarding Message &amp; Getting The Most Out Of CopyProfitShare!</p>
                <?php elseif(is_user_fx_distributor()) : ?>
                    <h1>Welcome! Thanks for Being A Loyal Distributor</h1>
					<p><span class="label-red">Step 1:</span> Onboarding Message &amp; Getting The Most Out Of CopyProfitShare!</p>
                <?php else : ?>
                    <h1>Welcome! Thanks for Being A Loyal Distributor</h1>
					<p><span class="label-red">Step 1:</span> Onboarding Message &amp; Getting The Most Out Of CopyProfitShare!</p>
                <?php endif;?>
				</div>
				
			</div>
			<div class="col-md-8">
				<?php 
					// Metabox Page Template Option - Video Embed 
					echo get_mb_pto1('video_embed');
				?>
			</div>
			<div class="col-md-4">
				<div class="fx-board checklist">
					<div class="fx-board-header">
						<div class="group-title">
							<span class="title">Onboarding Checklist</span>
							<span class="sub">Learn More About CPS 3.0</span>
						</div>
						<div class="group-counter">
							<img src="<?php bloginfo('template_url'); ?>/assets/img/meter.png" class="img-responsive">
							<span class="number">0</span> of <span class="number">7</span>
						</div>
						<div class="clearfix"></div>
					</div>
					<ul class="fx-board-list w-toggle">
						<li>
							<span class="fx-checkbox <?php echo !empty( $checklist['verified_email'] ) ? 'checked' : '';?>"></span>
							<span class="fx-text">Verify your e-mail</span>
							<div class="content">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt.
							</div>
							<span class="fa fa-angle-down icon"></span>
						</li>
						<li>
							<span class="fx-checkbox <?php echo !empty( $checklist['verified_profile'] ) ? 'checked' : '';?>"></span>
							<span class="fx-text">Update/Verify Profile (SMS #)</span>
							<div class="content">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt.
							</div>
							<span class="fa fa-angle-down icon"></span>
						</li>
						<li>
							<span class="fx-checkbox <?php echo !empty( $checklist['scheduled_webinar'] ) ? 'checked' : '';?>"></span>
							<span class="fx-text">Schedule For Webinar</span>
							<div class="content">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt.
							</div>
							<span class="fa fa-angle-down icon"></span>
						</li>
						<li>
							<span class="fx-checkbox <?php echo !empty( $checklist['accessed_products'] ) ? 'checked' : '';?>"></span>
							<span class="fx-text">Access your product</span>
							<div class="content">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt.
							</div>
							<span class="fa fa-angle-down icon"></span>
						</li>
						<li>
							<span class="fx-checkbox <?php echo !empty( $checklist['got_shirt'] ) ? 'checked' : '';?>"></span>
							<span class="fx-text">Get your free shirt</span>
							<div class="content">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt.
							</div>
							<span class="fa fa-angle-down icon"></span>
						</li>
						<li>
							<span class="fx-checkbox <?php echo !empty( $checklist['shared_video'] ) ? 'checked' : '';?>"></span>
							<span class="fx-text">Share Video</span>
							<div class="content">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt.
							</div>
							<span class="fa fa-angle-down icon"></span>
						</li>
						<li>
							<span class="fx-checkbox <?php echo !empty( $checklist['referred_friend'] ) ? 'checked' : '';?>"></span>
							<span class="fx-text">Refer A Friend</span>
							<div class="content">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt.
							</div>
							<span class="fa fa-angle-down icon"></span>
						</li>
						<li><a href="<?php echo get_checklist_next_step_url();?>" class="btn btn-danger btn-lg fx-btn block">I'm ready for the next step</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="container m-t-lg">
		<div class="row">
			<div class="col-md-8">
				<a href="#" class="btn btn-default btn-lg block">Schedule for "Welcome Webinar"</a>
			</div>
			<div class="col-md-4">
				<a href="#" class="btn btn-default btn-lg block">Get Your Free T-shirt(Store)</a>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
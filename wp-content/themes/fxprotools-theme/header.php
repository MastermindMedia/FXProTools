<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<title><?php echo wp_title( ' | ', false, 'right' ); bloginfo( 'name' );?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	
	<?php $exclude_pages = array('login', 'forgot-password', 'f1', 'f2', 'f3', 'f4', 'signals', 'log-out-notice', 'lp1', 'lp2', 'lp3'); ?>
	<div class="<?php echo !is_home() ? 'fx-wrapper' : ''; ?> <?php echo is_page(array('login', 'forgot-password')) ? 'fx-login' : ''; ?>">
		
		<?php if( is_user_logged_in() && !is_page($exclude_pages) && !is_home() && !is_404() ): ?>
		<nav class="navbar fx-navbar-main" role="navigation">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-2">
						<div class="navbar-header fx-navbar-header">
							<a class="navbar-brand" href="#">
								<img src="<?php bloginfo('template_url'); ?>/assets/img/logo.png" class="img-responsive">
							</a>
						</div>
						<div class="visible-xs">
							<a href="#" class="xs-toggle-nav">
								<span></span>
								<span></span>
								<span></span>
								<span></span>
							</a>
						</div>
					</div>
					<div class="xs-nav-side col-sm-12 col-md-10">
						<div class="row">
							<div class="col-xs-12 col-sm-8 col-md-8">
								<?php
									// Metabox Page Template Option
									// TODO: to support pto2 and pto3
									echo get_mb_pto1( 'main_header_menu', 'pto1' );
								?>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4">
								<ul class="fx-nav-options right">
									<!-- <li><a href="#" title="Select Language"><i class="fa fa-th-large" aria-hidden="true"></i></a></li> -->
									<li class="account">
										<a href="<?php bloginfo('url'); ?>/my-account">
											<i class="fa fa-user block icon-inbox visible-xs"></i>
											My Account
										</a>
									</li>
									<li>
										<a href="<?php bloginfo('url'); ?>/my-account/inbox" title="Support Icon">
											<i class="fa fa-inbox block icon-inbox"></i>
											<span>Inbox</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<?php endif; ?>

		<div class="fx-content-wrapper">

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
	<div class="<?php echo !is_home() ? 'fx-wrapper' : ''; ?> <?php echo is_page(array('login', 'forgot-password')) ? 'fx-login' : ''; ?>">

		<?php if( is_user_logged_in() && !is_page(array('login', 'forgot-password', 'f1', 'f2', 'f3', 'f4', 'signals')) && !is_home() && !is_404() ): ?>
		<nav class="navbar fx-navbar-main" role="navigation">
			<div class="container">
				<div class="row">
					<div class="col-md-2">
						<div class="navbar-header fx-navbar-header">
							<a class="navbar-brand" href="#">
								<img src="<?php bloginfo('template_url'); ?>/assets/img/logo.png" class="img-responsive">
							</a>
						</div>
					</div>
					<div class="col-md-7">
						<ul class="fx-nav-options">
							<li>
								<a href="<?php bloginfo('url'); ?>/dashboard">
									<img src="<?php bloginfo('template_url'); ?>/assets/img/ico-quickstart.png" class="img-responsive" width="65" height="44">
									<span>Quickstart</span>
								</a>
							</li>
							<li>
								<a href="<?php bloginfo('url'); ?>/basic-training">
									<img src="<?php bloginfo('template_url'); ?>/assets/img/ico-products.png" class="img-responsive" width="48" height="44">
									<span>Products</span>
								</a>
							</li>
							<?php  if ( is_user_fx_distributor() || current_user_can('administrator') ): ?>
							<li>
								<a href="<?php bloginfo('url'); ?>/marketing/funnels">
									<img src="<?php bloginfo('template_url'); ?>/assets/img/ico-share.png" class="img-responsive" width="44" height="44">
									<span>Share</span>
								</a>
							</li>
							<li>
								<a href="<?php bloginfo('url'); ?>/referred-members">
									<img src="<?php bloginfo('template_url'); ?>/assets/img/ico-team.png" class="img-responsive" width="50" height="44">
									<span>Team</span>
								</a>
							</li>
							<?php endif;?>
							<li>
								<a href="<?php bloginfo('url'); ?>/wallet">
									<img src="<?php bloginfo('template_url'); ?>/assets/img/ico-wallet.png" class="img-responsive" width="61" height="44">
									<span>eWallet</span>
								</a>
							</li>
						</ul>
					</div>
					<div class="col-md-3">
						<ul class="fx-nav-options">
							<!-- <li><a href="#" title="Select Language"><i class="fa fa-th-large" aria-hidden="true"></i></a></li> -->
							<li class="account"><a href="<?php bloginfo('url'); ?>/my-account">My Account</a></li>
							<li>
								<a href="#" title="Support Icon">
									<i class="fa fa-inbox block icon-inbox"></i>
									<span>Inbox</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
		<?php endif; ?>

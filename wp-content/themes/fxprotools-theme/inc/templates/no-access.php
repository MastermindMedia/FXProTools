<div class="fx-access-denied-container">
	<div class="fx-access-denied-top">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<ul class="fx-missing-left fx-missing-nav">
						<li><a href="mailto:support@fxprotools.com">support@fxprotools.com</a></li>
						<li><a href="tel:+1 800 781 0187">+1 800 781 0187</a></li>
						<li>Mon-Fri 10am-10pm EST</li>
					</ul>
				</div>
				<div class="col-sm-6">
					<ul class="fx-missing-right fx-missing-nav">
						<li><a href="#" class="btn-flag">English</a></li>
						<li class="fx-nav-btn"><a href="<?php echo get_option('home'); ?>/login">Members Login</a></li>
					</ul>
				</div>		
			</div>
		</div>
	</div>
	<div class="section-one">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<a href="http://fxprotools.com" class="logo">Fx Pro Tools</a>
				</div>
				<div class="col-sm-6">
					<ul class="fx-nav">
						<li><a href="<?php echo get_option('home'); ?>/login">Become a Customer</a></li>
						<li><a href="<?php echo get_option('home'); ?>/login">Become a Distributor</a></li>
					</ul>
				</div>		
			</div>
		</div>
	</div>
	<div class="section-note">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>CopyProfitShare is the map that teaches you specialized market knowledge!</p>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="fx-header-title">
					<h1>It Looks Like You Do Not Have Access</h1>
					<p>Luckily, we can unlock the page for you instantly!</p>
				</div>
			</div>
		</div>
		<div class="row m-t-md m-b-lg">
			<div class="col-md-6">
				<div class="panel fx-package-item active">
					<span class="sash">UPGRADE</span>
					<div class="panel-body">
						<div class="heading">
							<p class="text-left">It looks like in order for your to see this page / content you will need to upgrade your account, see details below:</p>
							<h3 class="text-normal">Forex & Binary Options</h3>
							<h1 class="m-t-none"><?php echo $wp_query->query_vars['_prod_data']->get_title(); ?></h1>
						</div>
						<div class="text-center">
							<h2 class="m-b-md"><?php echo wc_price($wp_query->query_vars['_prod_data']->get_regular_price()); ?></h2>
							<a href="<?php echo get_the_permalink($wp_query->query_vars['_prod_id']); ?>" class="btn btn-danger block btn-lg m-b-md btn-lg-w-text">
								Get Instant Access Now!
								<span>Training + Forex &amp; Binary Auto Trader</span>
							</a>
							<p class="text-bold">Downgrade / or Cancel At Anytime!</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="note">
					<img src="http://via.placeholder.com/600x300?text=Video" class="img-responsive centered-block m-b-sm">
					<p class="text-center">Find out about becoming a trader during the next free webinar.</p>
					<a href="<?php echo get_the_permalink($wp_query->query_vars['_prod_id']); ?>" class="btn btn-danger block btn-lg m-b-md btn-lg-w-text">Upgrade Your Account!</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('body').addClass('fx-access-denied');
	});
</script>
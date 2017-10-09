<?php get_header(); ?>

<div class="fx-404-container">
	<div class="fx-404-top">
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
					<h1>Hmm.. We Can't Seem to Find this Page.</h1>
					<p>Luckily, we're better at finding market movements.</p>
				</div>
			</div>
		</div>
		<div class="row m-t-md m-b-lg">
			<div class="col-md-6">
				<div class="note-gray">
					<p>We're not sure what happened to this page, but maybe we can help you out:</p>
					<ul class="numbered-bullets">
						<li><span>1.</span>Retype the web address and try again.</li>
						<li><span>2.</span>Check out to our support area <a href="#">here</a> to get you where you need to go.</li>
						<li><span>3.</span>Accept this short technical analysis tutorial video as our apology gift for losing that page.</li>
					</ul>
					<p>If all else fails, report this link as broken, by <a href="#">click here</a></p>
				</div>
			</div>
			<div class="col-md-6">
				<div class="note">
					<img src="http://via.placeholder.com/600x300?text=Video" class="img-responsive centered-block m-b-sm">
					<p class="text-center">Find out about becoming a trader during the next free webinar.</p>
					<a href="#" class="btn btn-danger block btn-lg m-b-md btn-lg-w-text reserve-your-seat">Register Now</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('body').addClass('fx-404');
	});
</script>

<?php get_footer(); ?>
<?php if( !is_user_logged_in() ): ?>
<div class="section-one">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<a href="<?php bloginfo('url'); ?>" class="logo">Fx Pro Tools</a>
			</div>
			<div class="col-md-6">
				<ul class="fx-nav">
					<li><a href="<?php bloginfo('url'); ?>/login">Members Login</a></li>
					<li><a href="#">Support</a></li>
				</ul>
			</div>		
		</div>
	</div>
</div>
<?php endif; ?>
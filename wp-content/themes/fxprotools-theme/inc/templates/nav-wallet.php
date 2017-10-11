<?php $customer = false; ?>
<nav class="navbar fx-navbar-sub">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="fx-nav-options">
					<li class="dashboard">
						<a href="<?php bloginfo('url'); ?>/wallet/" class="icon icon-wallet">Wallet</a>
					</li>
					<?php if ($customer): ?>
					<li class="active">
						<a href="<?php bloginfo('url'); ?>/wallet/referred-members">
							<span class="number">1.</span>
							<span class="text">Referred Members</span>
						</a>
					</li>
					<?php else: ?>
					<li class="active">
						<a href="<?php bloginfo('url'); ?>/wallet">
							<span class="number">1.</span>
							<span class="text">E-Wallet Setup</span>
						</a>
					</li>
					<?php endif; ?>
					<li>
						<a href="<?php bloginfo('url'); ?>/wallet/summary">
							<span class="number">2.</span>
							<span class="text">E-Wallet Summary</span>
						</a>
					</li>
					<li>
						<a href="<?php bloginfo('url'); ?>/wallet/bonuses">
							<span class="number">3.</span>
							<span class="text">Bonuses</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>
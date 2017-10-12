<?php $customer = false; ?>
<nav class="navbar fx-navbar-sub">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<?php
					// Get group menus fields
					$menus = rwmb_meta( 'group_pto_menus' );
					$header_menu = $menus['select_pto_display_header_menu'];
					$secondary_hmenu = $menus['taxonomy_pto_secondary_header_menu'];
				?>

				<?php if($header_menu == 'yes' || $header_menu == 'default') : ?>

				<div class="hide">
					<?php
						$params = array(
							'theme_location'  => '',
							'menu'            => $secondary_hmenu,
							'container'       => false,
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => 'fx-nav-options',
							'menu_id'         => $secondary_hmenu,
							'echo'            => true,
							'fallback_cb'     => 'wp_page_menu',
							'before'          => '',
							'after'           => '',
							'link_before'     => '',
							'link_after'      => '',
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 0,
							'walker'          => ''
						);
						wp_nav_menu( $params );
					?>
				</div>


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
				<?php else : ?>
					<p>No menu selected.</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</nav>

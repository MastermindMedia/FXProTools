<?php 

function afl_team_purchases_overview () {
		echo afl_eps_page_header();
	
	echo afl_content_wrapper_begin();
		afl_team_purchase_overview_template();
	echo afl_content_wrapper_end();
}

function afl_team_purchase_overview_template () {
		new Afl_enque_scripts('common');
	
		$affiliates_table = new Eps_team_purchases_data_table();
	?>
		 
		
			<div class="wrap">
			<h1>
				<!-- <?php _e( 'Affiliates', 'affiliate-wp' ); ?> -->
				<!-- <a href="<?php echo esc_url( add_query_arg( array( 'affwp_notice' => false, 'action' => 'add_affiliate' ) ) ); ?>" class="page-title-action"><?php _e( 'Add New', 'affiliate-wp' ); ?></a>
				<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'affiliate-wp-reports', 'tab' => 'affiliates' ) ) ); ?>" class="page-title-action"><?php _ex( 'Reports', 'affiliates', 'affiliate-wp' ); ?></a> -->
			</h1>
			<?php

			/**
			 * Manage Members pf eps-affiliates
			 *
			 * Use this hook to add content to this section of AffiliateWP.
			 */
				do_action( 'eps_affiliates_page_top' );

				?>
				<form id="eps-affiliates-filter" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
					<input type="hidden" name="page" value="affiliate-eps-team-purchases-reports" />

					<?php //$affiliates_table->views() ?>
					<?php $affiliates_table->search_box('search', 'search_id') ?>
					<?php $affiliates_table->prepare_items() ?>
					<?php $affiliates_table->display() ?>
				</form>
				<?php
				/**
				 * Fires at the bottom of the admin affiliates page.
				 *
				 * Use this hook to add content to this section of AffiliateWP.
				 */
				do_action( 'eps_affiliates_page_bottom' );
				?>
			</div>
	<?php 
}
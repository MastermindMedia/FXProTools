<?php
	function afl_shortcode_demo () {
		echo afl_eps_page_header();
		afl_content_wrapper_begin();
			afl_shortcode_demo_callback();
		afl_content_wrapper_end();
	}

	function afl_shortcode_demo_callback(){
		//matrix reffered members
		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">Matrix Reffered Members : [afl_eps_matrix_reffered_downlines] </h3>';
		do_shortcode('[afl_eps_matrix_reffered_downlines]');
		echo '</div>';
		
		//genealogy tree
		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">Matrix Genealogy Tree : [afl_eps_matrix_genealogy_tree] </h3>';
		do_shortcode('[afl_eps_matrix_genealogy_tree]');
		echo '</div>';

		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">Matrix Holding Tank : [afl_eps_matrix_holding_tank] </h3>';
		do_shortcode('[afl_eps_matrix_holding_tank]');
		echo '</div>';

		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">Matrix Direct Uplines : [afl_eps_matrix_direct_uplines_shortcode] </h3>';
		do_shortcode('[afl_eps_matrix_direct_uplines_shortcode]');
		echo '</div>';


		//toggle placement
		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">Matrix Holding Tank Toggle Placement: [afl_eps_matrix_holding_tank_genealogy_toggle_placement] </h3>';
		do_shortcode('[afl_eps_matrix_holding_tank_genealogy_toggle_placement]');
		echo '</div>';


		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">Unilevel Reffered Members : [afl_eps_unilevel_reffered_downlines] </h3>';
		do_shortcode('[afl_eps_unilevel_reffered_downlines]');
		echo '</div>';

		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">Unilevel Genealogy Tree : [afl_eps_unilevel_genealogy_tree] </h3>';
		do_shortcode('[afl_eps_unilevel_genealogy_tree]');
		echo '</div>';

		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">Unilevel Holding Tank : [afl_eps_unilevel_holding_tank] </h3>';
		do_shortcode('[afl_eps_unilevel_holding_tank]');
		echo '</div>';

		//toggle placement
		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">Unilevel Holding Tank Toggle Placement : [afl_unilevel_holding_tank_genealogy_toggle_placement] </h3>';
		do_shortcode('[afl_unilevel_holding_tank_genealogy_toggle_placement]');
		echo '</div>';

		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">Unilevel Direct Uplines : [afl_eps_unilevel_direct_uplines_shortcode] </h3>';
		do_shortcode('[afl_eps_unilevel_direct_uplines_shortcode]');
		echo '</div>';

		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">E-Wallet summary Widgets: [afl_ewallet_all_earnings_summary_blocks_shortcode] </h3>';
		do_shortcode('[afl_ewallet_all_earnings_summary_blocks_shortcode]');

		echo '<h3 class="text-center">E-Wallet summary : [afl_ewallet_summary] </h3>';
		do_shortcode('[afl_ewallet_summary]');
		echo '</div>';


		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">E-Wallet summary Widgets: [afl_ewallet_all_earnings_summary_blocks_shortcode] </h3>';
		do_shortcode('[afl_ewallet_all_earnings_summary_blocks_shortcode]');

		echo '<h3 class="text-center">E-Wallet Transactions : [afl_ewallet_transactions] </h3>';
		do_shortcode('[afl_ewallet_transactions]');
		echo '</div>';


		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">Bonus summary Widgets: [afl_bonus_summary_widgets] </h3>';
		do_shortcode('[afl_bonus_summary_widgets]');

		echo '<h3 class="text-center">Bonus Summary : [afl_bonus_summary_and_incentives] </h3>';
		do_shortcode('[afl_bonus_summary_and_incentives]');
		echo '</div>';

		//sponsor info
		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">Sponsor Info : [afl_sponsor_info] </h3>';
		do_shortcode('[afl_sponsor_info]');
		echo '</div>';

		//Team info
		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">Team Info : [afl_team_info] </h3>';
		do_shortcode('[afl_team_info]');
		echo '</div>';

		//Genealogy info
		echo '<div class="row" style="border:3px solid #ccc;padding:4px;margin:25px 0px 0px 0px;background:#fff;">';
		echo '<h3 class="text-center">Genealogy Info : [afl_genealogy_info] </h3>';
		do_shortcode('[afl_genealogy_info]');
		echo '</div>';

	}
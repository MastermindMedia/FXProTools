<?php 
	function afl_holding_tank_genealogy_toggle_placement () {
		do_action('eps_affiliate_page_header');
	 	do_action('afl_content_wrapper_begin');
 			afl_holding_tank_genealogy_toggle_placement_form();
	 	do_action('afl_content_wrapper_end');
	}

	function afl_holding_tank_genealogy_toggle_placement_form() {
		wp_enqueue_style( 'plan-heirarchy', EPSAFFILIATE_PLUGIN_PLAN.'/matrix/css/heirarchy/css/hierarchy-view.css');
		wp_enqueue_style( 'plan-style', EPSAFFILIATE_PLUGIN_PLAN.'matrix/css/heirarchy/css/main.css');

		wp_register_script( 'jquery-confirm-js',  EPSAFFILIATE_PLUGIN_ASSETS.'plugins/jquery-confirm/js/jquery-confirm.js');
		wp_enqueue_script( 'jquery-confirm-js' );
		wp_register_style( 'jquery-confirm-cs',  EPSAFFILIATE_PLUGIN_ASSETS.'plugins/jquery-confirm/css/jquery-confirm.css');
		wp_enqueue_style( 'jquery-confirm-cs' );

		// wp_enqueue_style( 'plan-style', EPSAFFILIATE_PLUGIN_PLAN.'matrix/css/tree-new/style.css');
		$path = EPSAFFILIATE_PLUGIN_PLAN.'matrix/';
		afl_get_template('plan/matrix/holding-toggle-genealogy-tree-all.php');
	}
<?php 
/*
 * -----------------------------------------------------------
 * Action / Fiter hooks
 * -----------------------------------------------------------
*/
 	add_action( 'admin_init', 'eps_affiliate_epin_check_if_installed' );
 	add_action('init', 'common_assets_load');
	function common_assets_load(){ 
 	wp_register_script('epin-js',EPSAFFILIATE_EPIN_PLUGIN_ASSETS.'js/epin.js');
	wp_enqueue_script('epin-js');
}

/**
 * ----------------------------------------------------------
 * Apply eps-affiliates style to pages
 * ----------------------------------------------------------
*/
 add_filter('eps_affiliates_style_applied_pages','eps_affiliates_epin_style_pages',1);
 function eps_affiliates_epin_style_pages ($pages) {
 	$pages[] 	= 'e-pin';
 	$pages[] 	= 'e-pin-configs';
 	$pages[]  = 'e-pin-generate';
 	$pages[]  = 'my-e-pin';	
 	$pages[]  = 'all-e-pin';	
 	$pages[]	=	'e-pin-purchase';
 	
 	return $pages;
 }


 /*
 * ------------------------------------------------------------
 * Delete My Epin a withdrawal request
 *
 * Get an as input to the action, The Epin  Request is approve
 * 
 * ------------------------------------------------------------
*/
 add_filter('epsaffliates_epin_delete_my_pin', 'epsaffliates_epin_delete_my_pin_callback', 10, 1);
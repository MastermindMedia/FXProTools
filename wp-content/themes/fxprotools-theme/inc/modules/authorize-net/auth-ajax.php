<?php
if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('AuthAjax')){

	class AuthAjax {
		
		public function __construct()
		{
			add_action('wp_ajax_get_customers', array($this, 'get_customers'));
			add_action('wp_ajax_view_lead', array($this, 'view_lead'));
		}	

		// Get all customers in authorize.net CIM
		public function get_customers()
		{
			$anet = new AuthAPI();
			$customers = $anet->get_all_users();
			$response['data'] = $customers['data'];
			wp_send_json($response);
			wp_die();
		}

		// View lead info for customers and subscriptions
		public function view_lead()
		{
			$source = $_POST['source'];
			$id     = $_POST['id']; // Can be profile id or subscription id

			// dd($id);
			// Customer Information
			if ( $source == 'info_customer' ) {

			}

			if ( $source == 'info_subscription' ) {

			}

			$response['status'] = 'success';
			wp_send_json(@$response);
			wp_die();
		}

	}

}

return new AuthAjax();
<?php

if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('Woocommerce_Settings')){

	class Woocommerce_Settings {
		
		public function __construct()
		{
			add_action('woocommerce_thankyou', array($this, 'wc_after_checkout_redirect'));
			add_filter('wc_authorize_net_cim_credit_card_payment_form_save_payment_method_checkbox_html', array($this,'wc_auth_net_cim_save_payment_method_default_checked'), 10, 2 );
			add_filter ('woocommerce_add_to_cart_redirect ', array($this, 'wc_add_to_cart_redirect') );
			add_action('template_redirect', array($this, 'wc_redirect_to_checkout_if_cart') );
			add_filter('woocommerce_add_cart_item_data', array($this, 'wc_clear_cart') );
			add_filter('wc_add_to_cart_message_html', array($this, 'wc_clear_add_to_cart_message') );

		}

		public function wc_after_checkout_redirect( $order_id )
		{
		    $order = new WC_Order( $order_id );
		    $url = home_url(). '/dashboard';
		    if ( $order->status != 'failed' ) {
		        wp_redirect($url);
		        exit;
		    }
		}

		public function wc_auth_net_cim_save_payment_method_default_checked( $html, $form ) {
			if ( empty( $html ) || $form->tokenization_forced() ) {
				return $html;
			}
			
			return str_replace( 'type="checkbox"', 'type="checkbox" checked="checked"', $html );
		}

		public function wc_add_to_cart_redirect($wc_get_cart_url){
			return site_url('#trial-products');
		}


		public function wc_redirect_to_checkout_if_cart() {
			if ( !is_cart() ) return;

			global $woocommerce;
			if (sizeof(WC()->cart->get_cart()) != 0) {
				wp_redirect( $woocommerce->cart->get_checkout_url(), '301' );
				exit;
			}
			else{
				wp_redirect( site_url('#trial-products'), '301' );
				exit;
			}
			
		}

		public function wc_clear_cart ($cart_item_data) {
			global $woocommerce;
			$woocommerce->cart->empty_cart();
			return $cart_item_data;
		}

		public function wc_clear_add_to_cart_message ( $message ) {
			return ''; 
		}

	

	}
}

return new Woocommerce_Settings();

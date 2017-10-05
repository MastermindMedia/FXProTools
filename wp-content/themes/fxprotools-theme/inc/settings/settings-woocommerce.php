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
			add_action( 'template_redirect', array($this, 'wc_redirect_to_checkout_if_cart') );
			add_action( 'woocommerce_add_cart_item_data', array($this, 'wc_clear_cart'), 0 );
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


		public function wc_redirect_to_checkout_if_cart() {
			if ( !is_cart() ) return;
			global $woocommerce;
			wp_redirect( $woocommerce->cart->get_checkout_url(), '301' );
			exit;
		}

		public function wc_clear_cart () {
			global $woocommerce;
			$woocommerce->cart->empty_cart();
		}

	

	}
}

return new Woocommerce_Settings();

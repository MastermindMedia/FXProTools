<?php

if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('WC_Subscriptions_Settings')){

	class WC_Subscriptions_Settings {
		
		public function __construct()
		{
			add_action('woocommerce_scheduled_subscription_expiration', array($this, 'wc_scheduled_subscription_expiration'), 10, 1);
		}
		
		/**
		 * [Subscription expiration handler]
		 * @param  int
		 */
		public function wc_scheduled_subscription_expiration( $subscription_id )
		{
			$subscription = wcs_get_subscription( $subscription_id );

		    if  ( self::wc_is_subcription_trial( $subscription) ){
		    	$new_subscription = self:: wc_create_new_subscription( $subscription );
		    	dd( $new_subscription );
		    } else{	
		    	
		    }
		    exit;
		}

		/**
		 * [If the expired subscription is a trial product]
		 * @param  WC_Subscription
		 * @return bool
		 */
		public static function wc_is_subcription_trial( $subscription )
		{
			if ( $subscription ) {
				$items = $subscription->get_items();
				foreach($items as $key => $item){
					$subscription_type = wc_get_order_item_meta($key, 'subscription-type', true);
			    	return ($subscription_type == 'trial') ? true : false; 
				}
			} else{
				return false;
			}
		}

		/**
		 * [Get Product id used on a subscription]
		 * @param  WC_Subscription
		 * @return integer
		 */
		public static function wc_get_subscription_product_id( $subscription )
		{
			if ( $subscription ) {
				$items = $subscription->get_items();
				foreach($items as $key => $item){
					return $item->get_product_id();
				}
			} else{
				return 0;
			}
		}

		/**
		 * [Create new regular subscription]
		 * @param  WC_Subscription
		 * @return integer
		 */
		public function wc_create_new_subscription( $old_subscription ){
			$address = $old_subscription->get_address('billing');
			$product = wc_get_product( self::wc_get_subscription_product_id( $old_subscription ) );
			$args = array(
		        'attribute_subscription-type' => 'normal'
		    );
		    $product_variation = $product->get_matching_variation($args);
			$product = wc_get_product($product_variation); 
			$quantity = 1;

		    // Create the order first, then the subscription
		    $order = wc_create_order( array( 'customer_id' => $old_subscription->get_customer_id() ));

		    $order->add_product( $product, $quantity, $args);
		    $order->set_address( $address, 'billing' );
		    $order->calculate_totals();
   			$order->update_status( 'processing', '[auto renewal via fxprotools]', TRUE);

   			// Order created, now create sub attached to it
   			$period = WC_Subscriptions_Product::get_period( $product );
		    $interval = WC_Subscriptions_Product::get_interval( $product );

		    $subscription = wcs_create_subscription( array('order_id' => $order->id, 'billing_period' => $period, 'billing_interval' => $interval) );
		    $subscription->add_product( $product, $quantity, $args);
		    $subscription->set_address( $address, 'billing' );
		    $subscription->calculate_totals();
		    WC_Subscriptions_Manager::activate_subscriptions_for_order($order);
    		return $subscription;
		}
	}
}

return new WC_Subscriptions_Settings();
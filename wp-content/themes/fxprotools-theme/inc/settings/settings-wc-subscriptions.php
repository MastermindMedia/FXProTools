<?php

if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('WC_Subscriptions_Settings')){

	class WC_Subscriptions_Settings {
		
		public function __construct()
		{

			add_filter('woocommerce_subscriptions_is_duplicate_site', array($this, 'wc_is_duplicate_site'), 10, 1);
			add_action('woocommerce_scheduled_subscription_expiration', array($this, 'wc_scheduled_subscription_expiration'), 10, 1);
			//add_action('woocommerce_checkout_subscription_created', array($this, 'wc_schedule_auto_renewal'), 10, 3);
			
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
		    	echo $new_subscription->is_manual();
		    	dd( $new_subscription );
		    	exit;

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
		public static function wc_create_new_subscription( $old_subscription ){
			$address = $old_subscription->get_address('billing');
			$product = wc_get_product( self::wc_get_subscription_product_id( $old_subscription ) );
			$args = array(
		        'attribute_subscription-type' => 'normal'
		    );
		    $product_variation = $product->get_matching_variation($args);
			$product = wc_get_product($product_variation); 
			$quantity = 1;

   			// Order created, now create sub attached to it
   			$period = WC_Subscriptions_Product::get_period( $product );
		    $interval = WC_Subscriptions_Product::get_interval( $product );

		    $order = new WC_Order( $old_subscription->get_parent_id() );

			$regular_subscription = wcs_create_subscription( array(
				'order_id'         => wcs_get_objects_property( $order, 'id' ),
				'customer_id'      => $order->get_user_id(),
				'billing_period'   => $period,
				'billing_interval' => $interval,
				'customer_note'    => wcs_get_objects_property( $order, 'customer_note' ),
			) );

		    $item_id = $regular_subscription->add_product(
				$product,
				1,
				array(
					'variation' => ( method_exists( $product, 'get_variation_attributes' ) ) ? $product->get_variation_attributes() : array(),
					'totals'    => array(
						'subtotal'     => $product->get_price(),
						'subtotal_tax' => 0,
						'total'        => $product->get_price(),
						'tax'          => 0,
						'tax_data'     => array( 'subtotal' => array(), 'total' => array() ),
					),
				)
			);

			$regular_subscription->set_address( $address, 'billing' );
			$regular_subscription->update_dates( array(
				'end'  => 0,
			) );
			$regular_subscription->set_total( 0, 'tax' );
			$regular_subscription->set_total( $product->get_price(), 'total' );
			$regular_subscription->set_payment_method( 'authorize_net_cim_credit_card' );
			$regular_subscription->set_requires_manual_renewal( false );
			$regular_subscription->calculate_totals();
			$regular_subscription->add_order_note( __( 'Pending subscription created.', 'woocommerce-subscriptions' ) );
			WC_Subscriptions_Manager::activate_subscriptions_for_order($order);
    		return $regular_subscription;
		}

		public function wc_schedule_auto_renewal( $subscription, $order, $recurring_cart = '' ){
			$product = wc_get_product( self::wc_get_subscription_product_id( $subscription ) );
			$args = array(
		        'attribute_subscription-type' => 'normal'
		    );
		    $product_variation = $product->get_matching_variation($args);
			$product = wc_get_product($product_variation); 
			$period = WC_Subscriptions_Product::get_period( $product );
		    $interval = WC_Subscriptions_Product::get_interval( $product );

			$regular_subscription = wcs_create_subscription( array(
				'start_date'       => $subscription->get_date('end','site'),
				'order_id'         => wcs_get_objects_property( $order, 'id' ),
				'customer_id'      => $order->get_user_id(),
				'billing_period'   => $period,
				'billing_interval' => $interval,
				'customer_note'    => wcs_get_objects_property( $order, 'customer_note' ),
			) );

			$item_id = $regular_subscription->add_product(
				$product,
				1,
				array(
					'variation' => ( method_exists( $product, 'get_variation_attributes' ) ) ? $product->get_variation_attributes() : array(),
					'totals'    => array(
						'subtotal'     => $product->get_price(),
						'subtotal_tax' => 0,
						'total'        => $product->get_price(),
						'tax'          => 0,
						'tax_data'     => array( 'subtotal' => array(), 'total' => array() ),
					),
				)
			);
			$regular_subscription->update_dates( array(
				'end'  => 0,
			) );
			// Set the recurring totals on the subscription
			$regular_subscription->set_total( 0, 'tax' );
			$regular_subscription->set_total( $product->get_price(), 'total' );
			$subscription->add_order_note( __( 'Pending subscription created.', 'woocommerce-subscriptions' ) );
		}

		public function wc_process_subscription_data($subscription, $posted_data){
			return $subscription;
		}

		public function wc_is_duplicate_site($is_duplicate){
			return false;
		}


	}
}

return new WC_Subscriptions_Settings();
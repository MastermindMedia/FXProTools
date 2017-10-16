<?php
if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('WC_Subscriptions_Settings')){

	class WC_Subscriptions_Settings {
		
		public function __construct()
		{

			add_filter('woocommerce_subscriptions_is_duplicate_site', array($this, 'wc_is_duplicate_site'), 10, 1);
			add_filter('woocommerce_data_get_total', array($this, 'wc_override_first_renewal_total'), 15, 2);
			add_action('woocommerce_scheduled_subscription_expiration', array($this, 'wc_scheduled_subscription_expiration'), 10, 1);
			//add_action('woocommerce_checkout_subscription_created', array($this, 'wc_force_automatic_renewal'), 10, 3);
			
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
		    	exit;

		    } else{	
		    	echo 'not trial';
		    	exit;
		    }
		   
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
			try{
				$address = $old_subscription->get_address('billing');
				$product = wc_get_product( self::wc_get_subscription_product_id( $old_subscription ) );
				$args = array(
			        'attribute_subscription-type' => 'normal'
			    );
			    $product_variation = $product->get_matching_variation($args);
				$product = wc_get_product($product_variation); 

				//create parent order
			    $order = $old_subscription->get_parent();

			    echo 'created parent order';
			    dd($order);
			   
			    //create the subscription
			    $period = WC_Subscriptions_Product::get_period( $product );
			    $interval = WC_Subscriptions_Product::get_interval( $product );

				$sub = wcs_create_subscription( array(
					'order_id'         => wcs_get_objects_property( $order, 'id' ),
					'customer_id'      => $order->get_user_id(),
					'billing_period'   => $period,
					'billing_interval' => $interval,
					'customer_note'    => wcs_get_objects_property( $order, 'customer_note' ),
				) );


				$order_args = array(
					'totals'    => array(
						'subtotal'     => $product->get_sign_up_fee() + $product->get_price(),
						'subtotal_tax' => 0,
						'total'        => $product->get_sign_up_fee() + $product->get_price(),
						'tax'          => 0,
						'tax_data'     => array( 'subtotal' => array(), 'total' => array() ),
					),
				);

				echo 'args';
				dd($order_args);

				$item_id = $sub->add_product( $product, 1, $order_args);
	   			$sub->set_address( $address, 'billing' );
	   			$sub->calculate_totals();
	   			$sub->set_payment_method( wc_get_payment_gateway_by_order( $order ) );
				$sub->save();

	   			WC_Subscriptions_Manager::activate_subscriptions_for_order($order);
				
				echo 'created subscription';
	   			dd($sub);

	   			$renewal_order = wcs_create_renewal_order($sub);
	   			$renewal_order->set_payment_method( wc_get_payment_gateway_by_order( $order ) ); 
	   			$renewal_order->set_requires_manual_renewal( false );
	   			$renewal_order->save();
	   			
	   			echo 'created renewal order';
	   			dd($renewal_order);
	   			WC_Subscriptions_Payment_Gateways::gateway_scheduled_subscription_payment($sub->get_id());

	    		return $sub;
	    	}
	    	catch( Exception $e){
	    		dd($e);
	    		exit;
	    	}
		}

		public function wc_force_automatic_renewal( $subscription, $order, $recurring_cart = '' ){
			$subscription->set_requires_manual_renewal( false );
		}

		public function wc_is_duplicate_site($is_duplicate){
			return false;
		}

		public function wc_override_first_renewal_total($value, $data){
			dd($value); dd($data); exit;
		}


	}
}

return new WC_Subscriptions_Settings();
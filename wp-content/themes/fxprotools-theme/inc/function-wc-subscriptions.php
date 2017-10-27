<?php
/**
 * ----------------
 * Woocommerce Subscription  Settings
 * ----------------
 * Hooks and Filters
 */

if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('WC_Subscriptions_Settings')){

	class WC_Subscriptions_Settings {
		
		public function __construct()
		{
			add_filter('woocommerce_subscriptions_is_duplicate_site', array($this, 'wc_is_duplicate_site'), 10, 1);
			//add_action('woocommerce_scheduled_subscription_expiration', array($this, 'wc_scheduled_subscription_expiration'), 10, 1);
			add_filter('fx_before_gateway_renewal_order', array($this, 'wc_apply_signup_fee_on_renewal'), 10, 1);
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
		    } else{	
		    	
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

			$item_id = $sub->add_product( $product, 1, $order_args);
   			$sub->set_address( $address, 'billing' );
   			$sub->calculate_totals();
   			$sub->set_payment_method( wc_get_payment_gateway_by_order( $order ) );
			$sub->save();

   			WC_Subscriptions_Manager::activate_subscriptions_for_order($order);
			
   			$renewal_order = wcs_create_renewal_order($sub);
   			$renewal_order->set_payment_method( wc_get_payment_gateway_by_order( $order ) ); 
   			$renewal_order->set_requires_manual_renewal( false );
   			$renewal_order->save();
   			WC_Subscriptions_Payment_Gateways::gateway_scheduled_subscription_payment($sub->get_id());

    		return $sub;
		}

		public function wc_is_duplicate_site($is_duplicate){
			return false;
		}


		/**
		 * [Apply signup fee on first renweal from trial product]
		 * @param  WC_Subscription
		 * @return WC_Subscription
		 */
		public function wc_apply_signup_fee_on_renewal($renewal_order){

			$user_id =  $renewal_order->get_customer_id();
			$referrals = get_user_active_referrals($user_id);
			$has_paid_signup_fee = get_user_meta( $user_id , '_has_paid_signup_fee', true ); 
			$subscriptions = wcs_get_users_subscriptions( $user_id );

			//if user has 3 active referrals, modify renewal to be free
			if( count($referrals) >= 3){

				$renewal_order->remove_order_items();
				$renewal_order->add_order_note('Free Renewal via Referral Program');

				foreach($subscriptions as $s){

					if( $s->has_status('on-hold') ){
						$items = $s->get_items();

						foreach($items as $key => $item){
							$subscription_type = wc_get_order_item_meta($key, 'subscription-type', true);

						    if( isset($subscription_type) ) {
								$product = wc_get_product( $item->get_product_id() );

								if($product->get_id() == 48){ //if business product add ibo kit instead
									$ibo_kit =  wc_get_product(2871);
									$renewal_order->add_product($ibo_kit, 1);
									$renewal_order->add_order_note('Add IBO Kit for Distributor Package');
								}
							}
						}
					}
				}
			}

			//add signup fee to renewal
			if( !$has_paid_signup_fee ){

				foreach($subscriptions as $s){

					if( $s->has_status('on-hold') ){
						$items = $s->get_items();

					    foreach($items as $key => $item){
					    	$subscription_type = wc_get_order_item_meta($key, 'subscription-type', true);
					    	if($subscription_type == 'trial'){
								$product = wc_get_product( $item->get_product_id() );
								$args = array(
							        'attribute_subscription-type' => 'normal'
							    );
							    $product_variation = $product->get_matching_variation($args);
								$product = wc_get_product($product_variation);
								$signup_fee = $product->get_sign_up_fee();
								$payment_total = $signup_fee + $renewal_order->get_total();

								$item = new WC_Order_Item_Fee();
								$item->set_props( array(
										'name'      => 'Signup Fee',
										'tax_class' => 0,
										'total'     => $signup_fee,
										'total_tax' => 0,
										'taxes'     => array(
										'total' => 0,
									),
									'order_id'  => $renewal_order->get_id(),
							    ) );
								$item->save();
								$renewal_order->add_item($item);
								$renewal_order->add_order_note('Added Sign Up Fee');
								add_user_meta( $user_id , '_has_paid_signup_fee', 1); 

								
					    	}
					    }
					}
				}
			}

			$renewal_order->calculate_totals();
			return $renewal_order;

		}

		



	}
}

return new WC_Subscriptions_Settings();
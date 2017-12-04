<?php
/*
eps_commerce_purchase_complete
eps_commerce_joining_package_purchase_complete
eps_commerce_distributor_kit_purchase_complete
eps_affiliates_become_distributor_from_customer
 */

function eps_subscription_order_completed( $subscription ) { 

    $items = $subscription->get_items();

	foreach($items as $key => $item){
		$pv = rwmb_meta('personal_volume', '',  $item->get_product_id());
	}

	$renewal = $subscription->get_last_order('renewal');

	if( isset($renewal) ){
		 $args = array(	
			'uid' => $subscription->get_customer_id(),
			'order_id' => $renewal->get_id(),
			'amount_paid' => $renewal->get_total(),
			'afl_point' => $pv
		);

		error_log('Invoked : eps_commerce_purchase_complete ' . print_r($args, true) );
	    $result = apply_filters('eps_commerce_purchase_complete', $args);
	    error_log('Invoked : eps_commerce_purchase_complete ' . print_r($result, true) );
	}

   
   
}; 
         
add_action( 'woocommerce_subscription_renewal_payment_complete', 'eps_subscription_order_completed', 10, 1 ); 


function eps_distributor_kit_purchased( $subscription ) { 

    $items = $subscription->get_items();

	foreach($items as $key => $item){
		if( $item['product_id'] == 2871 || $item['product_id'] == '48'){
			$renewal = $subscription->get_last_order('renewal');

		    $args = array(	
				'uid' => $subscription->get_customer_id(),
				'order_id' => $renewal->get_id()
			);
			error_log('Invoked : eps_commerce_distributor_kit_purchase_complete ' . print_r($args, true) );
		    $result = apply_filters('eps_commerce_distributor_kit_purchase_complete', $args);
		   	error_log('Invoked : eps_commerce_distributor_kit_purchase_complete ' . print_r($result, true) );

		} else {
			error_log('Invoked : eps_commerce_distributor_kit_purchase_complete, NO IBO KIT');
		}
	}

	
   
}; 
         
add_action( 'woocommerce_subscription_renewal_payment_complete', 'eps_distributor_kit_purchased', 10, 1 ); 


function eps_switched_from_customer_distributor() { 
	if( is_user_logged_in() && is_user_fx_distributor() ){
		do_action('eps_affiliates_become_distributor_from_customer', get_current_user_id() );
		error_log('Invoked : eps_affiliates_become_distributor_from_customer');
	}
	
}; 
         
add_action( 'woocommerce_subscriptions_switch_completed', 'eps_switched_from_customer_distributor', 10, 1 ); 

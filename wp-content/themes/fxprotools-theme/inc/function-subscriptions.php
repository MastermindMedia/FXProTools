<?php
/**
 * ----------------
 * Subscription Related Functions
 * ----------------
 * Hooks and Filters
 */

function fx_customer_subscription_products()
{
	return array( 2699, 47 );
}

function fx_distributor_subscription_products()
{
	return array( 48 );
}

function is_user_fx_customer()
{
	$subscription_products = fx_customer_subscription_products();
	foreach($subscription_products as $s){
		if( wcs_user_has_subscription( '', $s, 'active') ){
			return true;
		}
	}
	return false;
}


function is_user_fx_distributor()
{
	$subscription_products = fx_distributor_subscription_products();
	foreach($subscription_products as $s){
		if( wcs_user_has_subscription( '', $s, 'active') ){
			return true;
		}
	}
	return false;
}

function user_has_autotrader()
{
	return wcs_user_has_subscription( '', 49, 'active');
}


function user_has_coaching()
{
	return wcs_user_has_subscription( '', 50, 'active');
}

function get_trial_end_date()
{
	$subscriptions = wcs_get_users_subscriptions();
	foreach($subscriptions as $s){
		if( $s->has_status('active') ){
			$items = $s->get_items();
		    foreach($items as $key => $item){
		    	$subscription_type = wc_get_order_item_meta($key, 'subscription-type', true);
		    	if($subscription_type == 'trial'){
					$subscription = wcs_get_subscription( $s->get_id() );
					return $subscription->get_date( 'end' );
		    	}
		    }
		}
	}
	return 0;
}


function get_recent_subscriptions ($limit = 15)
{
	$subscriptions = get_posts( array(
        'post_type' => 'shop_subscription',
        'post_status' => array( 'wc-processing', 'wc-completed', 'wc-expired', 'wc-on-hold' ),
        'numberposts' => $limit,
        'posts_per_page' => $limit
	) );
	$subscription_list = array();
	foreach($subscriptions as $s){
		$subscription_list[] = wc_get_order( $s->ID );
	}
	return $subscription_list;
}



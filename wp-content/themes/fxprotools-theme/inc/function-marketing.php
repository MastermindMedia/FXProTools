<?php
/**
 * -----------------------
 * Fxprotools - Custom functions for marketing pages
 * -----------------------
 * custom functions funnels, stats, contacts
 */

function get_funnels()
{
	$args = array(
		'posts_per_page'   => -1,
		'orderby'          => 'menu_order',
		'order'			   => 'ASC',
		'post_status'      => 'publish',
		'post_type'		   => 'fx_funnel',
	);
	return get_posts($args);
}

function property_occurence_count($array, $property, $value)
{
	$count = 0;
	foreach ($array as $object) {
		if ( preg_replace('{/$}', '', $object->{$property} ) == preg_replace('{/$}', '', $value ) ){
			$count++;
		}
	}
	return $count;
}

function get_unique_property_count($array, $property, $url)
{
	$count = 0;
	foreach($array as $object){
		if( preg_replace('{/$}', '', $object->url) == preg_replace('{/$}', '', $url) ){
			$value = $object->{$property};
			$occurrence = property_occurence_count($array, $property, $value);
			if($occurrence == 1) $count += 1;
		}
	}
	return $count;
}

function get_property_count($array, $property, $url)
{
	$count = 0;
	foreach($array as $object){
		if( preg_replace('{/$}', '', $object->url) == preg_replace('{/$}', '', $url) ){
			if( (int) $object->{$property} > 0) $count++;
		}
	}
	return $count;
}


function date_is_in_range($date_from, $date_to, $date)
{
	$start_ts = strtotime($date_from);
 	$end_ts = strtotime($date_to);
	$ts = strtotime($date);
 	return (($ts >= $start_ts) && ($ts <= $end_ts));
}

function get_funnel_stats($funnel_id, $date_filter = array())
{
	$visits = affiliate_wp()->visits->get_visits( array( 'affiliate_id' => affwp_get_affiliate_id( get_current_user_id()), 'order_by' => 'visit_id' ) );
	if( $date_filter ){
		foreach($visits as $key => $visit){
			 if( !date_is_in_range($date_filter['date_from'], $date_filter['date_to'], date("m/d/Y", strtotime($visit->date))) ) unset($visits[$key]);
		}
	}
	$funnel = array( 'cp_url' => rwmb_meta('capture_page_url', '', $funnel_id),
		 			 'lp_url' => rwmb_meta('landing_page_url', '', $funnel_id)
		 			);
	$cp_stats = array( 'page_views' => array('all' 	 => 0, 'unique' => 0),
					   'opt_ins' 	=> array('all' 	 => 0, 'rate' 	 => 0),
					   'sales' 		=> array('count' => 0, 'rate'	 => 0),
				);
	$lp_stats = array( 'page_views' => array('all' 	 => 0, 'unique' => 0),
					   'opt_ins' 	=> array('all' 	 => 0, 'rate' 	 => 0),
					   'sales' 		=> array('count' => 0, 'rate' 	 => 0),
				);
	$sales_stats = array( 'customer_sales' => 0, 'distributor_sales' => 0);

	//all
	$cp_stats['page_views']['all'] = property_occurence_count($visits, 'url',  $funnel['cp_url'] );
	$lp_stats['page_views']['all'] = property_occurence_count($visits, 'url', $funnel['lp_url'] );

	//unique
	$cp_stats['page_views']['unique'] = get_unique_property_count($visits, 'ip', $funnel['cp_url']);
	$lp_stats['page_views']['unique'] = get_unique_property_count($visits, 'ip', $funnel['lp_url']);

	//opt ins
	$funnel_id = trim( parse_url( rwmb_meta('capture_page_url', '', $funnel_id), PHP_URL_PATH ), '/');
	$search = FX_Sendgrid_Api::search_contacts('campaign', $funnel_id);
	$cp_stats['opt_ins']['all'] = $search->recipient_count;
	$cp_stats['opt_ins']['rate'] = $cp_stats['opt_ins']['all'] < 1 ? 0 :  round( $cp_stats['opt_ins']['all'] / $cp_stats['page_views']['all'] * 100, 2);

	//sales
	$cp_stats['sales']['count'] = get_property_count($visits, 'referral_id', $funnel['cp_url']);
	$cp_stats['sales']['rate'] = $cp_stats['sales']['count'] < 1 ? 0 :  round( $cp_stats['sales']['count'] / $cp_stats['page_views']['all'] * 100, 2);

	$lp_stats['sales']['count'] = get_property_count($visits, 'referral_id', $funnel['lp_url']);
	$lp_stats['sales']['rate'] = $lp_stats['sales']['count'] < 1 ? 0 :  round( $lp_stats['sales']['count'] / $lp_stats['page_views']['all'] * 100, 2);

	$stats = array( 'capture' => $cp_stats,
					'landing' => $lp_stats,
					'totals' => $sales_stats,
				);

	return $stats;
}


function get_user_referrals()
{
	if(get_current_user_id() > 0){
		$affiliate_id = affwp_get_affiliate_id( get_current_user_id() );
		$affiliate_referrals = affiliate_wp()->referrals->get_referrals( array(
			'number'       => -1,
			'affiliate_id' => $affiliate_id
		) );
		return $affiliate_referrals;
	}
}


function get_user_active_referrals()
{
	if(get_current_user_id() > 0){
		$affiliate_id = affwp_get_affiliate_id( get_current_user_id() );
		$affiliate_referrals = affiliate_wp()->referrals->get_referrals( array(
			'number'       => -1,
			'affiliate_id' => $affiliate_id
		) );
		
		$product_ids = array( 2920, 2927, 2930 );

		foreach($affiliate_referrals as $key => $referral){
			$order = wc_get_order( $referral->reference );
			$user_id = $order->get_user_id();
			$has_sub = false;

			foreach($product_ids as $product_id){
				if( wcs_user_has_subscription( $user_id, $product_id, 'active' ) ){
					$has_sub = true;
					break;
				}
			}

			if( !$has_sub ){
				unset($affiliate_referrals[$key]);
			}
		}

		return $affiliate_referrals;
	}
}

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
		if( rtrim($object->url, '/') == rtrim($url, '/') ){
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
		if( rtrim($object->url, '/') == rtrim($url, '/') ){
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

function get_funnel_stats($funnel_id, $date_filter = array(), $user_id = 0)
{
	$affiliate_id = $user_id > 0 ? affwp_get_affiliate_id( $user_id ) : current_user_can('administrator') ? 0 : affwp_get_affiliate_id( get_current_user_id() );
	
	$visits = get_funnel_visits( $affiliate_id );
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

	$sales_stats = array( 'customer_sales' => get_total_distributor_sales( $funnel, current_user_can('administrator') ? 0 : get_current_user_id() ), 'distributor_sales' => get_total_customer_sales( $funnel, current_user_can('administrator') ? 0 : get_current_user_id() ) );

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
	$cp_stats['opt_ins']['rate'] = ( $cp_stats['page_views']['all'] >= 1 && $cp_stats['opt_ins']['all'] >= 1) ? round( $cp_stats['opt_ins']['all'] / $cp_stats['page_views']['all'] * 100, 2) : 0;

	//sales
	$cp_stats['sales']['count'] = get_property_count($visits, 'referral_id', $funnel['cp_url']);
	$cp_stats['sales']['rate'] = ( $cp_stats['page_views']['all'] >= 1 && $cp_stats['sales']['count'] >= 1) ? round( $cp_stats['sales']['count'] / $cp_stats['page_views']['all'] * 100, 2) : 0;

	$lp_stats['sales']['count'] = get_property_count($visits, 'referral_id', $funnel['lp_url']);
	$lp_stats['sales']['rate'] = ( $lp_stats['page_views']['all'] >= 1 && $lp_stats['sales']['count'] >= 1) ? round( $lp_stats['sales']['count'] / $lp_stats['page_views']['all'] * 100, 2) : 0;

	$stats = array( 'capture' => $cp_stats,
					'landing' => $lp_stats,
					'totals' => $sales_stats,
				);

	return $stats;
}

function get_funnel_visits( $user_id ){
	global $wpdb;

	$affiliate_cond = '';
	if( $user_id > 0){
		$affiliate_id = affwp_get_affiliate_id( $user_id );
		$affiliate_cond = "WHERE affiliate_id = {$affiliate_id}";
	}

	$results = $wpdb->get_results($sql = "SELECT *
        FROM {$wpdb->prefix}affiliate_wp_visits as visits 
        {$affiliate_cond} 
    ");
    return $results;

}



function get_total_distributor_sales( $funnel, $user_id = 0 ){
	global $wpdb;
	
	$affiliate_cond = '';

	if( $user_id > 0){
		$affiliate_id = affwp_get_affiliate_id( $user_id );
		$affiliate_cond = "AND referrals.affiliate_id = {$affiliate_id}";
	}

	$visit_cond = '';

	if( is_array($funnel) ){
		$visit_cond = "AND (visits.url LIKE '%{$funnel['cp_url']}%' OR visits.url LIKE '%{$funnel['lp_url']}%')";
	}

    $results = $wpdb->get_results($sql = "SELECT COUNT(description) as sales_count
        FROM {$wpdb->prefix}affiliate_wp_referrals as referrals
        LEFT  JOIN {$wpdb->prefix}affiliate_wp_visits as visits on referrals.referral_id = visits.referral_id
        WHERE `description` LIKE \"%Business%\" {$visit_cond} {$affiliate_cond}
    ");

    return $results[0]->sales_count;
}

function get_total_customer_sales( $funnel, $user_id = 0 ){
	global $wpdb;
	$affiliate_cond = '';

	if( $user_id > 0){
		$affiliate_id = affwp_get_affiliate_id( $user_id );
		$affiliate_cond = "AND referrals.affiliate_id = {$affiliate_id}";
	}

	$visit_cond = '';

	if( is_array($funnel) ){
		$visit_cond = "AND (visits.url LIKE '%{$funnel['cp_url']}%' OR visits.url LIKE '%{$funnel['lp_url']}%')";
	}

    $results = $wpdb->get_results($sql = "SELECT COUNT(description) as sales_count
        FROM {$wpdb->prefix}affiliate_wp_referrals as referrals
        LEFT  JOIN {$wpdb->prefix}affiliate_wp_visits as visits on referrals.referral_id = visits.referral_id
        WHERE  (`description` LIKE \"%Signals%\" OR `description` LIKE \"%Professional%\") {$visit_cond} {$affiliate_cond}
    ");

    return $results[0]->sales_count;
}

function get_total_funnel_sales( $link_url, $user_id = 0 ){
	global $wpdb;
	$affiliate_cond = '';

	if( $user_id > 0){
		$affiliate_id = affwp_get_affiliate_id( $user_id );
		$affiliate_cond = "AND referrals.affiliate_id = {$affiliate_id}";
	}

	$visit_cond = "(visits.url LIKE '%{$link_url}%')";

    $results = $wpdb->get_results($sql = "SELECT COUNT(description) as sales_count
        FROM {$wpdb->prefix}affiliate_wp_referrals as referrals
        LEFT  JOIN {$wpdb->prefix}affiliate_wp_visits as visits on referrals.referral_id = visits.referral_id
        WHERE {$visit_cond} {$affiliate_cond} 
    ");


    return $results[0]->sales_count;
}

function get_highest_converting_funnel_link( $user_id = 0){
	$funnels = get_funnels();
	$link = '';
	$highest = 0;

	foreach ($funnels as $key => $post){

		$funnel = array( 
			'cp_url' => rwmb_meta('capture_page_url', '', $post->ID),
			'lp_url' => rwmb_meta('landing_page_url', '', $post->ID)
		);

		$cp_sales = get_total_funnel_sales( $funnel['cp_url'], $user_id);
		$lp_sales = get_total_funnel_sales( $funnel['lp_url'], $user_id);

		if( $cp_sales >= $highest){
			$highest = $cp_sales;
			$link = $funnel['cp_url'];
		} 

		if( $lp_sales >= $highest){
			$highest = $lp_sales;
			$link = $funnel['lp_url'];
		}
	} 

	return $link;
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


function get_user_active_referrals($user_id = 0)
{
	$user_id = ( $user_id > 0 ) ?  $user_id : get_current_user_id();

	$affiliate_id = affwp_get_affiliate_id( $user_id );
	$affiliate_referrals = affiliate_wp()->referrals->get_referrals( array(
		'number'       => -1,
		'affiliate_id' => $affiliate_id
	) );
	

	foreach($affiliate_referrals as $key => $referral){
		$order = wc_get_order( $referral->reference );
		$user_id = $order->get_user_id();

		if( !wcs_user_has_subscription( $user_id, '', 'active' ) ){
			unset($affiliate_referrals[$key]);
			continue;
		}
	}

	return $affiliate_referrals;
}

function get_admin_contacts($affiliate_ids)
{
	$referral_loop_count = 0;
	$contacts = array();
	foreach($affiliate_ids as $affiliate_id){
		$contacts[$referral_loop_count]['id'] = $affiliate_id;
		$contacts[$referral_loop_count]['username'] = get_the_author_meta('user_login', $affiliate_id);
		$contacts[$referral_loop_count]['fname'] = get_the_author_meta('first_name', $affiliate_id);
		$contacts[$referral_loop_count]['lname'] = get_the_author_meta('last_name', $affiliate_id);
		$contacts[$referral_loop_count]['email'] = get_the_author_meta('email', $affiliate_id);
		$contacts[$referral_loop_count]['date'] = random_checkout_time_elapsed(get_the_author_meta('user_registered',$affiliate_id,false));
		$contacts[$referral_loop_count]['avatar'] = get_avatar($affiliate_id);
		$referral_loop_count++;
	}

	return $contacts;
}

function get_user_contacts($referrals)
{
	$referral_loop_count = 0;
	$contacts = array();
	foreach($referrals as $referral){
		$order = wc_get_order( $referral->reference );
		$contacts[$referral_loop_count]['id'] = $order->get_user_id();
		$contacts[$referral_loop_count]['username'] = get_the_author_meta('user_login', $order->get_user_id());
		$contacts[$referral_loop_count]['fname'] = get_the_author_meta('first_name', $order->get_user_id());
		$contacts[$referral_loop_count]['lname'] = get_the_author_meta('last_name', $order->get_user_id());
		$contacts[$referral_loop_count]['email'] = get_the_author_meta('email', $order->get_user_id());
		$contacts[$referral_loop_count]['date'] = random_checkout_time_elapsed($order->get_date_paid());
		$contacts[$referral_loop_count]['avatar'] = get_avatar($order->get_user_id());
		$referral_loop_count++;
	}

	return $contacts;
}
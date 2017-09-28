<?php
/**
 * ----------------------------
 * Fxprotools - Cusom Functions
 * ----------------------------
 * All custom functions
 */

function get_courses_by_product_id($product_id)
{
	$courses_ids = get_post_meta($product_id , '_related_course'); 
	$courses     = array();
	if($courses_ids){
		foreach($courses_ids as $id){
			$courses[] = get_post($id[0]);
		}
	}
	return $courses;
}

function get_courses_by_category_id($category_id)
{
	$args = array(
			'posts_per_page'   => -1,
			'orderby'          => 'menu_order',
			'order'			   => 'ASC',
			'post_status'      => 'publish',
			'post_type'		   => 'sfwd-courses',
			'tax_query' => array(
			array(
				'taxonomy'    	 => 'ld_course_category',
				'field'  		 => 'term_id',
				'terms'			 => $category_id,
			),
		),
	);
	$courses = get_posts($args);
	return !$courses ? false : $courses;
}

function get_course_metadata($course_id)
{
	return get_post_meta( $course_id, '_sfwd-courses', true );
}

function get_course_price_by_id($course_id)
{
	$course_data = get_course_metadata($course_id);
	$price = $course_data['sfwd-courses_course_price'];
	return is_numeric($price) ? $price : 0;
}

function get_lessons_by_course_id($course_id)
{
	$orderby = learndash_get_setting( $course_id, 'course_lesson_orderby' );
	$order   = learndash_get_setting( $course_id, 'course_lesson_order' );
	$args = array(
			'posts_per_page'   => -1,
			'orderby'          => $orderby,
			'order'			   => $order,
			'post_status'      => 'publish',
			'post_type'		   => 'sfwd-lessons',
			'meta_query' => array(
			array(
				'key'     => 'course_id',
				'value'   => $course_id,
				'compare' => '=',
			),
		),
	);
	$lessons = get_posts($args);
	return !$lessons ? false : $lessons;
}

function get_user_progress()
{
	if(!is_user_logged_in()) return false;
	$current_user    = wp_get_current_user();
	$user_id         = $current_user->ID;
	$course_progress = get_user_meta( $user_id, '_sfwd-course_progress', true );
	return !$course_progress ? false : $course_progress;
}

function get_course_lesson_progress($course_id, $lesson_id)
{
	if(!$course_id || !$lesson_id) return false;
	$course_progress = get_user_progress();
	return $course_progress[$course_id]['lessons'][$lesson_id];
}

function get_lesson_parent_course($lesson_id)
{
	$course_id = get_post_meta($lesson_id , 'course_id',true); 
	$course = get_post($course_id);
	return !$course ? false : $course;
}

function get_course_category_children($course_cat_id)
{
	$children_ids = get_term_children($course_cat_id , 'ld_course_category');

	if( !empty($children_ids) ){
		$child_categories = get_terms( array(
		    'taxonomy'   => 'ld_course_category',
		    'include'    => $children_ids,
		    'hide_empty' => false,
		) ); 
		return !$child_categories ? false: $child_categories;
	} else{
		return false;
	}
}

function get_funnels()
{
	$args = array(
		'posts_per_page'   => -1,
		'orderby'          => 'menu_order',
		'order'			   => 'DESC',
		'post_status'      => 'publish',
		'post_type'		   => 'fx_funnel',
	);
	return get_posts($args);
}

function property_occurence_count($array, $property, $value){
	$count = 0;
	foreach ($array as $object) {
	    if ( preg_replace('{/$}', '', $object->{$property} ) == $value) $count++;
	}
	return $count;
}

function get_unique_property_count($array, $property, $url)
{
	$count = 0;
	foreach($array as $object){
		if($object->url == $url){
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
		if($object->url == $url){
			if($object->{$property} > 0) $count++;
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
	if(sizeof($date_filter) > 0){
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
	$cp_stats['page_views']['all'] = property_occurence_count($visits, 'url', preg_replace('{/$}', '', $funnel['cp_url']) );
	$lp_stats['page_views']['all'] = property_occurence_count($visits, 'url', preg_replace('{/$}', '', $funnel['lp_url']) );

	//unique
	$cp_stats['page_views']['unique'] = get_unique_property_count($visits, 'ip', $funnel['cp_url']);
	$lp_stats['page_views']['unique'] = get_unique_property_count($visits, 'ip', $funnel['lp_url']);

	//opt ins
	$cp_stats['opt_ins']['count'] = get_property_count($visits, 'referral_id', $funnel['cp_url']);
	$cp_stats['opt_ins']['rate'] = $cp_stats['opt_ins']['count'] < 1 ? 0 :  round( $cp_stats['opt_ins']['count'] / $cp_stats['page_views']['all'] * 100, 2);

	//sales
	$lp_stats['sales']['count'] = get_property_count($visits, 'referral_id', $funnel['lp_url']);
	$lp_stats['sales']['rate'] = $lp_stats['sales']['count'] < 1 ? 0 :  round( $lp_stats['sales']['count'] / $lp_stats['page_views']['all'] * 100, 2);
	
	$stats = array( 'capture' => $cp_stats,
					'landing' => $lp_stats,
					'totals' => $sales_stats,
				);

	return $stats;
}

function get_user_checklist()
{
	$checklist = get_user_meta(get_current_user_id(), '_onboard_checklist', true);
	return is_array($checklist) ? $checklist : ThemeSettings::register_user_checklist(get_current_user_id());
}

function get_checklist_next_step_url()
{
	$checklist = get_user_checklist();
	foreach($checklist as $key => $value){
		if( empty($value) ){
			switch($key){
				case 'verified_email': return home_url() . '/verify-email/';
				case 'verified_profile': return home_url() . '/my-account/';
				case 'scheduled_webinar': return home_url() . '/coaching/';
				case 'accessed_products': return home_url() . '/access-products/';
				case 'got_shirt': return home_url() . '/free-shirt/';
				case 'shared_video': return home_url() . '/share-video/';
				case 'referred_friend': return home_url() . '/refer-a-friend/';
			}
		}
	}
	return $url;
}

function resend_email_verification()
{
	if( get_current_user_id() > 0){
		ThemeSettings::send_email_verification(get_current_user_id());
	}
}

function verify_email_address($verification_code)
{
	if( get_current_user_id() > 0)
	{
		$user = get_user_by('id', get_current_user_id() );
		$secret = "fxprotools-";
		$hash = MD5( $secret . $user->data->user_email);
		if($hash == $verification_code)
		{
			$checklist = get_user_checklist();
			$checklist['verified_email'] = true;
			update_user_meta( get_current_user_id(), '_onboard_checklist', $checklist );
			return true;
		} else{
			return false;
		}
	} else {
		return false;
	}
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

function random_checkout_time_elapsed(  $full = false) 
{
    $now = new DateTime;
    $ago = new DateTime;
    $ago->modify("-" .  mt_rand(15, 3600) . " seconds"); 
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function is_lesson_progression_enabled($course_id) 
{
	$meta = get_post_meta( $course_id, '_sfwd-courses' );
	return empty( $meta[0]['sfwd-courses_course_disable_lesson_progression'] );
}

function forced_lesson_time()
{
	$timeval = learndash_forced_lesson_time();

	if ( ! empty( $timeval ) ) {
		$time_sections = explode( ' ', $timeval );
		$h = $m = $s = 0;

		foreach ( $time_sections as $k => $v ) {
			$value = trim( $v );

			if ( strpos( $value, 'h' ) ) {
				$h = intVal( $value );
			} else if ( strpos( $value, 'm' ) ) {
				$m = intVal( $value );
			} else if ( strpos( $value, 's' ) ) {
				$s = intVal( $value );
			}
		}

		$time = $h * 60 * 60 + $m * 60 + $s;

		if ( $time == 0 ) {
			$time = (int)$timeval;
		}
	}
	
	if ( !empty( $time ) ) {
		$button_disabled = " disabled='disabled' ";
		echo '<script>
				var learndash_forced_lesson_time = ' . $time . ' ;
				var learndash_timer_var = setInterval(function(){learndash_timer()},1000);
			</script>
			<style>
				input#learndash_mark_complete_button[disabled] {     color: #333;    background: #ccc;    border-color: #ccc;}
			</style>';
		return $button_disabled;
	} 
}

function get_trial_end_date(){
	$subscriptions = wcs_get_users_subscriptions();
	
	foreach($subscriptions as $s){
		$related_orders_ids = $s->get_related_orders();

		foreach ( $related_orders_ids as $order_id ) {
		    $order = new WC_Order( $order_id );
		    $items = $order->get_items();

		    foreach($items as $key => $item){
		    	$subscription_type = wc_get_order_item_meta($key, 'subscription-type', true);
		    	
		    	if($subscription_type == 'trial'){
					$subscription = wcs_get_subscription( $s->ID );
					return $subscription->get_date( 'end' );
		    	}
		    }
		}
	}

	return 0;

}

function is_user_fx_customer()
{
	$subscription_products = array( 2699, 47 );
	foreach($subscription_products as $s){
		if( wcs_user_has_subscription( '', $s, 'active') ){
			return true;
		} 
	}
	return false;  
}


function is_user_fx_distributor()
{
	$subscription_products = array( 48 );
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

function get_customer_orders($user_id){
	$order_statuses = array('wc-on-hold', 'wc-processing', 'wc-completed', 'wc-pending', 'wc-cancelled', 'wc-refunded', 'wc-failed');
	$customer_user_id = $user_id;

	$customer_orders=get_posts( array(
	        'meta_key' => '_customer_user',
	        'meta_value' => $customer_user_id,
	        'post_type' => 'shop_order', 
	        'post_status' => $order_statuses,
	        'numberposts' => -1
	) );

	return $customer_orders;
}
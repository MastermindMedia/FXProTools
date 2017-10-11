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

function get_trial_end_date()
{
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

function get_customer_orders($user_id)
{
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

function get_order_columns()
{
	$my_orders_columns = apply_filters( 'woocommerce_my_account_my_orders_columns', array(
		'order-number'  => __( 'Order', 'woocommerce' ),
		'order-date'    => __( 'Date', 'woocommerce' ),
		'order-status'  => __( 'Status', 'woocommerce' ),
		'order-total'   => __( 'Total', 'woocommerce' ),
		'order-actions' => '&nbsp;',
	) );
	return $my_orders_columns;
}

function get_purchased_items($user_id)
{
	$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
		'numberposts' => -1,
		'meta_key'    => '_customer_user',
		'meta_value'  => $user_id,
		'post_type'   => wc_get_order_types( 'view-orders' ),
		'post_status' => array_keys( wc_get_order_statuses() ),
	) ) );
	return $customer_orders;
}

function get_query_string()
{
	$string = '';
	$counter = 1;
	foreach($_GET as $key => $val){
		if($counter == 1){
			echo '?' . $key . '=' . $val;
		}else{
			echo '&' . $key . '=' . $val;
		}
		$counter++;
	}
	return $string;
}

/* -------------------------
	Actions and Filters
 --------------------------*/

add_action('wp_ajax_nopriv_lms_lesson_complete', 'lms_lesson_complete');
add_action('wp_ajax_lms_lesson_complete', 'lms_lesson_complete');
function lms_lesson_complete()
{
	$user_id = get_current_user_id();
	$lesson_id = $_POST['lesson_id'];

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) { 
		echo learndash_is_lesson_complete( $user_id , $lesson_id );
	}
	wp_die();
}

add_action('wp', 'enforce_page_access');
function enforce_page_access()
{
	global $post;
	if( !isset($post) ) return;
	$slug = $post->post_name;
	$guest_allowed_post_type = array( 'product' );
	$guest_allowed_pages = array( 'login', 'forgot-password', 'verify-email', 'funnels', 'f1', 'f2', 'f3', 'f4', 'lp1', 'lp2', 'lp3', 'lp4' );

	if( is_user_logged_in() ) return 0;
	if( !is_product() && !is_cart() && !is_checkout() && !is_shop() && !is_404() && !is_front_page() ) {
		if( !in_array($slug, $guest_allowed_pages) ){
			wp_redirect( home_url() . '/login');
			exit;
		}
	}
}

add_filter('login_redirect', 'customer_login_redirect');
function customer_login_redirect( $redirect_to, $request = '', $user = '' ){
    return home_url('dashboard');
}

add_action('init', 'course_category_rewrite');
function course_category_rewrite()
{
	add_rewrite_rule('course-category/([^/]*)/?','index.php?category_slug=$matches[1]&course_category=1','top');
}

add_action('template_redirect', 'course_category_template');
function course_category_template()
{
    if ( get_query_var( 'category_slug' ) ) {
        add_filter( 'template_include', function() {
            return get_template_directory() . '/sfwd-course-category.php';
        });
    }
}

add_filter('query_vars', 'course_category_vars');
function course_category_vars( $vars )
{
    $vars[] = 'course_category';
    $vars[] = 'category_slug';
    return $vars;
}

add_action('user_register', 'register_user_checklist');
function register_user_checklist($user_id)
{
	$checklist = array(
		'verified_email' 	=> false, 
		'verified_profile'	=> false,
		'scheduled_webinar'	=> false,
		'accessed_products' => false,
		'got_shirt'			=> false,
		'shared_video'		=> false,
		'referred_friend'	=> false,
	);
	add_user_meta( $user_id, '_onboard_checklist', $checklist);
}

add_action('user_register', 'send_email_verification');
function send_email_verification($user_id)
{
	$user = get_user_by('id', $user_id);
	$secret = "fxprotools-";
	$hash = MD5( $secret . $user->data->user_email);
	$to =  $user->data->user_email;
	$subject = 'Please verify your Email Address';
	$message = "Click <a href='" . home_url() . '/verify-email/?code=' . $hash . "' target='_blank'>here</a> to verify your email address.";
	$headers = array('Content-Type: text/html; charset=UTF-8');
	wp_mail( $to, $subject, $message, $headers );
}

add_action('user_register', 'register_affiliate');
function register_affiliate($user_id)
{
	$data = array('user_id' => $user_id, 'notes' => 'affiliate added via fxprotools');
	$affiliate_id = affwp_add_affiliate($data);
}

add_action('affwp_notify_on_approval', 'disable_affiliate_welcome_email');
function disable_affiliate_welcome_email()
{
	return false;
}

add_action('wp', 'track_user_history');
function track_user_history()
{
	//delete_user_meta(get_current_user_id(), "track_user_history");
    $track_user_history = get_user_meta( get_current_user_id(), "track_user_history" )[0];
    if(!$track_user_history){
    	$track_user_history = array();
    }
    $link = '<a href="'. get_the_permalink() .'">' . get_the_permalink() . '</a>';
    if($_POST['user_login']){
    	$link = $link . " " . get_the_author_meta('first_name', get_current_user_id()) . " " . get_the_author_meta('last_name', get_current_user_id()) . " changed his username to " . $_POST['user_login'];
    }
    $data = array(
    	'time' => date("Y-m-d h:i:sa"),
    	'link' => $link,
    	'title' => get_the_title()
    );
    array_push($track_user_history, $data);
	update_user_meta(get_current_user_id(), 'track_user_history', $track_user_history);
}

add_action( 'show_user_profile', 'add_extra_profile_fields' );
add_action( 'edit_user_profile', 'add_extra_profile_fields' );
function add_extra_profile_fields( $user ) { ?>
	<h3>Extra profile information</h3>
	<table class="form-table">
		<tr>
			<th><label for="user_sms_subs">SMS/Text Messaging</label></th>
			<td>
				<select id="user_sms_subs" name="user_sms_subs">
					<option value="no" <?php if(get_the_author_meta( 'user_sms_subs', $user->ID ) == "no"){echo 'selected';} ?>>no</option>
					<option value="yes" <?php if(get_the_author_meta( 'user_sms_subs', $user->ID ) == "yes"){echo 'selected';} ?>>yes</option>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="user_email_subs">Email Updates</label></th>
			<td>
				<select id="user_email_subs" name="user_email_subs">
					<option value="no" <?php if(get_the_author_meta( 'user_email_subs', $user->ID ) == "no"){echo 'selected';} ?>>no</option>
					<option value="yes" <?php if(get_the_author_meta( 'user_email_subs', $user->ID ) == "yes"){echo 'selected';} ?>>yes</option>
				</select>
			</td>
		</tr>
	</table>
<?php }

add_action( 'personal_options_update', 'save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_profile_fields' );
function save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	update_usermeta( $user_id, 'user_sms_subs', $_POST['user_sms_subs'] );
	update_usermeta( $user_id, 'user_email_subs', $_POST['user_email_subs'] );
}

add_action("wp_ajax_check_username", "check_username");
add_action("wp_ajax_nopriv_check_username", "check_username");
function check_username()
{
	$new_username = $_REQUEST['new_username'];
	if (validate_username($new_username) && !username_exists($new_username))
	{
		if(strlen($new_username) <= 30 && strlen($new_username) >= 3 && preg_match("/^([[:alnum:]])*$/", $new_username))
		{
			echo "1";
		}
		else
		{
			echo "2";
		}
	}
	else{
		if(!strlen($new_username) <= 30 || !strlen($new_username) >= 3 || !preg_match("/^([[:alnum:]])*$/", $new_username))
		{
			echo "2";
		}
		else
		{
			echo "0";
		}		
	}

	wp_die();
}
function sess_start() {
    if (!session_id())
    session_start();
}
add_action('init','sess_start');
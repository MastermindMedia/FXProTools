<?php
/**
 * ----------------------------
 * Fxprotools - Cusom Functions
 * ----------------------------
 * All custom functions
 */

// add_action('init', 'check_authentication');
// function check_authentication(){
// 	if(!is_user_logged_in()){
// 		$url = get_site_url() . '/login/';
// 		// Force using of js to avoid too many redirect and header sent errors
// 		// echo "<script>location.href = {$url};</script>";
// 	}
// }

add_action('init', 'block_users_wp');
function block_users_wp(){
	if(is_admin() && ! current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX)){
		wp_redirect(home_url());
		exit;
	}
}

function get_courses_by_product_id($product_id){
	$courses_ids = get_post_meta($product_id , '_related_course'); 
	$courses     = array();
	if($courses_ids){
		foreach($courses_ids as $id){
			$courses[] = get_post($id[0]);
		}
	}
	return $courses;
}

function get_courses_by_category_id($category_id){
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

function get_course_metadata($course_id){
	return get_post_meta( $course_id, '_sfwd-courses', true );
}

function get_course_price_by_id($course_id){
	$course_data = get_course_metadata($course_id);
	$price = $course_data['sfwd-courses_course_price'];
	return is_numeric($price) ? $price : 0;
}

function get_lessons_by_course_id($course_id){
	$args = array(
			'posts_per_page'   => -1,
			'orderby'          => 'menu_order',
			'order'			   => 'ASC',
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

function get_user_progress(){
	if(!is_user_logged_in()) return false;
	$current_user    = wp_get_current_user();
	$user_id         = $current_user->ID;
	$course_progress = get_user_meta( $user_id, '_sfwd-course_progress', true );
	return !$course_progress ? false : $course_progress;
}

function get_course_lesson_progress($course_id, $lesson_id){
	if(!$course_id || !$lesson_id) return false;
	$course_progress = get_user_progress();
	return $course_progress[$course_id]['lessons'][$lesson_id];
}

function get_lesson_parent_course($lesson_id){
	$course_id = get_post_meta($lesson_id , 'course_id',true); 
	$course = get_post($course_id);
	return !$course ? false : $course;
}

function get_course_category_children($course_cat_id){
	$children_ids = get_term_children($course_cat_id , 'ld_course_category');

	if( !empty($children_ids) ){
		$child_categories = get_terms( array(
		    'taxonomy'   => 'ld_course_category',
		    'include'    => $children_ids,
		    'hide_empty' => false,
		) ); 
		return !$child_categories ? false: $child_categories;
	}
	else{
		return false;
	}
}

function get_funnels(){
	$args = array(
		'posts_per_page'   => -1,
		'orderby'          => 'menu_order',
		'order'			   => 'ASC',
		'post_status'      => 'publish',
		'post_type'		   => 'fx_funnel',
	);
	return get_posts($args);
}

function get_funnel_stats($funnel_id){
	$stats = get_post_meta($funnel_id , 'course_id', true); 
	$sample_stats = array( 'capture' => 
							array( 'page_views' => array('all' 	 => 88, 'unique' => 61),
								   'opt_ins' 	=> array('all' 	 => 21, 'rate' 	 => 34.4),
								   'sales' 		=> array('count' => 21, 'rate'	 => 34.4),
							),
							'landing' => 
							array( 'page_views' => array('all' 	 => 88, 'unique' => 61),
								   'opt_ins' 	=> array('all' 	 => '', 'rate' 	 => ''),
								   'sales' 		=> array('count' => '', 'rate' 	 => ''),
							),
							'totals' =>
							array( 'customer_sales' => 10, 'distributor_sales' => 11),
					);
	return !$stats ? $sample_stats : $course;
}

function get_user_checklist(){
	$checklist = get_user_meta(get_current_user_id(), '_onboard_checklist', true);

	if( is_array($checklist) ){
		return $checklist;
	}

	else{
		ThemeSettings::register_user_checklist(get_current_user_id());
	}
}

function get_checklist_next_step_url(){
	$checklist = get_user_checklist();
	$url = '#';

	foreach($checklist as $key => $value){
		if( empty($value) ){
			switch($key){
				case 0:
					$url = home_url() . '/verify-email/';
					break;
				case 1:
					$url = home_url() . '/profile/';
					break;
				case 2:
					$url = home_url() . '/coaching/';
					break;
				case 3:
					$url = home_url() . '/access-products/';
					break;
				case 4:
					$url = home_url() . '/free-shirt/';
					break;
				case 5:
					$url = home_url() . '/share-video/';
					break;
				case 6:
					$url = home_url() . '/refer-a-friend/';
					break;
			}
		}
	}

	return $url;
}
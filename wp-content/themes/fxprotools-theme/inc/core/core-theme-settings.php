<?php
/**
 * --------------
 * Theme Settings
 * --------------
 * Theme related settings
 */

if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('ThemeSettings')){

	class ThemeSettings {
		
		public function __construct()
		{

			add_action('wp_enqueue_scripts', array($this, 'enqueue_theme_assets'));
			add_action('wp', array($this, 'enforce_page_access'));
			add_filter('login_redirect', array($this, 'customer_login_redirect'));
			add_action('init', array($this, 'course_category_rewrite'));
			add_action('template_redirect',  array($this, 'course_category_template'));
			add_filter('query_vars',  array($this,'course_category_vars'));
			add_action('user_register', array($this, 'register_user_checklist'));
			add_action('user_register', array($this, 'send_email_verification'));
			add_action('user_register', array($this, 'register_affiliate'));
			add_action('affwp_notify_on_approval', array($this, 'disable_affiliate_welcome_email'));
			add_action('wp', array($this, 'track_user_history'));
			
		}

		public function enqueue_theme_assets()
		{
			global $theme_version;
			// Disable loading of jquery on wordpress core
			if(!is_admin()){				
				wp_deregister_script('jquery'); 
				wp_deregister_script('wp-embed');
			}
			// Styles - Core
			wp_enqueue_style('style-bootstrap', get_template_directory_uri().'/vendors/bootstrap-3.3.7/css/bootstrap.min.css', $theme_version);
			wp_enqueue_style('style-fontawesome', get_template_directory_uri().'/vendors/font-awesome-4.7.0/css/font-awesome.min.css', $theme_version);
			wp_enqueue_style('style-boostrap-datepicker', get_template_directory_uri().'/vendors/boostrap-datepicker-1.7.1/css/bootstrap-datepicker.min.css', $theme_version);
			wp_enqueue_style('style-noty', get_template_directory_uri().'/vendors/noty-3.1.1/css/noty.css', $theme_version);
			// Styles - Custom
			wp_enqueue_style('theme-style', get_template_directory_uri().'/assets/css/theme.css', $theme_version);
			// Scripts - Core
			wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/vendors/jquery-3.2.1/jquery-3.2.1.min.js', $theme_version);
			wp_enqueue_script('script-bootstrap', get_stylesheet_directory_uri().'/vendors/bootstrap-3.3.7/js/bootstrap.min.js', $theme_version);
			wp_enqueue_script('script-bootstrap-datepicker', get_stylesheet_directory_uri().'/vendors/boostrap-datepicker-1.7.1/js/bootstrap-datepicker.min.js', $theme_version);
			wp_enqueue_script('script-clipboardjs', get_stylesheet_directory_uri().'/vendors/clipboard-js-1.7.1/js/clipboard.min.js', $theme_version);
			wp_enqueue_script('script-noty', get_stylesheet_directory_uri().'/vendors/noty-3.1.1/js/noty.min.js', $theme_version);
			wp_enqueue_script('script-jquery-cookie', get_stylesheet_directory_uri().'/vendors/jquery-cookie-1.4.1/jquery.cookie.js', $theme_version);
			// Scripts - Custom
			wp_enqueue_script('custom-js-script', get_bloginfo('template_url').'/assets/js/custom-script.js', $theme_version);
			wp_localize_script('custom-js-script', 'lms', array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
			));
			// Include custom scripts here

		}

		public function enforce_page_access()
		{
			global $post;
			if( !isset($post) ) return;
    		$slug = $post->post_name;
    		$guest_allowed_post_type = array( 'product' );
			$guest_allowed_pages = array( 'login', 'forgot-password', 'verify-email', 'funnels', 'f1', 'f2', 'f3', 'f4' );

			if( is_user_logged_in() ) return 0;
			if( !is_product() && !is_cart() && !is_checkout() && !is_shop() && !is_404() && !is_front_page() ) {
				if( !in_array($slug, $guest_allowed_pages) ){
					wp_redirect( home_url() . '/login');
					exit;
				}
			}
		}


		public function customer_login_redirect( $redirect_to, $request = '', $user = '' ){
		    return home_url('dashboard');
		}

		public function course_category_rewrite()
		{
			add_rewrite_rule('course-category/([^/]*)/?','index.php?category_slug=$matches[1]&course_category=1','top');
		}

		public function course_category_vars( $vars )
		{
		    $vars[] = 'course_category';
		    $vars[] = 'category_slug';
		    return $vars;
		}

		public function course_category_template()
		{
		    if ( get_query_var( 'category_slug' ) ) {
		        add_filter( 'template_include', function() {
		            return get_template_directory() . '/sfwd-course-category.php';
		        });
		    }
		}

		
		public function register_user_checklist($user_id)
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

		public function send_email_verification($user_id)
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

		public function register_affiliate($user_id)
		{
			$data = array('user_id' => $user_id, 'notes' => 'affiliate added via fxprotools');
			$affiliate_id = affwp_add_affiliate($data);
		}

		public function disable_affiliate_welcome_email()
		{
			return false;
		}

		
		
		function track_user_history()
		{
			//delete_user_meta(get_current_user_id(), "track_user_history");
		    $track_user_history = get_user_meta( get_current_user_id(), "track_user_history" )[0];
		    if(!$track_user_history){
		    	$track_user_history = array();
		    }
		    $data = array(
		    	'time' => date("Y-m-d h:i:sa"),
		    	'link' => get_the_permalink(),
		    	'title' => get_the_title()
		    );
		    array_push($track_user_history, $data);

			update_user_meta(get_current_user_id(), 'track_user_history', $track_user_history);
		}
	}
}

return new ThemeSettings();
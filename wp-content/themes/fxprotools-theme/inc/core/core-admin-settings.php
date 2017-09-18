<?php
/**
 * --------------
 * Admin Settings
 * --------------
 * Admin related settings
 */

if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('AdminSettings')){

	class AdminSettings {
		
		public function __construct()
		{
			add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
			add_action('login_enqueue_scripts',  array($this, 'enqueue_admin_assets'));
			add_filter('login_headerurl', array($this, 'login_logo_link'));
			add_action('admin_menu',  array($this, 'remove_admin_menus'), 99);
			add_action('admin_init', array($this, 'remove_dashboard_meta'));
			add_action( 'wp_ajax_nopriv_lms_previous_lesson_complete', 'lms_previous_lesson_complete' );
			add_action( 'wp_ajax_lms_previous_lesson_complete', 'lms_previous_lesson_complete' );
			// add_action('admin_menu', array($this, 'page_anet'));
		}

		// Admin assets
		public function enqueue_admin_assets()
		{
			global $theme_version;
			// wp_enqueue_style('admin-style', get_stylesheet_directory_uri().'/assets/css/admin.css', $theme_version);
		}

		// Change link of logo in login(Default is wordpress link)
		public function login_logo_link()
		{
			return get_bloginfo('url');
		}

		// Remove Admin Menus
		public function remove_admin_menus()
		{
			remove_menu_page('index.php');                  // Dashboard
			remove_menu_page('jetpack');                    // Jetpack
			remove_menu_page('edit.php');                   // Posts
			remove_menu_page('upload.php');                 // Media
			// remove_menu_page('edit.php?post_type=page');    // Pages
			remove_menu_page('edit-comments.php');          // Comments
			// remove_menu_page('themes.php');                 // Appearance
			// remove_menu_page('plugins.php');                // Plugins
			// remove_menu_page('users.php');                  // Users
			remove_menu_page('tools.php');                  // Tools
			// remove_menu_page('options-general.php');        // Settings
		}

		// Remove Dashboard Widgets
		public function remove_dashboard_meta()
		{
			if (!current_user_can( 'manage_options')){
				remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
				remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
				remove_meta_box('dashboard_primary', 'dashboard', 'normal');
				remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
				remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
				remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
				remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
				remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
				remove_meta_box('dashboard_activity', 'dashboard', 'normal');
			}
		}

		// Custom page - Authorize.net CIM and Subscriptions Manager
		// public function page_anet()
		// {
		// 	$page_settings = add_menu_page(
		// 		'ANET - CISM',
		// 		'ANET - CISM',
		// 		'manage_options',
		// 		'anet-management',
		// 		'page_content',
		// 		'dashicons-exerpt-view',
		// 		9
		// 	);
		// 	add_action('load-' . $page_settings, 'page_assets');

		// 	function page_assets(){	
		// 		// CSS
		// 		wp_enqueue_style('css-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array(), '', 'all');
		// 		wp_enqueue_style('css-datatable', 'https://cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.css', array(), '', 'all');
		// 		wp_enqueue_style('css-custom', get_stylesheet_directory_uri() . '/assets/css/admin-anet.css', array(), '', 'all');
		// 		// JS
		// 		wp_enqueue_script('js-jquery', 'https://code.jquery.com/jquery-2.2.4.min.js', FALSE, '', TRUE);
		// 		wp_enqueue_script('js-chosen', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js', FALSE, '', TRUE);
		// 		wp_enqueue_script('js-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', FALSE, '', TRUE);
		// 		wp_enqueue_script('js-datatable', 'https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js', FALSE, '', TRUE);
		// 		wp_enqueue_script('js-admin', get_stylesheet_directory_uri() . '/assets/js/admin-anet.js', FALSE, '', TRUE);
				
		// 		// Declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
		// 		wp_localize_script('js-admin', 'wpAjax', array(
		// 			'ajaxUrl'   => admin_url('admin-ajax.php'),
		// 			'ajaxNonce' => wp_create_nonce('wp_nonce')
		// 		));
					
		// 	}

		// 	function page_content(){
		// 		get_template_part('inc/templates/template-admin-anet');
		// 	}
		// }



		function lms_previous_lesson_complete() {
			$user_id = get_current_user_id();
			$lesson_id = $_POST['lesson_id'];
			
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) { 
				update_post_meta( $_POST['post_id'], 'post_love', $love );
				echo $love;
			}
			die();
		}

	}

}

return new AdminSettings();
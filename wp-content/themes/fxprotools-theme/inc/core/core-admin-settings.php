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

			add_filter('rwmb_meta_boxes',  array($this, 'initialize_meta_boxes'));
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

		public function initialize_meta_boxes( $meta_boxes ) {
			$prefix = '';

			$meta_boxes[] = array(
				'id' => 'course_custom_fields',
				'title' => esc_html__( 'Course Custom Fields', 'fxprotools' ),
				'post_types' => array( 'sfwd-courses' ),
				'context' => 'normal',
				'priority' => 'high',
				'autosave' => false,
				'fields' => array(
					array(
						'id' => $prefix . 'short_description',
						'type' => 'textarea',
						'name' => esc_html__( 'Short Description', 'fxprotools' ),
					),
					array(
						'id' => $prefix . 'subtitle',
						'type' => 'text',
						'name' => esc_html__( 'Subtitle', 'fxprotools' ),
					),
				),
			);

			$meta_boxes[] = array(
				'id' => 'product_custom_fields',
				'title' => esc_html__( 'Product Custom Fields', 'fxprotools' ),
				'post_types' => array( 'product' ),
				'context' => 'normal',
				'priority' => 'high',
				'autosave' => false,
				'fields' => array(
					array(
						'id' => $prefix . 'subtitle',
						'type' => 'text',
						'placeholder' => 'Short Description',
						'name' => esc_html__( 'Short Description', 'fxprotools' ),
					),
				),
			);

			$meta_boxes[] = array(
				'id' => 'capture_page_fields',
				'title' => esc_html__( 'Capture Page Fields', 'fxprotools' ),
				'post_types' => array( 'fx_funnel' ),
				'context' => 'advanced',
				'priority' => 'high',
				'autosave' => false,
				'fields' => array(
					array(
						'id' => $prefix . 'capture_page_title',
						'type' => 'text',
						'name' => esc_html__( 'Capture Page Title', 'fxprotools' ),
						'size' => 80,
					),
					array(
						'id' => $prefix . 'capture_sub_title',
						'type' => 'text',
						'name' => esc_html__( 'Capture Sub Title', 'fxprotools' ),
						'size' => 80,
					),
					array(
						'id' => $prefix . 'capture_page_url',
						'type' => 'text',
						'name' => esc_html__( 'Funnel URL', 'fxprotools' ),
						'size' => 80,
					),
					array(
						'id' => $prefix . 'capture_page_thumbnail',
						'type' => 'image_advanced',
						'name' => esc_html__( 'Cature Page Thumbnail', 'fxprotools' ),
						'force_delete' => false,
						'max_file_uploads' => '1',
					),
				),
			);

			$meta_boxes[] = array(
				'id' => 'landing_page_fields',
				'title' => esc_html__( 'Landing Page Fields', 'fxprotools' ),
				'post_types' => array( 'fx_funnel' ),
				'context' => 'advanced',
				'priority' => 'high',
				'autosave' => false,
				'fields' => array(
					array(
						'id' => $prefix . 'landing_page_title',
						'type' => 'text',
						'name' => esc_html__( 'Landing Page Title', 'fxprotools' ),
						'size' => 80,
					),
					array(
						'id' => $prefix . 'landing_sub_title',
						'type' => 'text',
						'name' => esc_html__( 'Landing Page Sub Title', 'fxprotools' ),
						'size' => 80,
					),
					array(
						'id' => $prefix . 'landing_page_url',
						'type' => 'text',
						'name' => esc_html__( 'Funnel URL', 'fxprotools' ),
						'size' => 80,
					),
					array(
						'id' => $prefix . 'landing_page_thumbnail',
						'type' => 'image_advanced',
						'name' => esc_html__( 'Landing Page Thumbnail', 'fxprotools' ),
						'force_delete' => false,
						'max_file_uploads' => '1',
					),
				),
			);

			$meta_boxes[] = array(
				'id' => 'webinar_custom_fields',
				'title' => esc_html__( 'Webinar Custom Fields', 'fxprotools' ),
				'post_types' => array( 'fx_webinar' ),
				'context' => 'advanced',
				'priority' => 'high',
				'autosave' => false,
				'fields' => array(
					array(
						'id' => $prefix . 'webinar_topic',
						'type' => 'wysiwyg',
						'name' => esc_html__( 'Topic', 'fxprotools' ),
					),
					array(
						'id' => $prefix . 'webinar_start_date',
						'type' => 'date',
						'name' => esc_html__( 'Start Date', 'fxprotools' ),
					),
					array(
						'id' => $prefix . 'webinar_start_time',
						'type' => 'time',
						'name' => esc_html__( 'Start Time', 'fxprotools' ),
					),
					array(
						'id' => $prefix . 'webinar_meeting_link',
						'type' => 'text',
						'name' => esc_html__( 'Meeting Link', 'fxprotools' ),
					),
				),
			);

			return $meta_boxes;
		}

	}

}

return new AdminSettings();
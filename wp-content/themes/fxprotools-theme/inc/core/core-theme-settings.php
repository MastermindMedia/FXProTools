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
			wp_enqueue_style('style-select2', get_template_directory_uri().'/vendors/select2-4.0.4/css/select2.min.css', $theme_version);
			// Styles - Custom
			wp_enqueue_style('theme-style', get_template_directory_uri().'/assets/css/theme/theme.css', $theme_version);

			// Scripts - Core
			wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/vendors/jquery-3.2.1/jquery-3.2.1.min.js', $theme_version);
			wp_enqueue_script('script-bootstrap', get_stylesheet_directory_uri().'/vendors/bootstrap-3.3.7/js/bootstrap.min.js', $theme_version);
			wp_enqueue_script('script-bootstrap-datepicker', get_stylesheet_directory_uri().'/vendors/boostrap-datepicker-1.7.1/js/bootstrap-datepicker.min.js', $theme_version);
			wp_enqueue_script('script-clipboardjs', get_stylesheet_directory_uri().'/vendors/clipboard-js-1.7.1/js/clipboard.min.js', $theme_version);
			wp_enqueue_script('script-noty', get_stylesheet_directory_uri().'/vendors/noty-3.1.1/js/noty.min.js', $theme_version);
			wp_enqueue_script('script-jquery-cookie', get_stylesheet_directory_uri().'/vendors/jquery-cookie-1.4.1/jquery.cookie.js', $theme_version);
			wp_enqueue_script('script-moment', get_stylesheet_directory_uri().'/vendors/moment-2.19.1/moment.js', $theme_version);
			wp_enqueue_script('script-player', get_stylesheet_directory_uri().'/vendors/player-0.0.12/player.js', $theme_version);
			wp_enqueue_script('script-tinymce', get_stylesheet_directory_uri().'/vendors/tinymce-4.7.1/tinymce.min.js', $theme_version);
			wp_enqueue_script('script-select2', get_stylesheet_directory_uri().'/vendors/select2-4.0.4/js/select2.min.js', $theme_version);
			// Scripts - Custom
			// wp_enqueue_script('custom-js-script', get_bloginfo('template_url').'/assets/js/custom-script.js', $theme_version);
			// wp_enqueue_script('custom-js-sendgrid', get_bloginfo('template_url').'/assets/js/sendgrid.js', $theme_version);
			// wp_enqueue_script('custom-js-email', get_bloginfo('template_url').'/assets/js/email.js', $theme_version);
			wp_enqueue_script('theme-js', get_bloginfo('template_url').'/assets/js/theme/theme.js', $theme_version);
			wp_localize_script('theme-js', 'fx', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'login_url' => site_url( 'login' ),
				'logout_url' => wp_logout_url()
			));
		}
	}
}

return new ThemeSettings();

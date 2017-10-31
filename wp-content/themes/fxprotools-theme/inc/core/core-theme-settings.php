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
			wp_enqueue_style('style-bootstrap', get_template_directory_uri().'/node_modules/bootstrap/dist/css/bootstrap.min.css', $theme_version);
			wp_enqueue_style('style-fontawesome', get_template_directory_uri().'/node_modules/font-awesome/css/font-awesome.min.css', $theme_version);
			wp_enqueue_style('style-bootstrap-datepicker', get_template_directory_uri().'/node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', $theme_version);
			wp_enqueue_style('style-noty', get_template_directory_uri().'/node_modules/noty/lib/noty.css', $theme_version);
			wp_enqueue_style('style-select2', get_template_directory_uri().'/node_modules/select2/dist/css/select2.min.css', $theme_version);
			// Styles - Custom
			wp_enqueue_style('theme-style', get_template_directory_uri().'/assets/css/theme/theme.css', $theme_version);

			// Scripts - Core
			wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/node_modules/jquery/dist/jquery.min.js', $theme_version);
			wp_enqueue_script('script-bootstrap', get_stylesheet_directory_uri().'/node_modules/bootstrap/dist/js/bootstrap.min.js', array(), $theme_version, true);
			wp_enqueue_script('script-bootstrap-datepicker', get_stylesheet_directory_uri().'/node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', array(), $theme_version, true);
			wp_enqueue_script('script-clipboardjs', get_stylesheet_directory_uri().'/node_modules/clipboard/dist/clipboard.min.js', array(), $theme_version, true);
			wp_enqueue_script('script-noty', get_stylesheet_directory_uri().'/node_modules/noty/lib/noty.min.js', array(), $theme_version, true);
			wp_enqueue_script('script-jquery-cookie', get_stylesheet_directory_uri().'/node_modules/jquery.cookie/jquery.cookie.js', array(), $theme_version, true);
			wp_enqueue_script('script-moment', get_stylesheet_directory_uri().'/node_modules/moment/min/moment.min.js', array(), $theme_version, true);
			wp_enqueue_script('embedly', 'http://cdn.embed.ly/jquery.embedly-3.1.1.min.js', array(), $theme_version, true );
			wp_enqueue_script('script-player', get_stylesheet_directory_uri().'/node_modules/player.js/dist/player-0.1.0.min.js', array(), $theme_version, true);
			wp_enqueue_script('script-tinymce', get_stylesheet_directory_uri().'/node_modules/tinymce/tinymce.min.js', array(), $theme_version, true);
			wp_enqueue_script('script-select2', get_stylesheet_directory_uri().'/node_modules/select2/dist/js/select2.min.js', array(), $theme_version, true);
			
			// Scripts - Custom
			wp_enqueue_script('theme-js', get_bloginfo('template_url').'/assets/js/theme/theme.js', array(), $theme_version, true);
			wp_localize_script('theme-js', 'fx', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'login_url' => site_url( 'login' ),
				'logout_url' => wp_logout_url()
			));
		}
	}
}

return new ThemeSettings();

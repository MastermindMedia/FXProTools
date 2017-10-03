<?php
/*
Plugin Name: WP SMS - Professional Package
Plugin URI: http://wordpresssmsplugin.com/
Description: Complementary package for add new capability to WP SMS Plugin.
Version: 2.2.8
Author: Mostafa Soufi
Author URI: http://mostafa-soufi.ir/
Text Domain: wp-sms-pro
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

// Plugin defines
define( 'WP_SMS_PRO_VERSION', '2.2.8' );
define( 'WP_SMS_PRO_DIR_PLUGIN', plugin_dir_url( __FILE__ ) );

// Get options
$wpsms_pro_option = get_option( 'wps_pp_settings' );

// Load plugin
add_action( 'plugins_loaded', array( WP_SMS_Pro::get_instance(), 'plugin_setup' ) );

class WP_SMS_Pro {
	/**
	 * Plugin instance.
	 *
	 * @see get_instance()
	 * @type object
	 */
	protected static $instance = null;

	/**
	 * URL to this plugin's directory.
	 *
	 * @type string
	 */
	public $plugin_url = '';

	/**
	 * Path to this plugin's directory.
	 *
	 * @type string
	 */
	public $plugin_path = '';

	/**
	 * Access this plugin’s working instance
	 *
	 * @wp-hook plugins_loaded
	 * @since   2.2.0
	 * @return  object of this class
	 */
	public static function get_instance() {
		null === self::$instance and self::$instance = new self;

		return self::$instance;
	}

	/**
	 * Used for regular plugin work.
	 *
	 * @wp-hook plugins_loaded
	 * @since   2.2.0
	 * @return  void
	 */
	public function plugin_setup() {
		$this->plugin_url  = dirname( plugin_basename( __FILE__ ) );
		$this->plugin_path = plugin_dir_path( __FILE__ );
		$this->load_language( 'wp-sms-pro' );

		// Check required plugin
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( ! is_plugin_active( 'wp-sms/wp-sms.php' ) ) {
			add_action( 'admin_notices', array( &$this, 'admin_notices' ) );

			return;
		}

		__( 'WP SMS - Professional Package', 'wp-sms-pro' );
		__( 'Complementary package for add new capability to WP SMS Plugin.', 'wp-sms-pro' );

		$this->includes();
	}

	/**
	 * Constructor. Intentionally left empty and public.
	 *
	 * @see plugin_setup()
	 * @since 2.2.0
	 */
	public function __construct() {
	}

	/**
	 * Admin notices
	 *
	 * @see plugin_setup()
	 * @since 2.2.0
	 * @return string
	 */
	public function admin_notices() {
		$get_bloginfo_url = 'plugin-install.php?tab=plugin-information&plugin=wp-sms&TB_iframe=true&width=600&height=550';
		echo '<br><div class="update-nag">' . sprintf( __( 'Please Install/Active <a href="%s" class="thickbox">WP-SMS</a> to run the plugin.', 'wp-sms-pro' ), $get_bloginfo_url ) . '</div>';
	}

	/**
	 * Loads translation file.
	 *
	 * Accessible to other classes to load different language files
	 *
	 * @wp-hook init
	 *
	 * @param   string $domain
	 *
	 * @since   2.2.0
	 * @return  void
	 */
	public function load_language( $domain ) {
		load_plugin_textdomain(
			$domain,
			false,
			$this->plugin_url . '/languages'
		);
	}

	/**
	 * Includes plugin files
	 *
	 * @param  Not param
	 */
	public function includes() {
		$files = array(
			'vendor/autoload',
			'includes/class-wp-sms-pro-gateways',
			'includes/class-wp-sms-pro-wordpress',
			'includes/class-wp-sms-pro-buddypress',
			'includes/class-wp-sms-pro-woocommerce',
			'includes/class-wp-sms-pro-gravityforms',
			'includes/class-wp-sms-pro-quform',
			'includes/class-wp-sms-pro-easy-digital-downloads',
			'includes/class-wp-sms-pro-wp-job-manager',
		);

		foreach ( $files as $file ) {
			include_once dirname( __FILE__ ) . '/' . $file . '.php';
		}
	}
}
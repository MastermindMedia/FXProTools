<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * GotoWebinar Direct Login
 *
 *
 * @since 3.12
 * @access (protected, public)
 * */
class Apyc_Modal{
	/**
	 * instance of this class
	 *
	 * @since 3.12
	 * @access protected
	 * @var	null
	 * */
	protected static $instance = null;
	
    /**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function init(){
		$data = array();
		$data['webinars'] = Apyc_Citrix_GoToWebinar_GetAll::get_instance()->query();
		Apyc_View::get_instance()->view_theme('inc/Apyc/view/modal.php', $data);
	}
	
	public function equeue_scripts(){
		global $theme_version;
		wp_enqueue_script('modal-js-script', get_bloginfo('template_url').'/inc/Apyc/js/modal.js', $theme_version);
	}
	
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array($this,'equeue_scripts') );
		add_action( 'wp_footer', array($this,'init') );
	}
}

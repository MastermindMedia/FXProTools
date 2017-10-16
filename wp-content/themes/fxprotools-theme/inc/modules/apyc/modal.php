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
		Apyc_View::get_instance()->view_theme(TEMPLATE_PATH . 'modal.php', $data);
	}
	
	public function get_webinars(){
		$data = array();

		$webinars = apyc_get_webinar_free();
		$data['webinars'] = $webinars;

		if( is_array($webinars)
			&& !empty($webinars)
		){
			Apyc_View::get_instance()->view_theme(TEMPLATE_PATH . 'modal-ajax-data.php', $data);
		}else{
			$ret = array(
				'status' => 'no-webinar',
				'msg' => 'No Webinar'
			);
			echo json_encode($ret);
		}
		wp_die();
	}
	
	public function register_webinar(){
		$data = array();
		$post = $_POST;
		$data = json_decode($post['post_data'], true);
		parse_str($post['post_data'], $ajax);
		$full_name = explode(' ', $ajax['fullName']);
		
		$first_name = '';
		if( isset($full_name[0]) ){
			$first_name = $full_name[0];
		}
		
		$last_name = isset($full_name[1]) ? $full_name[1]:'' . isset($full_name[2]) ? $full_name[2]:'';
		
		$body_input = array(
			'lastName' => $last_name,
			'firstName' => $first_name,
			'phone ' => isset($ajax['phone']) ? $ajax['phone']:'',
		);
		$webinars_key = false;
		if( isset($ajax['webinars']) 
			&& !empty($ajax['webinars'])
		){
			print_r($body_input);
			foreach($ajax['webinars'] as $v){
				//apyc_create_registrant($v, $body_input);
			}
		}
		wp_die();
	}
	
	public function equeue_scripts(){
		global $theme_version;
		wp_enqueue_script('modal-js-script', ASSETS_JS_PATH. 'modal.js', $theme_version);
	}
	
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array($this,'equeue_scripts') );
		add_action( 'wp_footer', array($this,'init') );
		add_action( 'wp_ajax_get_webinars', array($this, 'get_webinars') );
		add_action( 'wp_ajax_nopriv_get_webinars', array($this, 'get_webinars') );
		add_action( 'wp_ajax_register_webinars', array($this, 'register_webinar') );
		add_action( 'wp_ajax_nopriv_register_webinars', array($this, 'register_webinar') );
	}
}

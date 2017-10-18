<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Coaching related class
 * /coaching/
 *
 *
 * @since 3.12
 * @access (protected, public)
 * */
class Apyc_Coaching{
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
	
	//get the upcoming webinars
	public function get_webinars(){
		$data = array();

		$webinars = apyc_get_upcoming_webinars();
		$data['webinars'] = $webinars;

		if( is_array($webinars)
			&& !empty($webinars)
		){
			Apyc_View::get_instance()->view_theme(TEMPLATE_PATH . 'coaching/ajax-upcoming-webinars.php', $data);
		}else{
			$ret = array(
				'status' => 'no-webinar',
				'msg' => _('No Webinar')
			);
			echo json_encode($ret);
		}
		wp_die();
	}
	
	//get the history webinars
	public function get_history_webinars(){
		$data = array();

		$webinars = apyc_get_upcoming_webinars();
		$data['webinars'] = $webinars;

		if( is_array($webinars)
			&& !empty($webinars)
		){
			Apyc_View::get_instance()->view_theme(TEMPLATE_PATH . 'coaching/ajax-history-webinars.php', $data);
		}else{
			$ret = array(
				'status' => 'no-webinar',
				'msg' => _('No Webinar')
			);
			echo json_encode($ret);
		}
		wp_die();
	}
	
	public function __construct() {
		add_action( 'wp_ajax_coach_get_webinars', array($this, 'get_webinars') );
		add_action( 'wp_ajax_nopriv_coach_get_webinars', array($this, 'get_webinars') );
		add_action( 'wp_ajax_coach_get_history_webinars', array($this, 'get_history_webinars') );
		add_action( 'wp_ajax_nopriv_coach_get_history_webinars', array($this, 'get_history_webinars') );
	}
}

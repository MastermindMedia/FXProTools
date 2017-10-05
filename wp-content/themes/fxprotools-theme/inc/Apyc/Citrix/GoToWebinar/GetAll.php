<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * GotoWebinar - Get All Webinars
 https://goto-developer.logmeininc.com/content/gotowebinar-api-reference#!/Webinars/getAllWebinars
 *
 *
 * @since 3.12
 * @access (protected, public)
 * */
class Apyc_Citrix_GoToWebinar_GetAll{
	/**
	 * instance of this class
	 *
	 * @since 3.12
	 * @access protected
	 * @var	null
	 * */
	protected static $instance = null;

    /**
     * use for magic setters and getter
     * we can use this when we instantiate the class
     * it holds the variable from __set
     *
     * @see function __get, function __set
     * @access protected
     * @var array
     * */
    protected $vars = array();
	
	/**
	The url endpoint
	https://api.getgo.com/G2W/rest/organizers/<organizer_key>/webinars
	**/
	protected $url = 'https://api.getgo.com/G2W/rest/organizers/';
	
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
	
	/**
		Get All Webinars
		/organizers/{organizerKey}/webinars  
	**/
	public function get(){
		global $wp_version;
		
		$token = apyc_get_access_token();
		if( $token ){
			$args = array(
				'headers' => array(
					'Content-Type' => 'application/json',
					'Accept' => 'application/json',
					'Authorization' => $token->access_token,
				),
			); 
			$url = $this->url . $token->organizer_key . '/webinars';
			$response = wp_remote_get( $url, $args );
			if ( is_wp_error( $response ) ) {
			   $error_message = $response->get_error_message();
			   write_log('gotowebinar get all webinars error : ' . $error_message);
			   throw new Exception( $error_message );
			} else {
				$response_code = wp_remote_retrieve_response_code( $response );
				$body_res = wp_remote_retrieve_body( $response );
				$body = json_decode(preg_replace('/("\w+"):(\d+(\.\d+)?)/', '\\1:"\\2"', $body_res));
				//json_decode(preg_replace('/("\w+"):(\d+(\.\d+)?)/', '\\1:"\\2"', $get))
				if( $response_code != 200 ){
					throw new Exception( $body->int_err_code . ' - ' . $body->msg );
				}
				return $body;
			}
		}
	}
	
	public function cache($reset = false){
		$db_get = Apyc_Model_DBGotoWebinar::get_instance()->get_all_webinars('r');
		if( $reset || !$db_get ){
			//$webinars = $this->get();
			try{
				$webinars = Apyc_Citrix_GoToWebinar_GetAll::get_instance()->get();
				Apyc_Model_DBGotoWebinar::get_instance()->get_all_webinars('u', $webinars);
			}catch(Exception $e){
				write_log('get access token error : ' . $e->getMessage());
				return false;
			}
		}
		return Apyc_Model_DBGotoWebinar::get_instance()->get_all_webinars('r');
	}
	
	public function __construct() {}

}
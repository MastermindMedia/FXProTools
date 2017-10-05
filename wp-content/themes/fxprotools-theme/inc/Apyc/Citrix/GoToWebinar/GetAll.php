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
			$body = array();
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
				if( $response_code == 200 ){
					$body = json_decode(preg_replace('/("\w+"):(\d+(\.\d+)?)/', '\\1:"\\2"', $body_res));
					return $body;
				}else{
					$body = json_decode($body_res);
					write_log(isset($body->category) ? $body->category:'' .' '.isset($body->message) ? $body->message:'');
					return false;
				}
			}
		}
		return false;
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
	
	public function query($args = array()){
		$data = array();
		$defaults = array(
			'number_post' => 5,
		);
		$query_args = wp_parse_args( $args, $defaults );
		$get_data = $this->get();

		if( $get_data ){
			$number_post = $query_args['number_post'];
			$i = 0;
			for($i = 0; $i < $number_post; $i++){
				$parse_data = array(
					'key' => $get_data[$i]->webinarKey,
					'startTime' => date("l, M.jS, h:i A e", strtotime($get_data[$i]->times[0]->startTime)),
				);
				$data[] = array(
					'raw' => $get_data[$i],
					'parse' => $parse_data
				);
			}
			return $data;
		}
		return $data;
	}
	
	public function __construct() {}

}

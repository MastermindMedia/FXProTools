<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * For User related
 *
 *
 * 
 * @access (protected, public)
 * */
class Apyc_User{
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
	*	Get users using WP_User_Query that has mobile number only
	*	
	*	@see https://codex.wordpress.org/Class_Reference/WP_User_Query
	*	
	*	@param	type	$arg	associative array	default array()
	*		acceptable elements:
	*		$arg = array(
	*			'sending_to' => array('Customer', 'Distributor', 'All')		
	*		);
	*	@return	WP_User_Query return
	**/
	public function getWithMobileNumber($arg = array()){
		$query = array(
			'role__in' => isset($arg['sending_to']) ? $arg['sending_to'] : array('All'),
			'meta_query' => array(
				array(
					'key'     => 'mobile',
					'value' => '',
					'compare' => '!='
				),
			)
		);
		return = new WP_User_Query($query);
	}
	
	public function __construct() {}

}

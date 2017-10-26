<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Display calendar and choose time to reserve webinar
 *
 *
 * @since 3.12
 * @access (protected, public)
 * */
class Apyc_Woo_CoachingTemplate{
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
	
	public function action_woocommerce_before_add_to_cart_button(){
		global $woocommerce, $post, $product;

		if( $product->get_type() == 'apyc_woo_gotowebinar_appointment' ){
		dd($product);
		dd($product->get_type());
		dd($product->get_id());
		dd($post);
		}
	}		
	public function webinar_add_to_cart() {
		wc_get_template( 'single-product/add-to-cart/simple.php' );
	}
	public function __construct() {
		add_action( 'woocommerce_before_add_to_cart_form', array($this,'action_woocommerce_before_add_to_cart_button'), 10, 0 ); 
		add_action('woocommerce_apyc_woo_gotowebinar_appointment_add_to_cart', array($this, 'webinar_add_to_cart'));
	}
}

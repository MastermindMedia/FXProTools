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
	
	public function get_woogotowebinar_scheduling_window_num($post_id){
		return get_post_meta($post_id, '_woogotowebinar_scheduling_window_num', true);
	}
	
	public function get_woogotowebinar_scheduling_window_date($post_id){
		return get_post_meta($post_id, '_woogotowebinar_scheduling_window_date', true);
	}
	
	public function get_woogotowebinar_range_time_from($post_id){
		return get_post_meta($post_id, '_woogotowebinar_range_time_from', true);
	}
	
	public function get_woogotowebinar_range_time_from_meridiem($post_id){
		return get_post_meta($post_id, '_woogotowebinar_range_time_from_meridiem', true);
	}
	
	public function get_woogotowebinar_range_time_to($post_id){
		return get_post_meta($post_id, '_woogotowebinar_range_time_to', true);
	}
	
	public function get_woogotowebinar_range_time_to_meridiem($post_id){
		return get_post_meta($post_id, '_woogotowebinar_range_time_to_meridiem', true);
	}
	
	public function action_woocommerce_before_add_to_cart_button(){
		global $woocommerce, $post, $product;
		$data = array();
		if( $product->get_type() == 'apyc_woo_gotowebinar_appointment' ){
			$product_id = $product->get_id();
			$data['product'] = $product;
			$data['post'] = $post;
			$data['get_woogotowebinar_scheduling_window_num'] = $this->get_woogotowebinar_scheduling_window_num($product_id);
			$data['get_woogotowebinar_scheduling_window_date'] = $this->get_woogotowebinar_scheduling_window_date($product_id);
			Apyc_View::get_instance()->view_theme(TEMPLATE_PATH . 'coaching/woo/datepicker.php', $data);
		}
	}
	
	public function enqueue_scripts(){
		global $theme_version, $woocommerce, $post, $product;

		wp_enqueue_style( 'jquery-ui-theme', 'http://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		
		$product_meta_array = array();
		if( is_product() ){
			$product_id = get_the_ID();
			$wc_get_prod = wc_get_product($product_id);
			if( $wc_get_prod->get_type() == 'apyc_woo_gotowebinar_appointment' ){
				$get_woogotowebinar_scheduling_window_num = $this->get_woogotowebinar_scheduling_window_num($product_id);
				$get_woogotowebinar_scheduling_window_date = $this->get_woogotowebinar_scheduling_window_date($product_id);
				$product_meta_array = array(
					'product_id' => $product_id,
					'_woogotowebinar_scheduling_window_num' => $get_woogotowebinar_scheduling_window_num,
					'_woogotowebinar_scheduling_window_date' => $get_woogotowebinar_scheduling_window_date
				);
			}
		}
		wp_localize_script('theme-js', 'woo_webinar', $product_meta_array );
	}
	
	public function webinar_add_to_cart() {
		wc_get_template( 'single-product/add-to-cart/simple.php' );
	}
	public function __construct() {
		add_action('woocommerce_before_add_to_cart_form', array($this,'action_woocommerce_before_add_to_cart_button'), 10, 0 ); 
		add_action('woocommerce_apyc_woo_gotowebinar_appointment_add_to_cart', array($this, 'webinar_add_to_cart'));
		add_action('wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}
}

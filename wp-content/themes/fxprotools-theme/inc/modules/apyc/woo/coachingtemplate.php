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
	
	public function getWoogotowebinarSchedulingWindowNum($post_id){
		return get_post_meta($post_id, '_woogotowebinar_scheduling_window_num', true);
	}
	
	public function getWoogotowebinarSchedulingWindowDate($post_id){
		return get_post_meta($post_id, '_woogotowebinar_scheduling_window_date', true);
	}
	
	public function getWoogotowebinarRangeTimeFrom($post_id){
		return get_post_meta($post_id, '_woogotowebinar_range_time_from', true);
	}

	public function getWoogotowebinarRangeTimeFromMeridiem($post_id){
		return get_post_meta($post_id, '_woogotowebinar_range_time_from_meridiem', true);
	}

	public function getWoogotowebinarRangeTimeTo($post_id){
		return get_post_meta($post_id, '_woogotowebinar_range_time_to', true);
	}

	public function getWoogotowebinarRangeTimeToMeridiem($post_id){
		return get_post_meta($post_id, '_woogotowebinar_range_time_to_meridiem', true);
	}
	
	public function action_woocommerce_before_add_to_cart_button(){
		global $woocommerce, $post, $product;
		$data = array();
		if( $product->get_type() == 'apyc_woo_gotowebinar_appointment' ){
			$product_id = $product->get_id();
			$data['product'] = $product;
			$data['post'] = $post;
			$data['get_woogotowebinar_scheduling_window_num'] = $this->getWoogotowebinarSchedulingWindowNum($product_id);
			$data['get_woogotowebinar_scheduling_window_date'] = $this->getWoogotowebinarSchedulingWindowDate($product_id);
			Apyc_View::get_instance()->view_theme(TEMPLATE_PATH . 'coaching/woo/datepicker.php', $data);
		}
	}
	
	public function enqueue_scripts(){
		global $theme_version, $woocommerce, $post;

		wp_enqueue_style( 'jquery-ui-theme', 'http://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		
		$product_meta_array = array();
		if( is_product() ){
			$product_id = get_the_ID();
			$wc_get_prod = wc_get_product($product_id);
			if( $wc_get_prod->get_type() == 'apyc_woo_gotowebinar_appointment' ){
				$get_woogotowebinar_scheduling_window_num = $this->getWoogotowebinarSchedulingWindowNum($product_id);
				$get_woogotowebinar_scheduling_window_date = $this->getWoogotowebinarSchedulingWindowDate($product_id);
				$get_woogotowebinar_range_time_from = $this->getWoogotowebinarRangeTimeFrom($product_id);
				$get_woogotowebinar_range_time_from_meridiem = $this->getWoogotowebinarRangeTimeFromMeridiem($product_id);
				$get_woogotowebinar_range_time_to = $this->getWoogotowebinarRangeTimeTo($product_id);
				$get_woogotowebinar_range_time_to_meridiem = $this->getWoogotowebinarRangeTimeToMeridiem($product_id);
				
				$product_meta_array = array(
					'product_id' => $product_id,
					'_woogotowebinar_scheduling_window_num' => $get_woogotowebinar_scheduling_window_num ? $get_woogotowebinar_scheduling_window_num:0,
					'_woogotowebinar_scheduling_window_date' => $get_woogotowebinar_scheduling_window_date ? $get_woogotowebinar_scheduling_window_date:'',
					'_woogotowebinar_range_time_from' => $get_woogotowebinar_range_time_from ? $get_woogotowebinar_range_time_from:0,
					'_woogotowebinar_range_time_from_meridiem' => $get_woogotowebinar_range_time_from_meridiem ? $get_woogotowebinar_range_time_from_meridiem:'',
					'_woogotowebinar_range_time_to' => $get_woogotowebinar_range_time_to ? $get_woogotowebinar_range_time_to:0,
					'_woogotowebinar_range_time_to_meridiem' => $get_woogotowebinar_range_time_to_meridiem ? $get_woogotowebinar_range_time_to_meridiem:''
				);
			}
		}
		wp_localize_script('theme-js', 'woo_webinar', $product_meta_array );
	}
	
	public function get_timerange_woowebinar(){
		$data = array();
		$ret = array(
			'status' 	=> 1,
			'msg' 		=> ''
		);
		$ret['get'] = $_GET;
		$range_time_from = isset($_GET['range_time_from']) ? $_GET['range_time_from']:'';
		$range_time_to = isset($_GET['range_time_to']) ? $_GET['range_time_to']:'';
		$date_range = apyc_time_interval($range_time_from, $range_time_to);
		
		$data['date_range'] = $date_range;
		if( !empty($date_range) ){
			Apyc_View::get_instance()->view_theme(TEMPLATE_PATH . 'coaching/woo/ajax-date-range.php', $data);
		}else{
			$ret['msg'] = _('No Date Range');
			$ret['status'] = 0;
			echo json_encode($ret);
		}
		wp_die();
	}
	
	public function webinar_add_to_cart() {
		wc_get_template( 'single-product/add-to-cart/simple.php' );
	}
	
	public function add_to_cart_input() {
		//wc_get_template( 'single-product/add-to-cart/simple.php' );
		$data = array();
		Apyc_View::get_instance()->view_theme(TEMPLATE_PATH . 'coaching/woo/after-add-to-cart-button.php', $data);
	}
	 /*
	 * Add custom data to the cart item
	 * @param array $cart_item
	 * @param int $product_id
	 * @return array
	 */
	public function add_cart_item_data($cart_item_data, $product_id, $variation_id){
		
		$wc_get_prod = wc_get_product($product_id);
		if( $wc_get_prod->get_type() == 'apyc_woo_gotowebinar_appointment' ){
			$cart_item_data['selected_date'] = '';
			if( isset( $_POST['selected_date'] ) ) {
				$cart_item_data['selected_date'] = sanitize_text_field( $_POST['selected_date'] );
			}
			$cart_item_data['selected_month'] = '';
			if( isset( $_POST['selected_month'] ) ) {
				$cart_item_data['selected_month'] = sanitize_text_field( $_POST['selected_month'] );
			}
			$cart_item_data['selected_year'] = '';
			if( isset( $_POST['selected_year'] ) ) {
				$cart_item_data['selected_year'] = sanitize_text_field( $_POST['selected_year'] );
			}
			$cart_item_data['selected_time'] = '';
			if( isset( $_POST['selected_time'] ) ) {
				$cart_item_data['selected_time'] = sanitize_text_field( $_POST['selected_time'] );
			}
			/*$date = date("F d, Y", strtotime($cart_item_data['selected_year'].'-'.$cart_item_data['selected_month'] .'-'.$cart_item_data['selected_date']));
			echo $date;
			exit();*/
		}
		
		return $cart_item_data;
	}
	/*
	 * Get item data to display in cart
	 * @param array $other_data
	 * @param array $cart_item
	 * @return array
	 */
	public function get_item_data_meta( $other_data, $cart_item ){
		if ( isset( $cart_item['selected_date'] ) ){
			$selected_date = sanitize_text_field( $cart_item['selected_date'] );
			$selected_month = sanitize_text_field( $cart_item['selected_month'] );
			$selected_year = sanitize_text_field( $cart_item['selected_year'] );
			$selected_time = sanitize_text_field( $cart_item['selected_time'] );
			$date = date("F d, Y", strtotime($selected_year.'-'.$selected_month.'-'.$selected_date));
			$other_data[] = array(
				'name' => __( 'Date', 'woocommerce' ),
				'value' => $date
			);
			$other_data[] = array(
				'name' => __( 'Time', 'woocommerce' ),
				'value' => $selected_time
			);

		}

		return $other_data;
	}
	/**
	 * Add meta to order.
	 *
	 * @param WC_Order_Item_Product $item
	 * @param string                $cart_item_key
	 * @param array                 $values
	 * @param WC_Order              $order
	 */
	public function add_webinar_date_order_line_item( $item, $cart_item_key, $values, $order ) {
		if ( !empty( $values['selected_date'] ) ) {
			$selected_date = sanitize_text_field( $values['selected_date'] );
			$selected_month = sanitize_text_field( $values['selected_month'] );
			$selected_year = sanitize_text_field( $values['selected_year'] );
			$date = date("F d, Y", strtotime($selected_year.'-'.$selected_month.'-'.$selected_date));
			$item->add_meta_data( __( 'Date', 'woocommerce' ), $date );
		}
		if ( !empty( $values['selected_time'] ) ) {
			$selected_time = sanitize_text_field( $values['selected_time'] );
			$item->add_meta_data( __( 'Time', 'woocommerce' ), $selected_time );
		}
	}
	public function __construct() {
		add_action('woocommerce_before_add_to_cart_form', array($this,'action_woocommerce_before_add_to_cart_button'), 10, 0 ); 
		add_action('woocommerce_apyc_woo_gotowebinar_appointment_add_to_cart', array($this, 'webinar_add_to_cart'));
		add_action('wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action('wp_ajax_get_timerange_woowebinar', array($this, 'get_timerange_woowebinar') );
		add_action('wp_ajax_nopriv_get_timerange_woowebinar', array($this, 'get_timerange_woowebinar') );
		add_filter('woocommerce_add_cart_item_data', array($this, 'add_cart_item_data'), 10, 3 );
		add_filter('woocommerce_after_add_to_cart_button', array($this, 'add_to_cart_input'));
		add_filter('woocommerce_get_item_data', array($this, 'get_item_data_meta'), 10, 2 );
		add_action('woocommerce_checkout_create_order_line_item', array($this, 'add_webinar_date_order_line_item'), 10, 4 );
	}
}

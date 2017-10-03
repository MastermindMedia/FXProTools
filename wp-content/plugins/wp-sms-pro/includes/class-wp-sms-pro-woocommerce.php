<?php

/**
 * WP SMS Pro woocommerce
 *
 * @category   class
 * @package    WP_SMS_Pro
 * @version    1.0
 */
class WP_SMS_Pro_Woocommerce {

	public $sms;
	public $options;

	public function __construct() {
		global $wpsms_pro_option, $sms;

		$this->sms     = $sms;
		$this->options = $wpsms_pro_option;

		if ( isset( $this->options['wc_mobile_field'] ) ) {
			add_action( 'woocommerce_after_order_notes', array( &$this, 'checkout_field' ) );
			add_action( 'woocommerce_checkout_process', array( &$this, 'checkout_handler' ) );
			add_action( 'woocommerce_checkout_update_order_meta', array( &$this, 'update_order_meta' ) );
		}

		if ( isset( $this->options['wc_notify_product_enable'] ) ) {
			add_action( 'publish_product', array( &$this, 'notification_new_order' ) );
		}

		if ( isset( $this->options['wc_notify_order_enable'] ) ) {
			add_action( 'woocommerce_new_order', array( $this, 'admin_notification_order' ) );
		}

		if ( isset( $this->options['wc_notify_customer_enable'] ) ) {
			add_action( 'woocommerce_new_order', array( &$this, 'customer_notification_order' ) );
		}

		if ( isset( $this->options['wc_notify_stock_enable'] ) ) {
			add_action( 'woocommerce_low_stock', array( &$this, 'admin_notification_low_stock' ) );
		}

		if ( isset( $this->options['wc_notify_status_enable'] ) ) {
			add_action( 'woocommerce_order_status_changed', array( &$this, 'notification_change_order_status' ) );
		}
	}

	/**
	 * WooCommerce Features
	 * Add the field to the checkout page
	 *
	 * @param $checkout
	 */
	public function checkout_field( $checkout ) {
		woocommerce_form_field( 'mobile', array(
			'type'        => 'text',
			'class'       => array( 'input-text' ),
			'label'       => __( 'Mobile Number', 'wp-sms-pro' ),
			'placeholder' => __( 'Enter your mobile number to get any notifications about your order', 'wp-sms-pro' ),
			'required'    => true,
		),
			$checkout->get_value( 'mobile' ) );
	}

	/**
	 * WooCommerce Features
	 * Process the checkout
	 */
	public function checkout_handler() {
		// Check if the field is set, if not then show an error message.
		if ( ! $_POST['mobile'] ) {
			wc_add_notice( __( 'Please enter mobile number.', 'wp-sms-pro' ), 'error' );
		}
	}

	/**
	 * WooCommerce Features
	 * Update the order meta with field value
	 *
	 * @param $order_id
	 */
	public function update_order_meta( $order_id ) {
		if ( ! empty( $_POST['mobile'] ) ) {
			update_post_meta( $order_id, 'mobile', sanitize_text_field( $_POST['mobile'] ) );
		}
	}

	/**
	 * WooCommerce notification new product
	 *
	 * @param $post_ID
	 */
	public function notification_new_order( $post_ID ) {
		global $wpdb, $table_prefix;

		if ( $this->options['wc_notify_product_receiver'] == 'subscriber' ) {

			if ( $this->options['wc_notify_product_cat'] ) {
				$this->sms->to = $wpdb->get_col( "SELECT mobile FROM {$table_prefix}sms_subscribes WHERE group_ID = '" . $this->options['wc_notify_product_cat'] . "'" );
			} else {
				$this->sms->to = $wpdb->get_col( "SELECT mobile FROM {$table_prefix}sms_subscribes" );
			}

		} else if ( $this->options['wc_notify_product_receiver'] == 'users' ) {
			$this->sms->to = $wpdb->get_col( "SELECT DISTINCT `meta_value` FROM `" . $table_prefix . "postmeta` WHERE `meta_key` = 'mobile'" );
		}
		$template_vars  = array(
			'%product_title%' => get_the_title( $post_ID ),
			'%product_url%'   => wp_get_shortlink( $post_ID ),
			'%product_date%'  => get_post_time( 'Y-m-d', true, $post_ID, true ),
			'%product_price%' => $_REQUEST['_regular_price']
		);
		$message        = str_replace( array_keys( $template_vars ), array_values( $template_vars ), $this->options['wc_notify_product_message'] );
		$this->sms->msg = $message;
		$this->sms->SendSMS();
	}

	/**
	 * WooCommerce admin notification order
	 *
	 * @param $order_id
	 */
	public function admin_notification_order( $order_id ) {
		$order          = new WC_Order( $order_id );
		$this->sms->to  = array( $this->options['wc_notify_order_receiver'] );
		$template_vars  = array(
			'%order_id%'     => $order_id,
			'%order_number%' => $order->get_order_number(),
			'%status%'       => $order->get_status()
		);
		$message        = str_replace( array_keys( $template_vars ), array_values( $template_vars ), $this->options['wc_notify_order_message'] );
		$this->sms->msg = $message;
		$this->sms->SendSMS();
	}

	/**
	 * WooCommerce customer notification order
	 *
	 * @param $order_id
	 */
	public function customer_notification_order( $order_id ) {
		// Check the mobile field is empty
		if ( empty( $_REQUEST['mobile'] ) ) {
			return;
		}

		$order          = new WC_Order( $order_id );
		$this->sms->to  = array( $_REQUEST['mobile'] );
		$template_vars  = array(
			'%order_id%'           => $order_id,
			'%order_number%'       => $order->get_order_number(),
			'%status%'             => $order->get_status(),
			'%billing_first_name%' => $_REQUEST['billing_first_name'],
			'%billing_last_name%'  => $_REQUEST['billing_last_name'],
		);
		$message        = str_replace( array_keys( $template_vars ), array_values( $template_vars ), $this->options['wc_notify_customer_message'] );
		$this->sms->msg = $message;
		$this->sms->SendSMS();
	}

	/**
	 * WooCommerce notification low stock
	 *
	 * @param $stock
	 */
	public function admin_notification_low_stock( $stock ) {
		$this->sms->to  = array( $this->options['wc_notify_stock_receiver'] );
		$template_vars  = array(
			'%product_id%'   => $stock->id,
			'%product_name%' => $stock->post->post_title
		);
		$message        = str_replace( array_keys( $template_vars ), array_values( $template_vars ), $this->options['wc_notify_stock_message'] );
		$this->sms->msg = $message;
		$this->sms->SendSMS();
	}

	/**
	 * WooCommerce notification change status
	 *
	 * @param $order_id
	 */
	public function notification_change_order_status( $order_id ) {
		$order      = new WC_Order( $order_id );
		$get_mobile = get_post_meta( $order_id, 'mobile', true );

		if ( ! $get_mobile ) {
			return;
		}

		$this->sms->to  = array( $get_mobile );
		$template_vars  = array(
			'%status%'              => $order->get_status(),
			'%order_number%'        => $order->get_order_number(),
			'%customer_first_name%' => $order->billing_first_name,
			'%customer_last_name%'  => $order->billing_last_name
		);
		$message        = str_replace( array_keys( $template_vars ), array_values( $template_vars ), $this->options['wc_notify_status_message'] );
		$this->sms->msg = $message;
		$this->sms->SendSMS();
	}
}

new WP_SMS_Pro_Woocommerce();
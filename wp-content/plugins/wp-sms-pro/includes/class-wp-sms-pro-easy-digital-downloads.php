<?php

/**
 * WP SMS Pro easy-digital-downloads
 *
 * @category   class
 * @package    WP_SMS_Pro
 * @version    1.0
 */
class WP_SMS_Pro_Edd {

	public $sms;
	public $options;

	public function __construct() {
		global $wpsms_pro_option, $sms;

		$this->sms     = $sms;
		$this->options = $wpsms_pro_option;

		if ( isset( $this->options['edd_mobile_field'] ) ) {
			add_action( 'edd_purchase_form_user_info', array( &$this, 'checkout_field' ) );
			add_action( 'edd_checkout_error_checks', array( &$this, 'validate_checkout_field' ), 10, 2 );
			add_filter( 'edd_payment_meta', array( &$this, 'store_checkout_field' ) );
			add_action( 'edd_payment_personal_details_list', array( &$this, 'purchase_details' ), 10, 2 );
		}

		if ( isset( $this->options['edd_notify_order_enable'] ) ) {
			add_action( 'edd_complete_purchase', array( &$this, 'notification_order' ) );
		}

		if ( isset( $this->options['edd_notify_customer_enable'] ) ) {
			add_action( 'edd_complete_purchase', array( &$this, 'notify_customer' ) );
		}
	}

	// output our custom field HTML
	public function checkout_field() {
		?>
        <p id="edd-mobile-wrap">
            <label class="edd-label" for="edd-mobile"><?php _e( 'Mobile Number', 'wp-sms-pro' ); ?></label>
            <span class="edd-description"><?php _e( 'Please enter mobile number for get sms', 'wp-sms-pro' ); ?></span>
            <input class="edd-input" type="text" name="edd_mobile" id="edd-mobile"
                   placeholder="<?php _e( 'Mobile Number', 'wp-sms-pro' ); ?>" value=""/>
        </p>
		<?php
	}

	// check for errors with out custom fields
	public function validate_checkout_field( $valid_data, $data ) {
		if ( empty( $data['edd_mobile'] ) ) {
			// check for a phone number
			edd_set_error( 'invalid_mobile', __( 'Please enter mobile number for get sms', 'wp-sms-pro' ) );
		}
	}

	// store the custom field data in the payment meta
	public function store_checkout_field( $payment_meta ) {
		$payment_meta['mobile'] = isset( $_POST['edd_mobile'] ) ? sanitize_text_field( $_POST['edd_mobile'] ) : '';

		return $payment_meta;
	}

	// show the custom fields in the "View Order Details" popup
	public function purchase_details( $payment_meta, $user_info ) {
		$mobile = isset( $payment_meta['mobile'] ) ? $payment_meta['mobile'] : 'none';
		?>
        <hr>
        <p><?php echo _e( 'Mobile Number', 'wp-sms-pro' ) . ' ' . $mobile; ?></p>
		<?php
	}

	public function notification_order() {
		$this->sms->to  = array( $this->options['edd_notify_order_receiver'] );
		$template_vars  = array(
			'%edd_email%' => $_REQUEST['edd_email'],
			'%edd_first%' => $_REQUEST['edd_first'],
			'%edd_last%'  => $_REQUEST['edd_last'],
		);
		$message        = str_replace( array_keys( $template_vars ), array_values( $template_vars ), $this->options['edd_notify_order_message'] );
		$this->sms->msg = $message;
		$this->sms->SendSMS();
	}

	public function notify_customer() {
	    // Check the mobile
		if ( ! $_REQUEST['edd_mobile'] ) {
			return;
		}

		$this->sms->to  = array( $_REQUEST['edd_mobile'] );
		$template_vars  = array(
			'%edd_email%' => $_REQUEST['edd_email'],
			'%edd_first%' => $_REQUEST['edd_first'],
			'%edd_last%'  => $_REQUEST['edd_last'],
		);
		$message        = str_replace( array_keys( $template_vars ), array_values( $template_vars ), $this->options['edd_notify_customer_message'] );
		$this->sms->msg = $message;
		$this->sms->SendSMS();
	}
}

new WP_SMS_Pro_Edd();
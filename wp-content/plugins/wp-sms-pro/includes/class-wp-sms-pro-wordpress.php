<?php

/**
 * WP SMS Pro wordpress
 *
 * @category   class
 * @package    WP_SMS_Pro
 * @version    1.0
 */
class WP_SMS_Pro_Wordpress {

	public $sms;
	public $options;

	public function __construct() {
		global $wpsms_pro_option, $sms;

		$this->sms     = $sms;
		$this->options = $wpsms_pro_option;

		if ( isset( $this->options['login_sms'] ) ) {
			add_action( 'login_form', array( &$this, 'login_sms' ) );
		}

		if ( isset( $this->options['register_verify_sms'] ) ) {
			global $wpsms_option;
			if ( empty( $wpsms_option['add_mobile_field'] ) ) {
				// Enable mobile field option
				$wpsms_option['add_mobile_field'] = 1;

				// Update entire array
				update_option( 'wpsms_settings', $wpsms_option );
			}

			// Verify status column
			add_action( 'manage_users_columns', array( &$this, 'modify_user_columns' ) );
			add_action( 'admin_head', array( &$this, 'custom_admin_css' ) );
			add_action( 'manage_users_custom_column', array( &$this, 'user_posts_count_column_content' ), 10, 3 );

			// Verify status field
			add_action( 'show_user_profile', array( &$this, 'verify_status_user_field' ) );
			add_action( 'edit_user_profile', array( &$this, 'verify_status_user_field' ) );
			add_action( 'personal_options_update', array( &$this, 'verify_status_user_update_field' ) );
			add_action( 'edit_user_profile_update', array( &$this, 'verify_status_user_update_field' ) );

			// Send verification code to user after register
			add_action( 'user_register', array( &$this, 'send_verification_code' ) );

			// Enable verify field and message to login forms
			add_filter( 'login_message', array( &$this, 'enable_verify_message' ) );
			add_action( 'login_form', array( &$this, 'enable_verify_field' ) );

			// Check login
			add_action( 'wp_login', array( &$this, 'check_user_login' ), 99, 2 );
		}
	}

	/**
	 * Login sms
	 */
	public function login_sms() {
		include_once dirname( __FILE__ ) . "/templates/login-sms.php";
	}


	public function modify_user_columns( $column_headers ) {
		$column_headers['wpsms_verified']    = __( 'Verified', 'wp-sms-pro' );
		$column_headers['wpsms_verify_code'] = __( 'Verification code', 'wp-sms-pro' );

		return $column_headers;
	}


	public function custom_admin_css() {
		echo '<style>
		.column-wpsms_verified, .column-wpsms_verify_code {width: 8%}
		</style>';
	}


	public function user_posts_count_column_content( $value, $column_name, $user_id ) {
		$user = get_userdata( $user_id );

		if ( 'wpsms_verified' == $column_name ) {
			// Get verify status
			$verify = get_user_meta( $user_id, 'wpsms_verified', true );
			if ( $verify ) {
				return __( 'Yes', 'wp-sms-pro' );
			} else {
				return __( 'No', 'wp-sms-pro' );
			}
		}

		if ( 'wpsms_verify_code' == $column_name ) {
			// Get verify status
			$verify = get_user_meta( $user_id, 'wpsms_verify_code', true );

			return $verify;
		}

		return $value;
	}

	public function verify_status_user_field( $user ) {
		if ( ! current_user_can( 'manage_options', $user->ID ) ) {
			return false;
		}

		// Get verify status
		$verify = get_user_meta( $user->ID, 'wpsms_verified', true );

		// Load template
		include_once dirname( __FILE__ ) . "/templates/verify-sms-field.php";
	}

	public function verify_status_user_update_field( $user_id ) {
		if ( ! current_user_can( 'manage_options', $user_id ) ) {
			return false;
		}

		if ( isset( $_POST['wpsms_verified'] ) ) {
			update_user_meta( $user_id, 'wpsms_verified', 1 );
		} else {
			update_user_meta( $user_id, 'wpsms_verified', 0 );
		}
	}

	public function send_verification_code( $user_id ) {
		// Get user mobile number
		$user_mobile = get_user_meta( $user_id, 'mobile', true );

		if ( ! $user_mobile ) {
			return;
		}

		// Generate verification code
		$verify_code = rand( 11111, 99999 );

		// Update verification code in user meta
		update_user_meta( $user_id, 'wpsms_verify_code', $verify_code );

		// Send sms
		$this->sms->to  = array( $user_mobile );
		$this->sms->msg = sprintf( __( 'Verification code: %s', 'wp-sms-pro' ), $verify_code );
		$this->sms->SendSMS();
	}

	public function enable_verify_message( $message ) {
		if ( empty( $_GET['need_verify'] ) ) {
			return $message;
		}

		if ( empty( $message ) ) {
			return '<div class="message">' . __( 'Please enter mobile verification code', 'wp-sms-pro' ) . '<br></div>';
		} else {
			return $message;
		}
	}

	public function enable_verify_field() {
		if ( empty( $_GET['need_verify'] ) ) {
			return;
		}

		// Load template
		include_once dirname( __FILE__ ) . "/templates/verify-sms-field-login.php";
	}

	public function check_user_login( $user_login, $user ) {
		// Check user role
		if ( isset( $user->allcaps['manage_options'] ) ) {
			return;
		}

		// Get variables
		$verify      = get_user_meta( $user->ID, 'wpsms_verified', true );
		$verify_code = get_user_meta( $user->ID, 'wpsms_verify_code', true );

		// Return if user verified
		if ( $verify == 1 ) {
			return;
		}

		if ( isset( $_POST['wpsms_verify_code'] ) ) {
			if ( isset( $_POST['wpsms_verify_code'] ) and $_POST['wpsms_verify_code'] == $verify_code ) {
				// Verify user
				update_user_meta( $user->ID, 'wpsms_verified', 1 );

				// Redirect to profile
				wp_redirect( get_edit_user_link() );
				exit();
			}
		}

		// Redirect to login page
		wp_redirect( wp_login_url() . '?need_verify=yes' );
		exit();
	}
}

new WP_SMS_Pro_Wordpress();
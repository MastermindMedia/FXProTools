<?php

class smsapicom extends WP_SMS {
	private $wsdl_link = "https://api.smsapi.com/";
	public $tariff = "http://smsapi.com/";
	public $unitrial = true;
	public $unit;
	public $flash = "disable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->validateNumber = "e.g., 44xxxxxxxxxxxx";
		$this->has_key        = true;
	}

	public function SendSMS() {
		// Check gateway credit
		if ( is_wp_error( $this->GetCredit() ) ) {
			return new WP_Error( 'account-credit', __( 'Your account does not credit for sending sms.', 'wp-sms-pro' ) );
		}

		/**
		 * Modify sender number
		 *
		 * @since 3.4
		 *
		 * @param string $this ->from sender number.
		 */
		$this->from = apply_filters( 'wp_sms_from', $this->from );

		/**
		 * Modify Receiver number
		 *
		 * @since 3.4
		 *
		 * @param array $this ->to receiver number
		 */
		$this->to = apply_filters( 'wp_sms_to', $this->to );

		/**
		 * Modify text message
		 *
		 * @since 3.4
		 *
		 * @param string $this ->msg text message.
		 */
		$this->msg = apply_filters( 'wp_sms_msg', $this->msg );

		// Impload numbers
		$to = implode( ',', $this->to );

		// Unicide message
		$msg = urlencode( $this->msg );

		$response = wp_remote_get( $this->wsdl_link . 'sms.do?username=' . $this->username . '&password=' . $this->has_key . '&from=' . $this->from . '&to=' . $to . '&message=' . $msg );

		// Check gateway credit
		if ( is_wp_error( $response ) ) {
			return new WP_Error( 'send-sms', $response->get_error_message() );
		}

		$response_code = wp_remote_retrieve_response_code( $response );

		if ( $response_code == '200' ) {
			if ( strstr( $response['body'], 'OK' ) ) {
				return $response['body'];
			} else {
				return new WP_Error( 'send-sms', $response['body'] );
			}

			$this->InsertToDB( $this->from, $this->msg, $this->to );

			/**
			 * Run hook after send sms.
			 *
			 * @since 2.4
			 *
			 * @param string $result result output.
			 */
			do_action( 'wp_sms_send', $result );
		} else {
			return new WP_Error( 'send-sms', $response['body'] );
		}
	}

	public function GetCredit() {
		// Check username and password
		if ( ! $this->username or ! $this->password ) {
			return new WP_Error( 'account-credit', __( 'Username/Password does not set for this gateway', 'wp-sms-pro' ) );
		}

		if ( ! function_exists( 'curl_version' ) ) {
			return new WP_Error( 'required-function', __( 'CURL extension not found in your server. please enable curl extenstion.', 'wp-sms' ) );
		}

		$response = wp_remote_get( $this->wsdl_link . "user.do?username=" . $this->username . "&password=" . $this->has_key . "&credits=1" );

		// Check gateway credit
		if ( is_wp_error( $response ) ) {
			return new WP_Error( 'account-credit', $response->get_error_message() );
		}

		$response_code = wp_remote_retrieve_response_code( $response );

		if ( $response_code == '200' ) {
			if ( strstr( $response['body'], 'ERROR ' ) ) {
				return new WP_Error( 'account-credit', $response['body'] );
			} else {
				return $response['body'];
			}
		} else {
			return new WP_Error( 'account-credit', $response['body'] );
		}
	}
}
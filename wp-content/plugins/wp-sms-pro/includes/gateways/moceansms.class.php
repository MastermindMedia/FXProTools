<?php

class moceansms extends WP_SMS {
	private $wsdl_link = "";
	public $tariff = "http://www.moceansms.com/";
	public $unitrial = true;
	public $unit;
	public $flash = "enable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->validateNumber = "Phone number must include country code, for example, a Malaysian phone number will be like 60123456789.";

		require 'includes/moceansms/MoceanSMS.php';
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

		$moceansms_rest = new _MoceanSMS( $this->username, $this->password );
		$result         = json_decode( $moceansms_rest->sendSMS( $this->from, implode( ',', $this->to ), urlencode( $this->msg ) ) );

		if ( $result->status == 0 ) {
			$this->InsertToDB( $this->from, $this->msg, $this->to );

			/**
			 * Run hook after send sms.
			 *
			 * @since 2.4
			 *
			 * @param string $result result output.
			 */
			do_action( 'wp_sms_send', $result );

			return $result;
		} else {
			return new WP_Error( 'send-sms', $result );
		}
	}

	public function GetCredit() {
		// Check username and password
		if ( ! $this->username or ! $this->password ) {
			return new WP_Error( 'account-credit', __( 'Username/Password does not set for this gateway', 'wp-sms-pro' ) );
		}

		if ( ! function_exists( 'curl_init' ) ) {
			return new WP_Error( 'required-function', __( 'CURL extension not found in your server. please enable curl extenstion.', 'wp-sms' ) );
		}

		$moceansms_rest = new _MoceanSMS( $this->username, $this->password );
		$rest_response  = json_decode( $moceansms_rest->accountBalance() );

		if ( $rest_response->status != 0 ) {
			return new WP_Error( 'account-credit', $result );
		}

		return $rest_response->value;
	}
}
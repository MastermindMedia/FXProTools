<?php

class clickatell extends WP_SMS {
	private $wsdl_link = "http://api.clickatell.com/http/";
	public $tariff = "http://www.clickatell.com";
	public $unitrial = false;
	public $unit;
	public $flash = "enable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->has_key        = true;
		$this->help           = "";
		$this->validateNumber = "The mobile number to which the message must be delivered. The number should be in international number format (no leading zeros or + symbol should be used).";
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

		$clickatell = new Clickatell\Api\ClickatellHttp( $this->username, $this->password, $this->has_key );

		try {
			$response = $clickatell->sendMessage( $this->to, $this->msg );

			$this->InsertToDB( $this->from, $this->msg, $this->to );

			/**
			 * Run hook after send sms.
			 *
			 * @since 2.4
			 *
			 * @param string $response result output.
			 */
			do_action( 'wp_sms_send', $response );

			return $response;
		} catch ( Exception $e ) {
			return new WP_Error( 'send-sms', $e->getMessage() );
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

		$clickatell = new Clickatell\Api\ClickatellHttp( $this->username, $this->password, $this->has_key );

		try {
			$response = $clickatell->getBalance();

			return $response->balance;
		} catch ( Exception $e ) {
			return new WP_Error( 'account-credit', $e->getMessage() );
		}
	}
}
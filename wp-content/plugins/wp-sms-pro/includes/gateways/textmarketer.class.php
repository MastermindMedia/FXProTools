<?php

class textmarketer extends WP_SMS {
	private $wsdl_link = null;
	private $client = null;
	public $tariff = "https://www.textmarketer.co.uk";
	public $unitrial = true;
	public $unit;
	public $flash = "enable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->validateNumber = "e.g., 447777777777";
		$this->bulk_send      = false;
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

		$client = new \TextMarketer\Client( $this->username, $this->password, 'production' );

		try {
			$response = $client->sendSMS( $this->msg, $this->to[0], $this->from );

			$this->InsertToDB( $this->from, $this->msg, $this->to );

			/**
			 * Run hook after send sms.
			 *
			 * @since 2.4
			 *
			 * @param string $response response output.
			 */
			do_action( 'wp_sms_send', $response );

			return $response['status'];
		} catch ( Exception $e ) {
			return new WP_Error( 'send-sms', $e->getMessage() );
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

		try {
			$client = new \TextMarketer\Client( $this->username, $this->password, 'production' );
		} catch ( Exception $e ) {
			return new WP_Error( 'account-credit', $e->getMessage() );
		}

		try {
			$credits = $client->getCredits();

			return $credits;
		} catch ( Exception $e ) {
			return new WP_Error( 'account-credit', $e->getMessage() );
		}
	}
}
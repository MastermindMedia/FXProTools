<?php

class bulksms extends WP_SMS {
	private $wsdl_link = "https://bulksms.vsms.net/eapi/";
	public $tariff = "http://www.bulksms.com/int/";
	public $unitrial = true;
	public $unit;
	public $flash = "disable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->validateNumber = "e.g., 44123123456";
		$this->help           = 'Enter your EAPI URL to API key field. you can get that from > My Account > Settings > My Profile > EAPI URL';
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

		$bulkSms = new anlutro\BulkSms\BulkSmsService( $this->username, $this->password, rtrim( $this->has_key, 'eapi' ) );

		try {
			//$response = $bulkSms->sendMessage($this->to[0], $this->msg);

			foreach ( $this->to as $recipient ) {
				$messages[] = new anlutro\BulkSms\Message( $recipient, $this->msg );
			}

			$bulkSms->sendBulkMessages( $messages );

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

		$response = wp_remote_get( $this->has_key . "/user/get_credits/1/1.1?username={$this->username}&password={$this->password}" );

		// Check gateway credit
		if ( is_wp_error( $response ) ) {
			return new WP_Error( 'account-credit', $response->get_error_message() );
		}

		$response_code = wp_remote_retrieve_response_code( $response );

		if ( $response_code == '200' ) {
			if ( strstr( $response['body'], 'invalid ' ) ) {
				return new WP_Error( 'account-credit', $response['body'] );
			} else {
				return $response['body'];
			}
		} else {
			return new WP_Error( 'account-credit', $response['body'] );
		}
	}
}
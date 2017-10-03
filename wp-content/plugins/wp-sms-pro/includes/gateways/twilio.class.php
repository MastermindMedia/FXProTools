<?php

class twilio extends WP_SMS {
	public $tariff = "http://twilio.com/";
	public $unitrial = true;
	public $unit;
	public $flash = "enable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->validateNumber = "The destination phone number. Format with a '+' and country code e.g., +16175551212 (E.164 format).";
		$this->help           = "For configuration gateway, please use ACCOUNT SID and AUTH TOKEN instead username and password on following field.";
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

		$client = new Twilio\Rest\Client( $this->username, $this->password );

		try {
			$result = $client->messages->create(
				$this->to[0],
				array(
					'from' => $this->from,
					'body' => $this->msg,
				)
			);

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
			return new WP_Error( 'required-function', __( 'CURL extension not found in your server. please enable curl extension.', 'wp-sms' ) );
		}

		$client = new Twilio\Rest\Client( $this->username, $this->password );

		try {
			$account = $client->accounts( $this->username )->fetch();
			if ( $account->dateCreated->format( 'Y-m-d H:i:s' ) ) {
				return 1;
			}
		} catch ( Exception $e ) {
			return new WP_Error( 'account-credit', $e->getMessage() );
		}
	}
}
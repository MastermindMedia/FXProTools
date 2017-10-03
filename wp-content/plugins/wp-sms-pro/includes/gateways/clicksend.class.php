<?php

class clicksend extends WP_SMS {
	private $wsdl_link = "";
	public $tariff = "https://www.clicksend.com/";
	public $unitrial = false;
	public $unit;
	public $flash = "disable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->has_key        = true;
		$this->help           = "Enter your API key to API key field";
		$this->validateNumber = "Example +61411111111";
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

		// Prepare ClickSend client.
		try {
			$client = new \ClickSendLib\ClickSendClient( $this->username, $this->has_key );
		} catch ( \ClickSendLib\APIException $e ) {
			return new WP_Error( 'send-sms', $e->getResponseBody() );
		}

		try {
			// Get SMS instance.
			$sms = $client->getSMS();

			// The payload.
			foreach ( $this->to as $to ) {
				$messages[] = array(
					"source" => "php",
					"from"   => $this->from,
					"body"   => $this->msg,
					"to"     => $to,
					//"schedule" => 1536874701,
					//"custom_string" => "this is a test"
				);
			}

			// Send SMS.
			$response = $sms->sendSms( [ 'messages' => $messages ] );

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

		// Prepare ClickSend client.
		try {
			$client = new \ClickSendLib\ClickSendClient( $this->username, $this->has_key );
		} catch ( \ClickSendLib\APIException $e ) {
			return new WP_Error( 'account-credit', $e->getResponseBody() );
		}

		try {
			// Get Account instance.
			$account = $client->getAccount();

			// Get Account.
			$response = $account->getAccount();

			return $response->data->balance;
		} catch ( Exception $e ) {
			return new WP_Error( 'account-credit', $e->getMessage() );
		}
	}
}
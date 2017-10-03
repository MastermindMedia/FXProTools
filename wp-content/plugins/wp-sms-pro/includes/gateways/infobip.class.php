<?php

class infobip extends WP_SMS {
	private $wsdl_link = "https://api.infobip.com/";
	public $tariff = "http://infobip.com/";
	public $unitrial = true;
	public $unit;
	public $flash = "disable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->has_key        = true;
		$this->help           = "";
		$this->validateNumber = "Destination addresses must be in international format (Example: 41793026727).";
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

		// Initializing SendSingleTextualSms client with appropriate configuration
		$client = new infobip\api\client\SendSingleTextualSms( new infobip\api\configuration\BasicAuthConfiguration( $this->username, $this->password ) );

		// Creating request body
		$requestBody = new infobip\api\model\sms\mt\send\textual\SMSTextualRequest();
		$requestBody->setFrom( $this->from );
		$requestBody->setTo( [ $this->to[0] ] );
		$requestBody->setText( $this->msg );

		// Executing request
		try {
			$response        = $client->execute( $requestBody );
			$sentMessageInfo = $response->getMessages()[0];
			$this->InsertToDB( $this->from, $this->msg, $this->to );

			/**
			 * Run hook after send sms.
			 *
			 * @since 2.4
			 *
			 * @param string $sentMessageInfo result output.
			 */
			do_action( 'wp_sms_send', $sentMessageInfo );

			return $sentMessageInfo;
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

		// Initializing GetAccountBalance client with appropriate configuration
		try {
			$client = new infobip\api\client\GetAccountBalance( new infobip\api\configuration\BasicAuthConfiguration( $this->username, $this->password ) );
		} catch ( Exception $e ) {
			return new WP_Error( 'account-credit', $e->getMessage() );
		}

		// Executing request
		try {
			$response = $client->execute();

			return $response->getBalance();
		} catch ( Exception $e ) {
			$error = json_decode( $e->getMessage() );

			return new WP_Error( 'account-credit', $e->getMessage() );
		}
	}
}
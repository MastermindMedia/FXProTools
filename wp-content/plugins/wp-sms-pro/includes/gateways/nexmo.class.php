<?php

class nexmo extends WP_SMS {
	private $wsdl_link = "https://rest.nexmo.com/";
	public $tariff = "https://www.nexmo.com/";
	public $unitrial = true;
	public $unit;
	public $flash = "enable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->help           = "For configuration gateway, please use key and secret instead username and password on following field.";
		$this->validateNumber = "Country specific features: https://docs.nexmo.com/messaging/sms-api/building-global-apps#DLRSupport";
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

		$client = new Nexmo\Client( new Nexmo\Client\Credentials\Basic( $this->username, $this->password ) );

		try {
			$result = $client->message()->send( [
				'to'   => $this->to[0],
				'from' => $this->from,
				'text' => $this->msg
			] );

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
		return true;
	}
}
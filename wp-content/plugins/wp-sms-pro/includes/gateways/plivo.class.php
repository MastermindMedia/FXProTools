<?php

class plivo extends WP_SMS {
	private $wsdl_link = null;
	private $client = null;
	private $http;
	public $tariff = "http://plivo.com/";
	public $unitrial = true;
	public $unit;
	public $flash = "enable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->help           = "For configuration gateway, please use AUTH_ID and AUTH_TOKEN instead username and password on following field.";
		$this->validateNumber = "The number to which the message will be sent. Be sure that all phone numbers include country code, area code, and phone number without spaces or dashes (e.g., 14153336666).";
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

		$plivo = new Plivo\RestAPI( $this->username, $this->password );

		$params = array(
			'src'  => $this->from,
			'dst'  => $this->to[0],
			'text' => $this->msg
		);

		try {
			$response = $plivo->send_message( $params );

			if ( ! $response['response'] ) {
				return new WP_Error( 'send-sms', $response['response']['message'] );
			} else {
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
			}
		} catch ( Exception $e ) {
			return new WP_Error( 'send-sms', $e->getMessage() );
		}
	}

	public function GetCredit() {
		// Check username and password
		if ( ! $this->username or ! $this->password ) {
			return new WP_Error( 'account-credit', __( 'Username/Password does not set for this gateway', 'wp-sms-pro' ) );
		}

		$plivo = new Plivo\RestAPI( $this->username, $this->password );

		try {
			$response = $plivo->get_account();
			if ( ! $response['response'] ) {
				return new WP_Error( 'account-credit', false );
			} else {
				return $response['response']['cash_credits'];
			}
		} catch ( Exception $e ) {
			return new WP_Error( 'account-credit', $e->getMessage() );
		}
	}
}
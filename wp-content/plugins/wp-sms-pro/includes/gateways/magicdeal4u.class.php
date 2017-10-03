<?php

class magicdeal4u extends WP_SMS {
	private $wsdl_link = "http://sms.magicdeal4u.com/smsapi/";
	public $tariff = "http://www.magicdeal4u.com/";
	public $unitrial = false;
	public $unit;
	public $flash = "enable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->validateNumber = "";
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

		$to     = implode( $this->to, "," );
		$msg    = urlencode( $this->msg );
		$result = file_get_contents( $this->wsdl_link . "pushsms.aspx?user=" . $this->username . "&pwd=" . $this->password . "&to=" . $to . "&sid=" . $this->from . "&msg=" . $msg . "&fl=0&gwid=2" );

		if ( $result ) {
			$this->InsertToDB( $this->from, $this->msg, $this->to );

			/**
			 * Run hook after send sms.
			 *
			 * @since 2.4
			 *
			 * @param string $result result output.
			 */
			do_action( 'wp_sms_send', $result );

			return true;
		} else {
			return new WP_Error( 'send-sms', $result );
		}

	}

	public function GetCredit() {
		// Check username and password
		if ( ! $this->username or ! $this->password ) {
			return new WP_Error( 'account-credit', __( 'Username/Password does not set for this gateway', 'wp-sms-pro' ) );
		}

		$result = file_get_contents( $this->wsdl_link . "CheckBalance.aspx?user=" . $this->username . "&password=" . $this->password . "&gwid=1" );

		return preg_replace( '/[^0-9]+/', '', $result );
	}
}
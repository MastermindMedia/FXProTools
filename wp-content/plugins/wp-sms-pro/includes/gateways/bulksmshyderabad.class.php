<?php

class bulksmshyderabad extends WP_SMS {
	private $wsdl_link = "http://tra.bulksmshyderabad.co.in/";
	public $tariff = "http://bulksmshyderabad.co.in/";
	public $unitrial = false;
	public $unit;
	public $flash = "enable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->validateNumber = "981XXXXXXX";
		$this->has_key        = false;
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

		$to  = implode( ',', $this->to );
		$msg = urlencode( $this->msg );

		//$result = file_get_contents("{$this->wsdl_link}pushsms.php?username={$this->username}&password={$this->password}&message={$msg}&sender={$this->from}&numbers={$to}");
		$result = file_get_contents( $this->wsdl_link . "websms/sendsms.aspx?userid=" . $this->username . "&password=" . $this->password . "&sender=" . $this->from . "&mobileno=" . $to . "&msg=" . $msg );

		if ( preg_match( "/YOUR SMS HAS BEEN SENT/", $result ) ) {
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

		return true;
	}
}
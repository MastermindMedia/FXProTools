<?php

class msg91 extends WP_SMS {
	private $wsdl_link = "https://control.msg91.com/api/";
	public $tariff = "http://www.msg91.com";
	public $unitrial = false;
	public $unit;
	public $flash = "enable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();

		$this->has_key = true;
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

		$result = file_get_contents( $this->wsdl_link . "sendhttp.php?authkey=" . $this->has_key . "&mobiles=" . $to . "&message=" . $msg . "&sender=" . $this->from . "&route=4" );

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

		$result = file_get_contents( $this->wsdl_link . "balance.php?authkey=" . $this->has_key . "&type=1" );

		if ( is_object( json_decode( $result ) ) ) {
			$result = json_decode( $result );
			if ( $result->msgType == 'error' ) {
				return new WP_Error( 'account-credit', print_r( $result, 1 ) );
			}
		}

		return $result;
	}
}
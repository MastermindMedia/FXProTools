<?php

class cpsms extends WP_SMS {
	private $wsdl_link = "https://www.cpsms.dk/";
	public $tariff = "http://www.cpsms.dk/";
	public $unitrial = false;
	public $unit;
	public $flash = "enable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->validateNumber = "xxxxxxxx";
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

		$msg = urlencode( $this->msg );
		$msg = str_replace( "%C3%A6", "�", $msg );
		$msg = str_replace( "%C3%B8", "�", $msg );
		$msg = str_replace( "%C3%A5", "�", $msg );
		$msg = str_replace( "%C3%86", "�", $msg );
		$msg = str_replace( "%C3%98", "�", $msg );
		$msg = str_replace( "%C3%85", "�", $msg );

		foreach ( $this->to as $to ) {
			$result = file_get_contents( $this->wsdl_link . "sms/?from=" . $this->from . "&recipient=" . $to . "&message=" . $msg . "&username=" . $this->username . "&password=" . $this->password . "&flash=" . $this->isflash . "" );
		}

		if ( strpos( $result, 'succes' ) ) {
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

		$result = file_get_contents( "{$this->wsdl_link}remote/saldo.php?username={$this->username}&password={$this->password}" );

		if ( strstr( $result, 'error' ) ) {
			return new WP_Error( 'account-credit', $result );
		} else {
			return $result;
		}
	}
}
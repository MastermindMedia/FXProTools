<?php

class clockworksms extends WP_SMS {
	private $wsdl_link = "";
	public $tariff = "http://www.clockworksms.com/";
	public $unitrial = true;
	public $unit;
	public $flash = "enable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->validateNumber = "44xxxxxxxxxx";

		require 'includes/clockworksms/class-Clockwork.php';
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

		$clockwork      = new Clockwork( $this->username );
		$clockwork->ssl = false;

		foreach ( $this->to as $items ) {
			$to[] = array( 'to' => $items, 'message' => $this->msg );
		}

		try {
			$result = $clockwork->send( $to );

			if ( $result['success'] ) {
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
		} catch ( Exception $e ) {
			return new WP_Error( 'send-sms', $e->getMessage() );
		}
	}

	public function GetCredit() {
		// Check username and password
		if ( ! $this->username ) {
			return new WP_Error( 'account-credit', __( 'Username/Password does not set for this gateway', 'wp-sms-pro' ) );
		}

		if ( ! class_exists( 'DOMDocument' ) ) {
			return new WP_Error( 'required-class', __( 'Class DOMDocument not found in your php.', 'wp-sms' ) );
		}

		try {
			$clockwork      = new Clockwork( $this->username );
			$clockwork->ssl = false;
			$result         = $clockwork->checkBalance();

			return $result['balance'];
		} catch ( Exception $e ) {
			return new WP_Error( 'account-credit', $e->getMessage() );
		}
	}
}

?>
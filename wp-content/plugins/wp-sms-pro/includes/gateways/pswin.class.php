<?php

class pswin extends WP_SMS {
	private $wsdl_link = "https://gw2-fro.pswin.com:8443";
	public $tariff = "https://pswin.com/";
	public $unitrial = false;
	public $unit;
	public $flash = "enable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
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
		$url = $this->wsdl_link;

		// Writing XML Document
		$xml[] = "<?xml version=\"1.0\"?>";
		$xml[] = "<!DOCTYPE SESSION SYSTEM \"pswincom_submit.dtd\">";
		$xml[] = "<SESSION>";
		$xml[] = "<CLIENT>" . $this->username . "</CLIENT>";
		$xml[] = "<PW>" . $this->password . "</PW>";
		$xml[] = "<SD>gw2xmlhttpspost</SD>";
		$xml[] = "<MSGLST>";
		foreach ( $this->to as $number ) {
			$xml[] = "<MSG>";
			$xml[] = "<TEXT>" . $this->msg . "</TEXT>";
			$xml[] = "<RCV>" . $number . "</RCV>";
			$xml[] = "<SND>" . $this->from . "</SND>";
			$xml[] = "<RCPREQ>Y</RCPREQ>";
			$xml[] = "</MSG>";
		}
		$xml[] = "</MSGLST>";
		$xml[] = "</SESSION>";

		$xmldocument = join( "\r\n", $xml ) . "\r\n\r\n";

		$params = array(
			'http' => array(
				'method'  => 'POST',
				'header'  => "Content-type: application/xml;\r\n" . "Content-Length: " . strlen( $xmldocument ) . "\r\n",
				'content' => $xmldocument
			)
		);

		$ctx = stream_context_create( $params );
		$fp  = @fopen( $url, 'rb', false, $ctx );

		if ( ! $fp ) {
			return new WP_Error( 'send-sms', "Problem with $url, $php_errormsg" );
		}

		$result = @stream_get_contents( $fp );

		if ( $result === true ) {
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
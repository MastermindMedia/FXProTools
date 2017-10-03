<?php

class websms extends WP_SMS {
	private $wsdl_link = "https://api.websms.com/";
	public $tariff = "http://www.websms.at";
	public $unitrial = false;
	public $unit;
	public $flash = "enable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->validateNumber = "4367612345678";
		$this->has_key        = true;

		require 'includes/websms/WebSmsCom_Toolkit.inc';
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

		try {
			// 1.) -- create sms client (once) ------
			$smsClient = new WebSmsCom_Client( $this->username, $this->password, $this->wsdl_link );

			// 2.) -- create text message ----------------
			$message = new WebSmsCom_TextMessage( $this->to, $this->msg );

			// 3.) -- send message ------------------
			$Response = $smsClient->send( $message, 1, false );

			// show success
			$result = array(
				"Status          : " . $Response->getStatusCode(),
				"StatusMessage   : " . $Response->getStatusMessage(),
				"TransferId      : " . $Response->getTransferId(),
				"ClientMessageId : " . ( ( $Response->getClientMessageId() ) ?
					$Response->getClientMessageId() : '<NOT SET>'
				),
			);

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
			}

			// catch everything that's not a successfully sent message
		} catch ( WebSmsCom_ParameterValidationException $e ) {
			return new WP_Error( 'send-sms', $e->getMessage() );

		} catch ( WebSmsCom_AuthorizationFailedException $e ) {
			return new WP_Error( 'send-sms', $e->getMessage() );

		} catch ( WebSmsCom_ApiException $e ) {
			return new WP_Error( 'send-sms', $e->getMessage() );

		} catch ( WebSmsCom_HttpConnectionException $e ) {
			return new WP_Error( 'send-sms', $e->getMessage() );

		} catch ( WebSmsCom_UnknownResponseException $e ) {
			return new WP_Error( 'send-sms', $e->getMessage() );

		} catch ( Exception $e ) {
			return new WP_Error( 'send-sms', $e->getMessage() );
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
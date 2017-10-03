<?php

class ssdindia extends WP_SMS {
	private $wsdl_link = "http://sms.ssdindia.com";
	public $tariff = "http://ssdindia.com";
	public $unitrial = false;
	public $unit;
	public $flash = "enable";
	public $isflash = false;

	public function __construct() {
		parent::__construct();
		$this->validateNumber = "919999999999";
		$this->has_key        = true;
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

		//Define route 
		$route = "default";

		//Prepare you post parameters
		$postData = array(
			'authkey' => $this->has_key,
			'mobiles' => implode( ',', $this->to ),
			'message' => urlencode( $this->msg ),
			'sender'  => $this->from,
			'route'   => $route
		);

		//API URL
		$url = $this->wsdl_link . "/sendhttp.php";

		// init the resource
		$ch = curl_init();
		curl_setopt_array( $ch, array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST           => true,
			CURLOPT_POSTFIELDS     => $postData
			//,CURLOPT_FOLLOWLOCATION => true
		) );

		//Ignore SSL certificate verification
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );

		//get response
		$result = curl_exec( $ch );

		if ( ! curl_errno( $ch ) ) {
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

		$result = @file_get_contents( "http://sms.ssdindia.com/api/balance.php?authkey=" . $this->has_key . "&type=1" );
		$json   = json_decode( $result );

		if ( $json->msgType == 'error' ) {
			return new WP_Error( 'account-credit', $result );
		} else {
			return $json;
		}
	}
}
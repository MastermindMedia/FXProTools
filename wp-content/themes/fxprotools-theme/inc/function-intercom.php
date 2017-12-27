<?php

use Intercom\IntercomClient;

class CPSIntercom {

	const ACCESS_TOKEN = 'dG9rOmUxMzMyODcyX2UxMGRfNDZmOF84ZjM5XzY4MTc1MWJiNTBmNzoxOjA=';
	const SECRET_KEY = 'l_-sHsUYbgK3VTBs9AoKgG7kBc1fMAT7fnEgIt1A';
	const HASH = 'sha256';

	private $client;

	private function __construct() {
		$this->client = new IntercomClient(self::ACCESS_TOKEN, null);
	}
	
	/**
	 * @param $user
	 *
	 * @return false|null|string
	 */
	public static function get_user_intercom_HMAC( $user ) {
		if ( $user ) {
			return hash_hmac(
				self::HASH, // hash function
				$user->user_email,
				self::SECRET_KEY
			);
		}
		return null;
	}
}


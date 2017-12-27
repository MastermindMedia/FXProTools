<?php

use Intercom\IntercomClient;
use Intercom\IntercomUsers;
use Intercom\IntercomLeads;
use GuzzleHttp\Exception\GuzzleException;

class CPSIntercom {

	const ACCESS_TOKEN = 'dG9rOmUxMzMyODcyX2UxMGRfNDZmOF84ZjM5XzY4MTc1MWJiNTBmNzoxOjA=';
	const SECRET_KEY = 'l_-sHsUYbgK3VTBs9AoKgG7kBc1fMAT7fnEgIt1A';
	const HASH = 'sha256';

	/** @var array  */
	private $userRoles = [
		'administrator',
		'editor',
		'author',
		'contributor',
		'shop_manager',
		'group_leader',
		'business_admin',
		'business_director',
	];

	/** @var array  */
	private $leadRoles = [
		'subscriber',
		'customer',
		'holding_member',
		'afl_member',
		'afl_customer',
	];

	/** @var IntercomClient  */
	private $client;

	/**
	 * CPSIntercom constructor.
	 */
	public function __construct() {
		$this->client = new IntercomClient( self::ACCESS_TOKEN, null );
		add_action( 'user_register', [ $this, 'add_user_to_intercom' ] );
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

	/**
	 * Creates an intercom account
	 * @param $user_id
	 */
	public function add_user_to_intercom( $user_id ) {
		if ( ! empty( $_POST ) ) {
			extract( $_POST );
			$user_data = [
				'email'      => $email,
				'id'         => $user_id,
				'user_login' => $user_login,
				'first_name' => $first_name,
				'last_name'  => $last_name,
			];
			if ( in_array( $role, $this->leadRoles ) ) {
				$user = new IntercomUsers( $this->client );
				try {
					$user->create( $user_data );
				} catch ( GuzzleException $e ) {
					error_log( $e );
				}
			}

			if ( in_array( $role, $this->userRoles ) ) {
				$lead = new IntercomLeads( $this->client );
				try {
					$lead->create( $user_data );
				} catch ( GuzzleException $e ) {
					error_log( $e );
				}
			}
		}
	}
}

//return new CPSIntercom();


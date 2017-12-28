<?php

use Intercom\IntercomClient;
use Intercom\IntercomUsers;
use Intercom\IntercomLeads;
use Intercom\IntercomEvents;
use GuzzleHttp\Exception\GuzzleException;

class CPSIntercom {

	const ACCESS_TOKEN = 'dG9rOmUxMzMyODcyX2UxMGRfNDZmOF84ZjM5XzY4MTc1MWJiNTBmNzoxOjA=';
	const SECRET_KEY = 'l_-sHsUYbgK3VTBs9AoKgG7kBc1fMAT7fnEgIt1A';
	const HASH = 'sha256';

	/** @var array */
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

	/** @var array */
	private $leadRoles = [
		'subscriber',
		'customer',
		'holding_member',
		'afl_member',
		'afl_customer',
	];

	/** @var IntercomClient */
	private $client;

	/**
	 * CPSIntercom constructor.
	 */
	public function __construct() {
		$this->client = new IntercomClient( self::ACCESS_TOKEN, null );
		add_action( 'user_register', [ $this, 'add_user_to_intercom' ] );
		add_action( 'profile_update', [ $this, 'intercom_update_user' ] );
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
	 *
	 * @param $user_id int
	 */
	public function add_user_to_intercom( $user_id ) {
		if ( ! empty( $_POST ) ) {
			/**
			 * @var $role string
			 */
			extract( $_POST );
			if ( in_array( $role, $this->userRoles ) ) {
				$user = new IntercomUsers( $this->client );

				$user_data = $this->generateData();

				try {
					$user->create( $user_data );

				} catch ( GuzzleException $e ) {
					error_log( $e->getMessage() );
				}

				$this->createEvent( 'register-user', $user_id );
				return;
			}

			if ( in_array( $role, $this->leadRoles ) ) {
				$lead = new IntercomLeads( $this->client );

				$lead_data = $this->generateData( 'lead' );
				try {
					$lead->create( $lead_data );
				} catch ( GuzzleException $e ) {
					error_log( $e->getMessage() );
				}
				$this->createEvent( 'register-lead', $user_id );
				return;
			}
		}
	}

	/**
	 * @param $event_name
	 * @param $user_id
	 */
	private function createEvent( $event_name, $user_id ) {
		$event = new IntercomEvents( $this->client );
		try {
			$event->create( [
				'event_name' => $event_name,
				'created_at' => strtotime( "now" ),
				'user_id'    => $user_id,
			] );
		} catch ( GuzzleException $e ) {
			error_log( $e->getMessage() );
		}
	}

	/**
	 * @param string $type
	 *
	 * @return array
	 */
	private function generateData( $type = 'user' ) {
		$data = [];
		switch ( $type ) {
			case 'user' :
				if ( ! empty( $_POST ) ) {
					/**
					 * @var $email string
					 * @var $user_id string
					 * @var $first_name string
					 * @var $last_name string
					 */
					extract( $_POST );
					$data = [
						'email'        => $email,
						/** @var $user_id string */
						'user_id'      => $user_id,
						'name'         => $first_name . ' ' . $last_name,
						'signed_up_at' => strtotime( "now" ),
					];
				}
				break;
			case 'lead':
				if ( ! empty( $_POST ) ) {
					/**
					 * @var $email string
					 * @var $first_name string
					 * @var $last_name string
					 */
					extract( $_POST );
					$data = [
						'email' => $email,
						'name'  => $first_name . ' ' . $last_name,
					];
				}
				break;

		}

		return $data;
	}

	/**
	 * @param $user_id int
	 */
	public function intercom_update_user( $user_id ) {
		$user_info = get_userdata( $user_id );
		if ( isset( $_GET['test'] ) ) {
			var_dump( $user_info->data );
			var_dump( get_user_meta( $user_id ) );
			exit;
		}
	}
}

return new CPSIntercom();


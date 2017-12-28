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
	const INTERCOM_ID_USER_META = '_intercom_user_id';

	/** @var array */
	private $user_roles = [
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
	private $lead_roles = [
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
			if ( in_array( $role, $this->user_roles ) ) {
				$user_data = $this->generate_data( 'user', $user_id );
				$intercomUser = $this->create_user( $user_data );
				add_user_meta( $user_id, self::INTERCOM_ID_USER_META, $intercomUser->id );
				$this->create_event( 'register-user', $user_id );
				return;
			}

			if ( in_array( $role, $this->lead_roles ) ) {
				$lead = new IntercomLeads( $this->client );

				$lead_data = $this->generate_data( 'lead' );
				try {
					$lead->create( $lead_data );
				} catch ( GuzzleException $e ) {
					error_log( $e->getMessage() );
				}
				$this->create_event( 'register-lead', $user_id );
				return;
			}
		}
	}

	private function create_user( array $data ) {
		$user = new IntercomUsers( $this->client );
		try {
			/** @var IntercomUsers */
			return $user->create( $data );
		} catch ( GuzzleException $e ) {
			error_log( $e->getMessage() );
		}
	}

	/**
	 * @param $event_name
	 * @param $user_id
	 */
	private function create_event( $event_name, $user_id ) {
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
	 * @param null $user_id
	 *
	 * @return array
	 */
	private function generate_data( $type, $user_id = null ) {
		$data = [];

		/**
		 * @var $email string
		 * @var $first_name string
		 * @var $last_name string
		 */
		extract( $_POST );

		switch ( $type ) {
			case 'user' :
				if ( ! empty( $_POST ) ) {
					$data = [
						'email'        => $email,
						'user_id'      => $user_id,
						'name'         => $first_name . ' ' . $last_name,
						'signed_up_at' => strtotime( "now" ),
					];
				}
				break;
			case 'lead':
				if ( ! empty( $_POST ) ) {
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
		$user_data = get_userdata( $user_id );
		$user_meta = $this->parse_user_meta( $user_id );
		$user_onboard_checklist = $this->get_onboard_checklist( $user_id );
		$user_info = array_merge( (array) $user_data->data, $user_meta, $user_onboard_checklist );

		$intercom_data = $this->arrange_intercom_data( $user_info );
		$intercomUser = $this->create_user( $intercom_data );

		if ( ! isset( $user_meta[ self::INTERCOM_ID_USER_META ] ) ) {
			add_user_meta( $user_id, self::INTERCOM_ID_USER_META, $intercomUser->id );
		}

		$this->create_event( 'update-profile', $user_id );
	}

	private function parse_user_meta( $user_id ) {
		$user_meta = get_user_meta( $user_id );
		$data = [];
		foreach ( $user_meta as $meta_key => $value ) {
			$data[ $meta_key ] = $value[0];
		}

		return $data;
	}

	private function arrange_intercom_data( $data ) {
		return [
			'user_id'           => $data['ID'],
			'email'             => $data['user_email'],
			'name'              => sprintf( '%s %s', $data['first_name'], $data['last_name'] ),
			'phone'             => $data['phone_number'],
			'signed_up_at'      => strtotime( $data['user_registered'] ),
			'custom_attributes' => $this->get_custom_attributes( $data ),
		];
	}

	private function get_custom_attributes( array $data ) {
		return [
			'nickname'                    => $data['nickname'],
			'first_name'                  => $data['first_name'],
			'last_name'                   => $data['last_name'],
			'user_sms_subs'               => $data['user_sms_subs'],
			'user_email_subs'             => $data['user_email_subs'],
			'billing_company'             => $data['billing_company'],
			'billing_address_2'           => $data['billing_address_2'],
			'billing_city'                => $data['billing_city'],
			'billing_state'               => $data['billing_state'],
			'billing_postcode'            => $data['billing_postcode'],
			'shipping_company'            => $data['shipping_company'],
			'shipping_address_1'          => $data['shipping_address_1'],
			'shipping_address_2'          => $data['shipping_address_2'],
			'shipping_city'               => $data['shipping_city'],
			'shipping_state'              => $data['shipping_state'],
			'shipping_postcode'           => $data['shipping_postcode'],
			'website'                     => $data['website'],
			'facebook'                    => $data['facebook'],
			'twitter'                     => $data['twitter'],
			'googleplus'                  => $data['googleplus'],
			'uid'                         => $this->get_uid( $data ),
			'checklist_verified_email'    => $data['verified_email'],
			'checklist_verified_profile'  => $data['verified_profile'],
			'checklist_scheduled_webinar' => $data['scheduled_webinar'],
			'checklist_accessed_products' => $data['accessed_products'],
			'checklist_got_shirt'         => $data['got_shirt'],
			'checklist_shared_video'      => $data['shared_video'],
			'checklist_referred_friend'   => $data['referred_friend'],
		];
	}

	private function get_uid( $data ) {
		return home_url( '/intercom-switch' ) . '/?uid=' . $data['ID'];
	}

	private function get_onboard_checklist( $user_id ) {
		return get_user_meta( $user_id, ONBOARD_CHECKLIST_META_KEY, true );
	}
}

return new CPSIntercom();

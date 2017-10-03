<?php

/**
 * WP SMS Pro buddypress
 *
 * @category   class
 * @package    WP_SMS_Pro
 * @version    1.0
 */
class WP_SMS_Pro_Buddypress {

	public $sms;
	public $options;

	public function __construct() {
		global $wpsms_pro_option, $sms;

		$this->sms     = $sms;
		$this->options = $wpsms_pro_option;

		if ( isset( $this->options['bp_mobile_field'] ) ) {
			global $wpdb, $table_prefix;
			$result = $wpdb->query( $wpdb->prepare( "SELECT * FROM {$table_prefix}bp_xprofile_fields WHERE name = %s", 'Mobile' ) );

			if ( ! $result ) {
				add_action( 'bp_init', array( &$this, 'add_field' ) );
			}
		}

		if ( isset( $this->options['bp_mention_enable'] ) ) {
			add_action( 'bp_activity_sent_mention_email', array( &$this, 'mention_notification' ), 10, 5 );
		}

		if ( isset( $this->options['bp_comments_reply_enable'] ) ) {
			add_action( 'bp_activity_sent_reply_to_update_email', array(
				&$this,
				'comments_reply_notification'
			), 10, 6 );
		}
	}

	// Mobile field
	public function add_field() {
		global $bp;
		$xfield_args = array(
			'field_group_id' => 1,
			'name'           => 'Mobile',
			'description'    => __( 'Your mobile number for get sms', 'wp-sms-pro' ),
			'can_delete'     => true,
			'field_order'    => 1,
			'is_required'    => false,
			'type'           => 'textbox'
		);

		xprofile_insert_field( $xfield_args );
	}

	// Buddypress mention
	public function mention_notification( $activity, $subject, $message, $content, $receiver_user_id ) {
		// Get user mobile
		$user_mobile = $this->get_mobile( $receiver_user_id );

		// Check the mobile
		if ( ! $user_mobile ) {
			return;
		}

		$user_posted    = get_userdata( $activity->user_id );
		$user_receiver  = get_userdata( $receiver_user_id );
		$template_vars  = array(
			'%posted_user_display_name%'   => $user_posted->display_name,
			'%primary_link%'               => $activity->primary_link,
			'%time%'                       => $activity->date_recorded,
			'%message%'                    => $content,
			'%receiver_user_display_name%' => $user_receiver->display_name,
		);
		$message        = str_replace( array_keys( $template_vars ), array_values( $template_vars ), $this->options['bp_mention_message'] );
		$this->sms->to  = array( $user_mobile );
		$this->sms->msg = $message;
		$this->sms->SendSMS();
	}

	// Buddypress comments
	public function comments_reply_notification( $user_id, $subject, $message, $comment_id, $commenter_id, $params ) {
		// Get user mobile
		$user_mobile = $this->get_mobile( $user_id );

		// Check the mobile
		if ( ! $user_mobile ) {
			return;
		}

		$user_posted    = get_userdata( $params['user_id'] );
		$user_receiver  = get_userdata( $user_id );
		$template_vars  = array(
			'%posted_user_display_name%'   => $user_posted->display_name,
			'%comment%'                    => $params['content'],
			'%receiver_user_display_name%' => $user_receiver->display_name,
		);
		$message        = str_replace( array_keys( $template_vars ), array_values( $template_vars ), $this->options['bp_comments_reply_message'] );
		$this->sms->to  = array( $user_mobile );
		$this->sms->msg = $message;
		$this->sms->SendSMS();
	}

	// Get Buddypress mobile value
	private function get_mobile( $user_id ) {
		global $wpdb, $table_prefix;
		$field = $wpdb->get_row( $wpdb->prepare( "SELECT `id` FROM {$table_prefix}bp_xprofile_fields WHERE name = %s", 'Mobile' ) );

		if ( $field ) {
			$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table_prefix}bp_xprofile_data WHERE field_id = %d AND user_id = %d", $field->id, $user_id ) );

			if ( ! $result ) {
				return;
			}

			return $result->value;
		}
	}
}

new WP_SMS_Pro_Buddypress();
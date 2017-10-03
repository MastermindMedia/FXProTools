<?php

/**
 * WP SMS Pro buddypress
 *
 * @category   class
 * @package    WP_SMS_Pro
 * @version    1.0
 */
class WP_SMS_Pro_WPJobManager {

	public $sms;
	public $options;

	public function __construct() {
		global $wpsms_pro_option, $sms;

		$this->sms     = $sms;
		$this->options = $wpsms_pro_option;

		// Check mobile field status
		if ( isset( $this->options['job_mobile_field'] ) ) {
			add_filter( 'submit_job_form_fields', array( $this, 'add_mobile_field' ) );
			add_filter( 'job_manager_job_listing_data_fields', array( $this, 'add_mobile_field_admin' ) );
		}

		// Check display mobile number status
		if ( isset( $this->options['job_display_mobile_number'] ) ) {
			add_filter( 'single_job_listing_meta_end', array( $this, 'display_mobile_number' ) );
		}

		// Check if notify new cv is activate
		if ( isset( $this->options['job_notify_cv_status'] ) ) {
			add_action( 'wp_insert_post', array( $this, 'notify_new_cv' ), 10, 3 );
		}

		// Check if employer notify is activate
		if ( isset( $this->options['job_notify_employer_cv_status'] ) ) {
			add_action( 'edit_post', array( $this, 'notify_employer_cv' ), 10, 3 );
		}
	}

	/**
	 * Add mobile field to frontend
	 *
	 * @param $fields
	 *
	 * @return mixed
	 */
	public function add_mobile_field( $fields ) {
		$fields['job']['job_mobile'] = array(
			'label'       => __( 'Mobile number', 'wp-sms-pro' ),
			'type'        => 'text',
			'required'    => true,
			'placeholder' => sprintf( __( 'e.g. %s', 'wp-sms-pro' ), $this->sms->validateNumber ),
			'priority'    => 7
		);

		return $fields;
	}

	/**
	 * Add mobile field to admin
	 *
	 * @param $fields
	 *
	 * @return mixed
	 */
	public function add_mobile_field_admin( $fields ) {
		$fields['_job_mobile'] = array(
			'label'       => __( 'Mobile number', 'wp-sms-pro' ),
			'type'        => 'text',
			'placeholder' => sprintf( __( 'e.g. %s', 'wp-sms-pro' ), $this->sms->validateNumber ),
			'description' => ''
		);

		return $fields;
	}

	/**
	 * Display mobile number in single job page
	 */
	public function display_mobile_number() {
		global $post;
		$mobile = get_post_meta( $post->ID, '_job_mobile', true );

		if ( $mobile ) {
			echo sprintf( __( '<li>Mobile: %s</li>', 'wp-sms-pro' ), esc_html( $mobile ) );
		}
	}

	/**
	 * Notify for new CV
	 *
	 * @param $post_id
	 * @param $post
	 * @param $update
	 */
	public function notify_new_cv( $post_id, $post, $update ) {
		// If this is a revision or the post type is not job_listing return
		if ( wp_is_post_revision( $post_id ) or $post->post_type != 'job_listing' or $post->post_status != 'pending' ) {
			return;
		}

		if ( empty( $this->options['job_notify_cv_receiver'] ) or empty( $this->options['job_notify_cv_message'] ) ) {
			return;
		}

		// Get job type
		$job_type = wp_get_post_terms( $post_id, 'job_listing_type' );
		if ( $job_type ) {
			$job_type_name = $job_type[0]->name;
		} else {
			$job_type_name = '';
		}

		$template_vars = array(
			'%job_id%'          => $post->ID,
			'%job_title%'       => $post->post_title,
			'%job_description%' => $post->post_content,
			'%job_location%'    => get_post_meta( $post_id, '_job_location', true ),
			'%job_type%'        => $job_type_name,
			'%job_mobile%'      => get_post_meta( $post_id, '_job_mobile', true ),
			'%company_name%'    => get_post_meta( $post_id, '_company_name', true ),
			'%website%'         => get_post_meta( $post_id, '_company_website', true ),
		);
		$message       = str_replace( array_keys( $template_vars ), array_values( $template_vars ), $this->options['job_notify_cv_message'] );

		$this->sms->to  = array( $this->options['job_notify_cv_receiver'] );
		$this->sms->msg = $message;
		$this->sms->SendSMS();
	}

	/**
	 * Notify to Employer
	 *
	 * @param $post_id
	 * @param $post
	 *
	 * @internal param $update
	 */
	public function notify_employer_cv( $post_id, $post ) {
		// If this is a revision or the post type is not job_listing return
		if ( wp_is_post_revision( $post_id ) or $post->post_type != 'job_listing' or $post->post_status != 'publish' ) {
			return;
		}

		if ( empty( $this->options['job_notify_employer_cv_message'] ) ) {
			return;
		}

		$mobile = get_post_meta( $post_id, '_job_mobile', true );
		if ( ! $mobile ) {
			return;
		}

		// Get job type
		$job_type = wp_get_post_terms( $post_id, 'job_listing_type' );
		if ( $job_type ) {
			$job_type_name = $job_type[0]->name;
		} else {
			$job_type_name = '';
		}

		$template_vars = array(
			'%job_id%'          => $post->ID,
			'%job_title%'       => $post->post_title,
			'%job_description%' => $post->post_content,
			'%job_location%'    => get_post_meta( $post_id, '_job_location', true ),
			'%job_type%'        => $job_type_name,
			'%company_name%'    => get_post_meta( $post_id, '_company_name', true ),
			'%website%'         => get_post_meta( $post_id, '_company_website', true ),
		);
		$message       = str_replace( array_keys( $template_vars ), array_values( $template_vars ), $this->options['job_notify_employer_cv_message'] );

		$this->sms->to  = array( $mobile );
		$this->sms->msg = $message;
		$this->sms->SendSMS();
	}
}

new WP_SMS_Pro_WPJobManager();
<?php

/**
 * WP SMS Pro quform
 *
 * @category   class
 * @package    WP_SMS_Pro
 * @version    1.0
 */
class WP_SMS_Pro_Quform {

	public $sms;
	public $options;

	public function __construct() {
		global $wpsms_pro_option, $sms;

		$this->sms     = $sms;
		$this->options = $wpsms_pro_option;

		add_action( 'iphorm_pre_process', array( &$this, 'notification_form' ) );
	}

	public function notification_form() {
		// Send to custom number
		if ( $this->options[ 'qf_notify_enable_form_' . $_REQUEST['iphorm_id'] ] ) {
			$this->sms->to  = array( $this->options[ 'qf_notify_receiver_form_' . $_REQUEST['iphorm_id'] ] );
			$template_vars  = array(
				'%post_title%'    => $_REQUEST['post_title'],
				'%form_url%'      => $_REQUEST['form_url'],
				'%referring_url%' => $_REQUEST['referring_url'],
			);
			$message        = str_replace( array_keys( $template_vars ), array_values( $template_vars ), $this->options[ 'qf_notify_message_form_' . $_REQUEST['iphorm_id'] ] );
			$this->sms->msg = $message;
			$this->sms->SendSMS();
		}

		// Send to field value
		if ( $this->options[ 'qf_notify_enable_field_form_' . $_REQUEST['iphorm_id'] ] ) {
			$this->sms->to  = array( $_REQUEST[ 'iphorm_' . $_REQUEST['iphorm_id'] . '_' . $this->options[ 'qf_notify_receiver_field_form_' . $_REQUEST['iphorm_id'] ] ] );
			$template_vars  = array(
				'%post_title%'    => $_REQUEST['post_title'],
				'%form_url%'      => $_REQUEST['form_url'],
				'%referring_url%' => $_REQUEST['referring_url'],
			);
			$message        = str_replace( array_keys( $template_vars ), array_values( $template_vars ), $this->options[ 'qf_notify_message_field_form_' . $_REQUEST['iphorm_id'] ] );
			$this->sms->msg = $message;
			$this->sms->SendSMS();
		}
	}

	static function get_field( $form_id ) {
		if ( ! $form_id ) {
			return;
		}

		$fields = iphorm_get_all_forms();

		if ( ! $fields ) {
			return;
		}

		foreach ( $fields as $field ) {
			if ( $field['id'] == $form_id ) {
				if ( $field['elements'] ) {
					foreach ( $field['elements'] as $element ) {
						$option_field[ $element['id'] ] = $element['label'];
					}

					return $option_field;
				}
			}
		}

		return;
	}
}

new WP_SMS_Pro_Quform();
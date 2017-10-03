<?php

/**
 * WP SMS Pro gateways
 *
 * @category   class
 * @package    WP_SMS_Pro
 * @version    1.0
 */
class WP_SMS_Pro_Gateywas {
	public function __construct() {
		add_filter( 'wpsms_gateway_list', array( &$this, 'modify_gateway' ) );
	}

	public function modify_gateway( $gateways ) {
		$gateways['premium'] = array(
			'twilio'           => 'twilio.com',
			'plivo'            => 'plivo.com',
			'clickatell'       => 'clickatell.com',
			'bulksms'          => 'bulksms.com',
			'infobip'          => 'infobip.com',
			'nexmo'            => 'nexmo.com',
			'clockworksms'     => 'clockworksms.com',
			'clicksend'        => 'clicksend.com',
			'smsapicom'        => 'smsapi.com',
			'dsms'             => 'dsms.in',
			'esms'             => 'esms.vn',
			'isms'             => 'isms.com.my',
			'dot4all'          => 'sms4marketing.it',
			'magicdeal4u'      => 'magicdeal4u.com',
			'mobily'           => 'mobily.ws',
			'moceansms'        => 'moceansms.com',
			'msg91'            => 'msg91.com',
			'livesms'          => 'livesms.eu',
			'ozioma'           => 'ozioma.net',
			'pswin'            => 'pswin.com',
			'ra'               => 'ra.sa',
			'smsfactor'        => 'smsfactor.com',
			'textmarketer'     => 'textmarketer.co.uk',
			'smslive247'       => 'smslive247.com',
			'sendsms247'       => 'sendsms247.com',
			'ssdindia'         => 'ssdindia.com',
			'viensms'          => 'viensms.com',
			'vsms'             => 'vsms.club',
			'websms'           => 'websms.at',
			'smstrade'         => 'smstrade.de',
			'bulksmshyderabad' => 'bulksmshyderabad.co.in',
			'yamamah'          => 'yamamah.com',
			'cellsynt'         => 'cellsynt.net',
			'cmtelecom'        => 'cmtelecom.com',
			'cpsms'            => 'cpsms.dk',
		);

		return $gateways;
	}
}

new WP_SMS_Pro_Gateywas();
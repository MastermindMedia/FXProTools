<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
define('GOTOWEBINAR_USERID', 'fxprotools@gmail.com');
define('GOTOWEBINAR_PASSWORD', 'Admin4web');
define('GOTOWEBINAR_CONSUMERKEY', 'aInr3HOEuTfGxGW7PF9yD90AGzIehCj5');
define('TWILIO_ACCOUNT_SID', 'ACeed6641354498872901ff6aa63342ac1');
define('TWILIO_TOKEN', '6924aec30f4903169f928a1d8c65886b');
/**
 * For autoloading classes
 * */
spl_autoload_register('apyc_fxprotools_autoload_class');
function apyc_fxprotools_autoload_class($class_name){
    if ( false !== strpos( $class_name, 'Apyc' ) ) {
		$include_classes_dir = realpath( get_template_directory( __FILE__ ) ) .'/inc'. DIRECTORY_SEPARATOR;
		$admin_classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR;
		$class_file = str_replace( '_', DIRECTORY_SEPARATOR, $class_name ) . '.php';
		//echo $include_classes_dir . $class_file.'<br>';
		if( file_exists($include_classes_dir . $class_file) ){
			require_once $include_classes_dir . $class_file;
		}
		if( file_exists($admin_classes_dir . $class_file) ){
			require_once $admin_classes_dir . $class_file;
		}
	}
}
if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}
if ( ! function_exists('apyc_get_token')) {
   function apyc_get_token ( )  {
	try{
		$res = Apyc_Citrix_GoToWebinar_DirectLogin::get_instance()->login();
		Apyc_Model_DBToken::get_instance()->access_token('u', $res);
		return Apyc_Model_DBToken::get_instance()->access_token('r');
	}catch(Exception $e){
		write_log('get access token error : ' . $e->getMessage());
		return false;
	}
   }
}
if ( ! function_exists('apyc_get_all_webinars')) {
   function apyc_get_all_webinars ( )  {
		try{
			return Apyc_Citrix_GoToWebinar_GetAll::get_instance()->get();
		}catch(Exception $e){
			write_log('get access token error : ' . $e->getMessage());
			return false;
		}
   }
}
if ( ! function_exists('apyc_get_all_webinars_cache')) {
   function apyc_get_all_webinars_cache ($rest = false)  {
		try{
			return Apyc_Citrix_GoToWebinar_GetAll::get_instance()->cache($rest);
		}catch(Exception $e){
			write_log('get access token error : ' . $e->getMessage());
			return false;
		}
   }
}
if ( ! function_exists('apyc_get_access_token')) {
   function apyc_get_access_token ( )  {
		$get = Apyc_Model_DBToken::get_instance()->access_token('r');
		if( !$get ){
			return apyc_get_token();
		}
		return $get;
   }
}
if ( ! function_exists('apyc_create_registrant')) {
   function apyc_create_registrant($webinarKey, $body)  {
		try{
			return Apyc_Citrix_GoToWebinar_CreateRegistrant::get_instance()->create($webinarKey, $body);
		}catch(Exception $e){
			write_log('create registrant error : ' . $e->getMessage());
			return false;
		}
   }
}
if ( ! function_exists('apyc_get_webinar_free')) {
   function apyc_get_webinar_free($arg)  {
		try{
			$defaults = array(
				'filter_by_subject' => 'Weekly Q & A'
			);
			$query_args = wp_parse_args( $arg, $defaults );
			$get = Apyc_Citrix_GoToWebinar_GetAll::get_instance()->query($query_args);
			return $get;
		}catch(Exception $e){
			write_log('get free webinar error : ' . $e->getMessage());
			return false;
		}
   }
}
/**
* Will get user group with mobile only
* @see Apyc_User
* @param $group	array | string
* @return Apyc_User | Array
* 	sample return
*	array(
*		id => User ID,
*		name => name,
*		mobile => mobile_number,
*	)
**/
if ( ! function_exists('apyc_get_usergroup_withmobile')) {
   function apyc_get_usergroup_withmobile($group = array())  {
		if( !empty($group) ){
			$user = new Apyc_User;
			return $user->getGroupWithMobileNumber($group);
		}
		return false;
   }
}
/**
* Send SMS
* @param	$arg	array	
* 					default | sample array
*					array(
*						'sending_to' 	=> array of User Roles | Default to array('Customer', 'Distributor'),
*						'msg'			=> String | message for SMS,
*						'from_number'	=> Optional	| if empty it will auto get the from number to API,
*						'send_to'		=> default to  apyc_get_usergroup_withmobile, follow the format
*											on function apyc_get_usergroup_withmobile return
*					)
* @return Apyc_SendSMS
**/
if ( ! function_exists('apyc_send_sms')) {
   function apyc_send_sms($arg = array())  {
		$sending_to = array('Customer', 'Distributor');
		if( isset($arg['sending_to']) 
			&& !empty($arg['sending_to'])
		){
			$sending_to = $arg['sending_to'];
		}
		
		$msg = '';
		if( isset($arg['msg']) 
			&& trim($arg['msg']) != ''
		){
			$msg = $arg['msg'];
		}
		
		$from_number = '';
		if( isset($arg['from_number'])
			&& trim($arg['from_number']) != '' 
		){
			$from_number = $arg['from_number'];
		}
		
		$send_to = apyc_get_usergroup_withmobile(array('sending_to'=>$sending_to));
		if( isset($arg['send_to'])
			&& !empty($arg['send_to'])
		){
			$send_to = $arg['send_to'];
		}
		$arg = array(
			'msg' => $msg,
			'from_number' => $from_number,
			'send_to' => $send_to
		);
		//dd($arg);
		//ready to send sms
		//$send_sms = new Apyc_SendSMS;
		//return $send_sms->send($user_query)
   }
}
function apyc_fxprotools_setup(){
	Apyc_Modal::get_instance();
	Apyc_SMSPage::get_instance();
}
add_action( 'after_setup_theme', 'apyc_fxprotools_setup' );
function apyc_init(){
	$arg_group = array(
		'sending_to' => array('Customer','Distributor'),
		'msg' => 'Hello from Twilio',
	);
	dd($arg_group);
	apyc_send_sms($arg_group);
	exit();
}
//add_action('init', 'apyc_init');
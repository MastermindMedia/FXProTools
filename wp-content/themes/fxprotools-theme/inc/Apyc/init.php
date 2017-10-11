<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
define('GOTOWEBINAR_USERID', 'fxprotools@gmail.com');
define('GOTOWEBINAR_PASSWORD', 'Admin4web');
define('GOTOWEBINAR_CONSUMERKEY', 'aInr3HOEuTfGxGW7PF9yD90AGzIehCj5');
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
* @return Apyc_User
**/
if ( ! function_exists('apyc_get_usergroup_withmobile')) {
   function apyc_get_usergroup_withmobile()  {
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
function apyc_fxprotools_setup(){
	Apyc_Modal::get_instance();
}
add_action( 'after_setup_theme', 'apyc_fxprotools_setup' );
function apyc_init(){
	$_arg = array( 
		'role__in' => array(
			'Customer', 
			'Distributor', 
			'Subscriber'
		),
		'meta_query' => array(
			'key'	=> 'mobile',
			'value' => 'EXISTS'
		)
	);
	$arg = array(
		'role__in' => array(
			'Customer', 
			'Distributor', 
			'Subscriber'
		),
		'meta_query' => array(
			array(
				'key'     => 'mobile',
				'value' => '',
				'compare' => '!='
			),
		)
	);
	$user_query = new WP_User_Query($arg);
	//$blogusers = get_users( [ 'role__in' => [ 'Customer', 'Distributor' ] ] );
	$author_info = get_userdata( 2918 );
	dd($user_query);
	dd($author_info);
	//use Twilio\Rest\Client;

	// Your Account Sid and Auth Token from twilio.com/user/account
	$sid = "ACeed6641354498872901ff6aa63342ac1";
	$token = "6924aec30f4903169f928a1d8c65886b";
	$client = new Twilio\Rest\Client($sid, $token);

	// Get an object from its sid. If you do not have a sid,
	// check out the list resource examples on this page
	// You can call $client->account to access the authenticated account
	// you used to initialize the client.
	// Use $client->account->fetch() to get the instance
	$account = $client->api
		->accounts("ACeed6641354498872901ff6aa63342ac1")
		->fetch();

	dd($account);
}
function apyc_user(){
	$arg = array('sending_to'=>array('Customer'));
	Apyc_User::get_instance()->getWithMobileNumber($arg);
}
add_action('init', 'apyc_user');
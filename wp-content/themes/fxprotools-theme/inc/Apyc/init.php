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
function apyc_fxprotools_setup(){
	//$token = apyc_get_token();
	//print_r($token);
	$body = array(
		'lastName' => 'Casilum',
		'firstName' => 'Allan',
		'email' => 'allan@mail.com',
	);
	$create = apyc_create_registrant('530845699094496258', $body);
	//$get = apyc_get_all_webinars_cache();
	echo '<pre>';
	print_r($create);
	echo '</pre>';
	exit();
}
//add_action( 'after_setup_theme', 'apyc_fxprotools_setup' );
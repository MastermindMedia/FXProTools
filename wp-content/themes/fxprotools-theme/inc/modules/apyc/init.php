<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
//http://php.net/manual/en/timezones.others.php
//date_default_timezone_set('America/New_York');
date_default_timezone_set('Asia/Manila');
/*define('GOTOWEBINAR_USERID', 'volishon@gmail.com');
define('GOTOWEBINAR_PASSWORD', 'Password123');
define('GOTOWEBINAR_CONSUMERKEY', '1HcxAF4IGb4wQmTphYYldWHIcwNBhEF6');*/
define('GOTOWEBINAR_USERID', 'allan.paul.casilum@gmail.com');
define('GOTOWEBINAR_PASSWORD', 'a4p1y2c5');
define('GOTOWEBINAR_CONSUMERKEY', '22tCPrVm7hhgAihDRFsFZarudvnUv858');
/*define('GOTOWEBINAR_FREE_GROUP', 'FREE Weekly Q&A');
define('GOTOWEBINAR_PAID_GROUP', 'Weekly Live Trading');*/
define('GOTOWEBINAR_FREE_GROUP', 'test 1');
define('GOTOWEBINAR_PAID_GROUP', 'test 2');
define('TWILIO_ACCOUNT_SID', 'ACeed6641354498872901ff6aa63342ac1');
define('TWILIO_TOKEN', '6924aec30f4903169f928a1d8c65886b');
define('ASSETS_JS_PATH', get_bloginfo('template_url') . '/assets/js/theme/custom/');
define('TEMPLATE_PATH', 'inc/templates/');
/**
 * For autoloading classes
 * */
spl_autoload_register('apyc_fxprotools_autoload_class');
function apyc_fxprotools_autoload_class($class_name){
    if ( false !== strpos( $class_name, 'Apyc' ) ) {
		$include_classes_dir = realpath( get_template_directory( __FILE__ ) ) .'/inc/modules/'. DIRECTORY_SEPARATOR;
		$admin_classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR;
		$class_file = str_replace( '_', DIRECTORY_SEPARATOR, $class_name ) . '.php';
		//echo $class_name.'-'.$include_classes_dir . strtolower($class_file).'<br>';
		if( file_exists($include_classes_dir . strtolower($class_file)) ){
			//echo $class_name.'-'.$include_classes_dir . strtolower($class_file).'<br>';
			require_once $include_classes_dir . strtolower( $class_file );
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
//gotowebinar related functions
require_once plugin_dir_path( __FILE__ ) . 'functions-gotowebinar.php';
//sms/twilio related functions
require_once plugin_dir_path( __FILE__ ) . 'functions-sms.php';

function apyc_fxprotools_setup(){
	if( method_exists('Apyc_Modal','get_instance') ){
		Apyc_Modal::get_instance();
	}
	if( method_exists('Apyc_SMSPage','get_instance') ){
		Apyc_SMSPage::get_instance();
	}
	if( method_exists('Apyc_Coaching','get_instance') ){
		Apyc_Coaching::get_instance();
	}
}
add_action( 'wp_loaded', 'apyc_fxprotools_setup' );
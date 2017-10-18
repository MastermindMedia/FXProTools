<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
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
if ( ! function_exists('apyc_get_upcoming_webinars')) {
   function apyc_get_upcoming_webinars ( )  {
		try{
			$query_args = array(
				'get_webinar' => 'upcoming'
			);
			return Apyc_Citrix_GoToWebinar_GetAll::get_instance()->query($query_args);
		}catch(Exception $e){
			write_log('get access token error : ' . $e->getMessage());
			return false;
		}
   }
}
if ( ! function_exists('apyc_get_all_webinars')) {
   function apyc_get_all_webinars ( )  {
		try{
			$query_args = array(
				'get_webinar' => 'all'
			);
			return Apyc_Citrix_GoToWebinar_GetAll::get_instance()->query($query_args);
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
			$ret = Apyc_Citrix_GoToWebinar_CreateRegistrant::get_instance()->create($webinarKey, $body);
			write_log('create registrant : ' . $ret);
			return $ret;
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
				'filter_by_subject' => GOTOWEBINAR_FREE_GROUP
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
if ( ! function_exists('apyc_get_webinar_paid')) {
   function apyc_get_webinar_paid($arg)  {
		try{
			$defaults = array(
				'filter_by_subject' => GOTOWEBINAR_PAID_GROUP
			);
			$query_args = wp_parse_args( $arg, $defaults );
			$get = Apyc_Citrix_GoToWebinar_GetAll::get_instance()->query($query_args);
			return $get;
		}catch(Exception $e){
			write_log('get paid webinar error : ' . $e->getMessage());
			return false;
		}
   }
}
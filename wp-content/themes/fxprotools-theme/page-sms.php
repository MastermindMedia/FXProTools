<?php 
get_header();
//url action, we get the state of the url query string, to perform
$action = isset($_GET['action']) ? $_GET['action']:'';
//holds data to pass to template
$data = array();

switch($action){
	default:
		$data['title'] = _('SMS Marketing');
		$data['sub_heading'] = _('Sub Heading Here');
		Apyc_View::get_instance()->view_theme('inc/Apyc/view/sms/main.php', $data);
	break;
}

get_footer(); ?>
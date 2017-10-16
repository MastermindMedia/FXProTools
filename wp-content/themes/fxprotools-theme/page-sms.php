<?php 
get_header();
//url action, we get the state of the url query string, to perform
$action = isset($_GET['action']) ? $_GET['action']:'';
//holds data to pass to template
$data = array();

$view = new Apyc_View;
$theme_js = $view->get_assets_js_theme();
$template = $view->get_view_templates();
$data['view_theme_js'] = $theme_js;
$data['view_template'] = $template;
$data['obj_view'] = $view;

switch($action){
	default:
		$data['title'] = _('SMS Marketing');
		$data['sub_heading'] = _('Sub Heading Here');

		$view->view_theme($template . 'sms/main.php', $data);
	break;
}

get_footer(); ?>
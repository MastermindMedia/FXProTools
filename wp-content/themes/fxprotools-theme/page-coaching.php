<?php
get_header();

$product_id = 50; 
$product = wc_get_product( $product_id );
//url action, we get the state of the url query string, to perform
$action = isset($_GET['_action']) ? $_GET['_action']:'';
//holds data to pass to template
$data = array();

$view = new Apyc_View;
$theme_js = $view->get_assets_js_theme();
$template = $view->get_view_templates();
$data['view_theme_js'] = $theme_js;
$data['view_template'] = $template;
$data['obj_view'] = $view;

if ( apyc_has_active_user_subscription() || current_user_can('administrator')  ) : 
	get_template_part('inc/templates/nav-products'); 
	
	switch($action){
		default:
			$data['title'] = _('Coaching / Webinars');
			$data['sub_heading'] = _('Check Below For Your Coaching Webinars');
			
			$view->view_theme($template . 'coaching/main.php', $data);
		break;
	}
else: 
	get_template_part('inc/templates/no-access'); 
endif; 

get_footer(); 
?>
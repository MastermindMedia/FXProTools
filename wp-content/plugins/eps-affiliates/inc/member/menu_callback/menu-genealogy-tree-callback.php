<?php 
function afl_genealogy_tree() {
	echo afl_eps_page_header();
	echo afl_content_wrapper_begin();
	afl_genealogy_tree_callback();
	echo afl_content_wrapper_end();
	// define( 'EPSAFFILIATE_PLUGIN_PLAN', plugin_dir_url('eps-affiliates/inc/plan'));
}

function afl_genealogy_tree_callback() {
	wp_enqueue_style( 'plan-heirarchy', EPSAFFILIATE_PLUGIN_PLAN.'/matrix/css/heirarchy/css/hierarchy-view.css');
	wp_enqueue_style( 'plan-style', EPSAFFILIATE_PLUGIN_PLAN.'matrix/css/heirarchy/css/main.css');


	// wp_enqueue_style( 'plan-style', EPSAFFILIATE_PLUGIN_PLAN.'matrix/css/tree-new/style.css');
	$path = EPSAFFILIATE_PLUGIN_PLAN.'matrix/';
	afl_get_template('plan/matrix/genealogy-tree-all.php');
}
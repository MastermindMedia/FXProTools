<?php 
function afl_admin_variable_configurations (){
	echo afl_eps_page_header();
	echo afl_content_wrapper_begin();
		afl_admin_config_variable_form(afl_variable_tabs());
	echo afl_content_wrapper_end();
}
/*
 * ------------------------------------------------------------
 * Variable configuration tabs
 * ------------------------------------------------------------
*/
 function afl_variable_tabs () {
 	$tabs = array();
 	$tabs['system_variables'] = array(
 		'page_callback' => 'afl_system_variables_form',
 		'title'					=> 'System Variables'
 	);	
 	$tabs['payment_methods'] = array(
 		'page_callback' => 'afl_payment_methods_form',
 		'title'					=> 'Payment Methods'
 	);
 		$tabs['widget_var'] = array(
 		'page_callback' => 'afl_widget_settings_form',
 		'title'					=> 'Widgets Settings'
 	);
 	return apply_filters('eps_affiliates_system_variable_tabs',$tabs);
 }
/*
 * ------------------------------------------------------------
 * Variable config form
 * ------------------------------------------------------------
*/
 function afl_admin_config_variable_form ($tabs) {
 		_accurate_knowledge_notice();
	 	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'system_variables';  
		  //here render the tabs
		  echo '<ul class="tabs--primary nav nav-tabs">';

		  foreach ($tabs as $key => $value) {
		  	echo '<li class="'.(($active_tab == $key) ? 'active' : '').'">
		            	<a href="?page=affiliate-eps-variable-configurations&tab='.$key.'" >'.$value['title'].'</a>  
		          </li>';
		  }

		  echo '</ul>';
		  if (isset($active_tab)) {
		  	$function = $tabs[$active_tab]['page_callback'];
		  	$function();
		  }
 }
/*
 * ------------------------------------------------------------
 * System variables form
 * ------------------------------------------------------------
*/
 function afl_system_variables_form () {
 		if (isset($_POST['submit'])) {
 			$variables = $_POST;
 			unset($variables['submit']);
 			afl_system_variables_form_submit($variables);
 		}

 		$form = array();
 		$form['#method'] = 'post';
		$form['#action'] = $_SERVER['REQUEST_URI'];
		$form['#prefix'] ='<div class="form-group row">';
	 	$form['#suffix'] ='</div>';

	 	//payment source
	 	$form['afl_payment_sources'] = array(
	 		'#type' 					=> 'text-area',
	 		'#title' 					=> 'Payment Sources',
	 		'#default_value' 	=> afl_variable_get('afl_payment_sources', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>',

	 	);
	 	//Member status
	 	$form['member_status'] = array(
	 		'#type' 					=> 'text-area',
	 		'#title' 					=> 'Member status',
	 		'#default_value' 	=> afl_variable_get('member_status', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>'
	 	);

	 	//compensation periods
	 	$form['periods'] = array(
	 		'#type' 					=> 'text-area',
	 		'#title' 					=> 'Periods',
	 		'#default_value' 	=> afl_variable_get('periods', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>'
	 	);
	 	//credit status
	 	$form['afl_var_credit_status'] = array(
	 		'#type' 					=> 'text-area',
	 		'#title' 					=> 'Credit status',
	 		'#default_value' 	=> afl_variable_get('afl_var_credit_status', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>'
	 	);


	 	global $wp_roles;
	  $all_roles 			= $wp_roles->roles;
	 	$editable_roles = apply_filters('editable_roles', $all_roles);
	 	$roles_keys = '';
	 	foreach ($editable_roles as $key => $value) {
	  		$roles_keys .=' | '.$key;
	  }
 		$form['afl_var_permission_table_roles_markup'] = array(
	 		'#type' 					=> 'markup',
	 		'#markup' 				=> '<div class="panel panel-primary">
     													<div class="panel-body text-dark">
     														<strong class="text-primary"> System Available Roles : </strong><strong>'.$roles_keys.'</strong>
     													</div>
     												</div>',
	 	);
	 	//Permission table roles
	 	$form['afl_var_permission_table_roles'] = array(
	 		'#type' 					=> 'text-area',
	 		'#title' 					=> 'Permission Table Included Roles',
	 		'#default_value' 	=> afl_variable_get('afl_var_permission_table_roles', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>',
	 		'#description'		=> __('these roles could be displayed in the eps affiliates roles permission table')
	 	);
	 	$form['submit'] = array(
	 		'#type' => 'submit',
	 		'#value' =>'Save configuration'
	 	);
	 	echo afl_render_form($form);
 }

function afl_system_variables_form_submit ($form_state) {
	foreach ($form_state as $key => $value) {
		afl_variable_set($key, maybe_serialize($value));
	}
	echo wp_set_message('Configuration has been saved successfully', 'success');
}
/*
 * ------------------------------------------------------------
 * Payment methods  variable form
 * ------------------------------------------------------------
*/
function afl_payment_methods_form(){
	if (isset($_POST['submit'])) {
 			$variables = $_POST;
 			unset($variables['submit']);
 			if (afl_payment_methods_form_validation($variables)) {
 				afl_payment_methods_form_submit($variables);
 			}
 		}

 		$form = array();
 		$form['#method'] = 'post';
		$form['#action'] = $_SERVER['REQUEST_URI'];
		$form['#prefix'] ='<div class="form-group row">';
	 	$form['#suffix'] ='</div>';

	 	$form['payment_methods'] = array(
	 		'#type' 					=> 'text-area',
	 		'#required'				=> TRUE,
	 		'#title' 					=> 'Payment Methods',
	 		'#description' 		=> 'Format : &lt;value&gt;|&lt;name&gt;  Example : 1|Highest',
	 		'#default_value' 	=> afl_variable_get('payment_methods', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>'
	 	);

	 	$form['payout_methods'] = array(
	 		'#type' 					=> 'text-area',
	 		'#title' 					=> 'Payout Methods',
	 		'#required'				=> TRUE,
	 		'#description' 		=> 'Format : &lt;value&gt;|&lt;name&gt;  Example : 1|Highest',
	 		'#default_value' 	=> afl_variable_get('payout_methods', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>'
	 	);
	 	$form['payout_status'] = array(
	 		'#type' 					=> 'text-area',
	 		'#required'				=> TRUE,
	 		'#title' 					=> 'Payout/Request Status',
	 		'#description' 		=> 'Format : &lt;value&gt;|&lt;name&gt;  Example : 1|Highest',
	 		'#default_value' 	=> afl_variable_get('payout_status', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>'
	 	);
	 	$form['paid_status'] = array(
	 		'#type' 					=> 'text-area',
	 		'#title' 					=> 'Paid Status',
	 		'#required'				=> TRUE,
	 		'#description' 		=> 'Format : &lt;value&gt;|&lt;name&gt;  Example : 1|Highest',
	 		'#default_value' 	=> afl_variable_get('paid_status', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>'
	 	);
	 	$form['payout_type'] = array(
	 		'#type' 					=> 'text-area',
	 		'#title' 					=> 'Payout Type',
	 		'#required'				=> TRUE,
	 		'#description' 		=> 'Format : &lt;value&gt;|&lt;name&gt;  Example : 1|Highest',
	 		'#default_value' 	=> afl_variable_get('payout_type', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>'
	 	);
	 	$form['payout_categories'] = array(
	 		'#type' 					=> 'text-area',
	 		'#title' 					=> 'Payout Categories',
	 		'#required'				=> TRUE,
	 		'#description' 		=> 'Format : &lt;value&gt;|&lt;name&gt;  Example : 1|Highest',
	 		'#default_value' 	=> afl_variable_get('payout_categories', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>'
	 	);
	 	$form['submit'] = array(
	 		'#type' => 'submit',
	 		'#value' =>'Save configuration'
	 	);
	 	echo afl_render_form($form);
}
function afl_payment_methods_form_validation ($form_state = array()) {
	$rules = array();

	foreach ($form_state as $key => $value) {
		$rules[] = array(
		 	'value'=> $value,
	 		'name' => $key,
	 		'field'=> $key,
	 		'rules' => array(
	 			'rule_required',
	 		)
	 	);
	}

	return set_form_validation_rule($rules);
}

function afl_payment_methods_form_submit($form_state){
foreach ($form_state as $key => $value) {
		afl_variable_set($key, maybe_serialize($value));
	}
	echo wp_set_message('Configuration has been saved successfully', 'success');
}


/*
 * ---------------------------------------------------------------------
 * Widgets variables
 * ---------------------------------------------------------------------
*/
 function afl_widget_settings_form (){
 		if (isset($_POST['submit'])) {
 			$variables = $_POST;
 			unset($variables['submit']);
 			$validation = afl_widget_settings_form_validation($variables);
 			if ( $validation ) {
 				afl_widget_settings_form_submit($variables);
 			}
 		}

 		$form = array();
 		$form['#method'] = 'post';
		$form['#action'] = $_SERVER['REQUEST_URI'];
		$form['#prefix'] ='<div class="form-group row">';
	 	$form['#suffix'] ='</div>';

	 	$form['afl_widgets_ewallet_visible_valu'] = array(
	 		'#type' 					=> 'select',
	 		'#options' 				=> array(
	 			'd' => 'Today',
	 			'm' =>'This Month',
	 			'y' => 'This Year',
	 			't'	=> 'Overall'
	 		),
	 		'#title' 					=> 'E-Wallet visible type (Grid Panel) ',
	 		'#default_value' 	=> afl_variable_get('afl_widgets_ewallet_visible_valu', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>',
	 		'#required' 			=> TRUE
	 	);

	 	$form['afl_widgets_total_debit_visible_valu'] = array(
	 		'#type' 					=> 'select',
	 		'#options' 				=> array(
	 			'd' => 'Today',
	 			'm' =>'This Month',
	 			'y' => 'This Year',
	 			't'	=> 'Overall'
	 		),
	 		'#title' 					=> 'Expense visible type (Grid Panel) ',
	 		'#default_value' 	=> afl_variable_get('afl_widgets_total_debit_visible_valu', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>',
	 		'#required' 			=> TRUE

	 	);

	 	$form['afl_widgets_total_credit_visible_valu'] = array(
	 		'#type' 					=> 'select',
	 		'#options' 				=> array(
	 			'd' => 'Today',
	 			'm' =>'This Month',
	 			'y' => 'This Year',
	 			't'	=> 'Overall'
	 		),
	 		'#title' 					=> 'Income visible type (Grid Panel) ',
	 		'#default_value' 	=> afl_variable_get('afl_widgets_total_credit_visible_valu', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>',
	 		'#required' 			=> TRUE

	 	);

	 	$form['afl_widgets_downline_members_visible_valu'] = array(
	 		'#type' 					=> 'select',
	 		'#options' 				=> array(
	 			'd' => 'Today',
	 			'm' =>'This Month',
	 			'y' => 'This Year',
	 			't'	=> 'Overall'
	 		),
	 		'#title' 					=> 'Downline members visible type (Grid Panel) ',
	 		'#default_value' 	=> afl_variable_get('afl_widgets_downline_members_visible_valu', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>',
	 		'#required' 			=> TRUE

	 	);

	 	$form['afl_widgets_transaction_c_visible_valu'] = array(
	 		'#type' 					=> 'select',
	 		'#options' 				=> array(
	 			'd' => 'Daily',
	 			'm' =>'Monthly',
	 			'y' => 'Yearly',
	 		),
	 		'#title' 					=> 'Transaction visible type (Chart)  ',
	 		'#default_value' 	=> afl_variable_get('afl_widgets_transaction_c_visible_valu', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>',
	 		'#required' 			=> TRUE

	 	);
	 	$options = array();
	 	for ( $i = 5;$i<=50; $i=$i+5) {
	 		$options[$i] = $i;
	 	}
	 	$form['afl_widgets_transaction_c_max_list'] = array(
	 		'#type' 					=> 'select',
	 		'#options' 				=> $options,
	 		'#title' 					=> 'Maximum number of transaction list',
	 		'#default_value' 	=> afl_variable_get('afl_widgets_transaction_c_max_list', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>',
	 		'#required' 			=> TRUE

	 	);

	 	$form['afl_widgets_downline_members_c_visible_valu'] = array(
	 		'#type' 					=> 'select',
	 		'#options' 				=> array(
	 			'd' => 'Daily',
	 			'm' =>'Monthly',
	 			'y' => 'Yearly',
	 		),
	 		'#title' 					=> 'Downline members visible type (Chart)',
	 		'#default_value' 	=> afl_variable_get('afl_widgets_downline_members_c_visible_valu', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>',
	 		'#required' 			=> TRUE

	 	);

	 	$form['afl_widgets_downline_members_c_max_list'] = array(
	 		'#type' 					=> 'select',
	 		'#options' 				=> $options,
	 		'#title' 					=> 'Maximum number of downline members list ',
	 		'#default_value' 	=> afl_variable_get('afl_widgets_downline_members_c_max_list', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>',
	 		'#required' 			=> TRUE

	 	);

	 	$form['recent_transaction_chart_colors'] = array(
	 		'#type' 					=> 'text',
	 		'#title' 					=> 'Recent transaction chart element color',
	 		'#default_value' 	=> afl_variable_get('recent_transaction_chart_colors', ''),
	 		'#prefix'					=> '<div class="form-group row">',
	 		'#suffix' 				=> '</div>',
	 		'#required' 			=> TRUE

	 	);

	 	$form['submit'] = array(
	 		'#type' => 'submit',
	 		'#value'=>' Save configuration'
	 	);
	 	echo afl_render_form($form);

 }

 function afl_widget_settings_form_validation ($form_state = array()) {
 		$rules = array();


 		foreach ($form_state as $key => $value) {
	 		$rules[] = array(
		 		'value'	=> $value,
		 		'name' 	=> str_replace('_', ' ', $key),
		 		'field' => $key,
		 		'rules' => array(
		 			'rule_required',
		 		)
		 	);
 		}

 		$resp  = set_form_validation_rule($rules);
	 	return $resp;
 }

function afl_widget_settings_form_submit ($form_state = array()) {
	foreach ($form_state as $key => $value) {
		afl_variable_set($key, maybe_serialize($value));
	}
	echo wp_set_message('Configuration has been saved successfully', 'success');
}
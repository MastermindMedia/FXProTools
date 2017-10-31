<?php 

function afl_system_genealogy_configurations () {
	echo afl_eps_page_header();
		new Afl_enque_scripts('common');
	

	$post = array();
	if (isset($_POST['submit']) ){
		$rules = array();
		//create rules
		$rules[] = array(
	 		'value'=>$_POST['root_user'],
	 		'name' =>'root user',
	 		'rules' => array(
	 			'rule_required',
	 		)
	 	);
	 	//validating fields with rules
	 	$resp  = set_form_validation_rule($rules);
	 	if ($resp) {
	 		//set the root user and reset genealogy
	 		afl_genealogy_configuration_form_submit($_POST);
	 		echo wp_set_message('Configuration has been saved successfully', 'success');
	 	}
	}

	afl_genealogy_configuration_form($post);
}

/*
 * --------------------------------------------------------
 * Genealogy configurations form callback
 * --------------------------------------------------------
*/
function afl_genealogy_configuration_form ($post) {
	afl_content_wrapper_begin();
	$form = array();
	$form['#action'] = $_SERVER['REQUEST_URI'];
 	$form['#method'] = 'post';
 	$form['#prefix'] ='<div class="form-group row">';
 	$form['#suffix'] ='</div>';

 	$form['root_user'] = array(
 		'#title' 	=> 'Root user',
 		'#type'  	=> 'auto_complete',
 		'#name'		=> 'root-user',
 		'#auto_complete_path' => 'users_auto_complete',
 		'#default_value' => isset($post['root_user']) ? $post['root_user'] : (!empty(afl_variable_get('root_user')) ? afl_variable_get('root_user') : '') ,
 		
 	);

 	$form['clear_data'] = array(
 		'#title' 	=> 'Clear test data',
 		'#type'  	=> 'checkbox',
 		'#name'		=> 'clear-test-data',
 		'#default_value' => isset($post['clear_data']) ? $post['clear_data'] : '',
 		
 	);

 	$form['remove_user'] = array(
 		'#title' 	=> 'Remove system user',
 		'#type'  	=> 'checkbox',
 		'#name'		=> 'remove_system_user',
 		'#default_value' => isset($post['remove_user']) ? $post['remove_user'] : '',
 		
 	);

 	$form['remove_customer'] = array(
 		'#title' 	=> 'Remove system customers',
 		'#type'  	=> 'checkbox',
 		'#name'		=> 'remove_customer',
 		'#default_value' => isset($post['remove_customer']) ? $post['remove_customer'] : '',
 		
 	);
 	$form['submit'] = array(
 		'#title' => 'Submit',
 		'#type' => 'submit',
 		'#value' => 'Submit',
 		'#attributes' => array(
 			'class' => array(
 				'btn','btn-primary'
 			)
 		),
 		
 	);
 	echo afl_render_form($form);

	afl_content_wrapper_end();
}
/*
 * --------------------------------------------------------
 * Genealogy configurations form submit callback
 * --------------------------------------------------------
*/
function afl_genealogy_configuration_form_submit ($form_state){
	if (!empty($form_state['root_user']) ){
		afl_variable_set('root_user', $form_state['root_user']);
	}

	if (isset($form_state['clear_data']) ){
		afl_system_reset();
	}

	if ( isset($form_state['remove_user'])) {
		afl_remove_users();
	}

	if ( isset($form_state['remove_customer'])) {
		afl_remove_customers();
	}
	echo wp_set_message('Genealogy reset', 'success');
}
/*
 * --------------------------------------------------------
 * Reset Genealogy
 * --------------------------------------------------------
*/
	function afl_system_reset ($remove_user = '') {
		global $wpdb;
		$wpdb->query("DELETE FROM `"._table_name('afl_user_genealogy')."` WHERE `uid` != ".afl_root_user()." ");
		$wpdb->query("DELETE FROM `"._table_name('afl_unilevel_user_genealogy')."` WHERE `uid` != ".afl_root_user()." ");
		
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_business_funds')."`");
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_business_transactions')."`");
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_business_transactions_overview')."`");
		
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_payout_history')."`");
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_payout_requests')."`");
		
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_ranks')."`");
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_rank_history')."`");
		
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_transactions')."`");
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_transactions_errors')."`");
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_transaction_authorization')."`");
		
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_user_downlines')."`");
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_unilevel_user_downlines')."`");

		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_user_fund')."`");
		
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_user_holding_tank')."`");
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_unilevel_user_holding_tank')."`");
		
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_user_payment_methods')."`");
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_user_transactions')."`");
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_user_transactions_overview')."`");
		
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_purchases')."`");
		
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_tree_last_insertion_positions')."`");
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_unilevel_tree_last_insertion_positions')."`");

		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_customer')."`");
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_processing_queue')."`");
		
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_log_messages')."`");
		
		$wpdb->query("TRUNCATE TABLE `"._table_name('afl_user_holding_transactions')."`");
		
	}
/*
 * ------------------------------------------------------------------------
 * Remove system affiliates members 
 * ------------------------------------------------------------------------
*/

	function afl_remove_users () {
		//change all the users has afl_member role
		 $args = array(
	      'role' => 'afl_member',
	    );
	   $users = get_users($args);
	   //remove all the role
	   foreach ($users as $key => $value) {
	   	if ($value->ID != afl_root_user())
	   		wp_delete_user($value->ID);
	   }
	}

/*
 * ------------------------------------------------------------------------
 * Remove system affiliates customers 
 * ------------------------------------------------------------------------
*/

	function afl_remove_customers () {
		//change all the users has afl_member role
		 $args = array(
	      'role' => 'afl_customer',
	    );
	   $users = get_users($args);
	   //remove all the role
	   foreach ($users as $key => $value) {
	   	if ($value->ID != afl_root_user())
	   		wp_delete_user($value->ID);
	   }
	}
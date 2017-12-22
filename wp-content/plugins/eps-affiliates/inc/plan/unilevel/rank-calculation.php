<?php 
/*
 * ---------------------------------------------------
 * Calculate the rank of user and uplines 
 * ---------------------------------------------------
*/
	function _rank_calculation_scheduler_callback () {

		$afl_date = afl_date();
		//get the purchase details today
		$query = array();
	  $query['#select'] = _table_name('afl_purchases');
	  $query['#fields'] = array(
	  	_table_name('afl_purchases') => array('uid')
	  );
	  $query['#where'] = array(
	    '`'._table_name('afl_purchases').'`.`cron_status` != 2',
	    '`'._table_name('afl_purchases').'`.`category` = "product purchase"',
	  );
	  $query['#limit'] = 500;
   	$data = db_select($query, 'get_results');
   	
   	foreach ($data as $key => $value) {
   		try{
   			_change_cron_status($value->uid, 1);
	   			_recursive_calc_user_rank( $value->uid );
	   		_change_cron_status($value->uid, 2);
   		} catch(Exception $e){
   			afl_log('cron_rank_updation','Error %er',array('%er'=>print_r($e,TRUE)),LOGS_ERROR);
	   		_change_cron_status($value->uid, -1);
   		}
   		

   	}
   	//log cron run
   	if ( afl_variable_get('cron_logs_enable')) {
			afl_log('rank_calculation_scheduler','cron run completed',array(),LOGS_INFO);
   	}
	}

	function _recursive_calc_user_rank ( $uid = ''){
		//if uid
		if ( $uid)  {
			do_action('eps_affiliates_calculate_affiliate_rank',$uid);
		}

		//get the sponsor id
		$node = afl_genealogy_node($uid, 'unilevel');
		if ( $node->referrer_uid) {
			_recursive_calc_user_rank( $node->referrer_uid );
		}

	}

	function _change_cron_status ( $uid, $status){
 	global $wpdb;

		$update_id = $wpdb->update(
			_table_name('afl_purchases'),
			array(
				'cron_status' => $status
			),
			array(
				'uid' => $uid
			)
		);
	}
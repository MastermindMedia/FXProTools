<?php
/*
 * ------------------------------------------------------
 * After the completion of checkout
 * ------------------------------------------------------
*/
	function eps_commerce_checkout_complete( $order_id ){
		afl_purchase($order_id);
	}















/*
 * ----------------------------------------------------
 * check required pv
 * ----------------------------------------------------
*/
 function _check_required_pv_meets ($uid = '', $rank = '') {
 		$user_pv = _get_user_pv($uid);
 		//check conidition meets
 		$required_pv = afl_variable_get('rank_'.$rank.'_pv',0);

 		if ($required_pv <= $user_pv  ){
 			return true;
 		} else {
 			return false;
 		}
 }
/*
 * ----------------------------------------------------
 * check required pv
 * ----------------------------------------------------
*/
 function _check_required_gv_meets ($uid = '', $rank = '') {
 		//get an array of downline user id with their group volume
 		$my_pv   = _get_user_pv($uid);
 		$legs_gv = _get_user_direct_legs_gv($uid);
 		
 		//check conidition meets
 		$required_gv = afl_variable_get('rank_'.$rank.'_gv',0);
 		//get maximum group volume required for this rank
 		$max_taken 			= afl_variable_get('rank_'.$rank.'_max_gv_taken_1_leg',0);
 		$maximum_taken 	= afl_commission($max_taken,$required_gv);
 		
 		//get maximum taken from a leg
 		//check with the maximum 
 		$user_gv = 0;
 		foreach ($legs_gv as $key => $amount) {
 			$user_gv += ($amount > $maximum_taken) ? $maximum_taken : $amount;
 		}

 		$user_gv = $my_pv + $user_gv;
 		if ($required_gv <= $user_gv  ){
 			return true;
 		} else {
 			return false;
 		}
 }
 /*
 * ----------------------------------------------------
 * check required distributors
 * ----------------------------------------------------
*/
 function _check_required_distributors_meets ($uid = '', $rank = '') {
 		$user_distrib = _get_user_distributor_count($uid);
 		//check conidition meets
 		$required_distrib = afl_variable_get('rank_'.$rank.'_no_of_distributors',0);
 		// pr($rank);
 		// pr($required_distrib);
 		
 		if ($required_distrib <= $user_distrib  ){
 			return true;
 		} else {
 			return false;
 		}
 }
 /*
 * ----------------------------------------------------
 * check required qualifications
 * ----------------------------------------------------
 */
  function _check_required_qualifications_meets ($uid = '', $rank = '') {
		$below_rank = $rank - 1;
	  $meets_flag = 0;

	  if ( $below_rank > 0 ){
	    //loop through the below ranks qualifications exists or not
	    for ( $i = $below_rank; $i > 0; $i-- ) {
	      /*
	       * --------------------------------------------------------------
	       * get the required rank holders neede in one leg
	       * --------------------------------------------------------------
	      */

	        $required_in_one_count = afl_variable_get('rank_'.$rank.'_rank_'.$i.'_required_count', 0);


	      if ( $required_in_one_count ) {
	        /*
	         * --------------------------------------------------------------
	         * get the required count in how many legs
	         * --------------------------------------------------------------
	        */
	          $required_in_legs_count    = afl_variable_get('rank_'.$rank.'_rank_'.$i.'_required_in_legs ', 0);


	        //if in legs count specified
	        if ( $required_in_legs_count ) {
	          /*
	           * ---------------------------------------------------------------
	           * get the first level downlines of this user
	           * get count of the first level users having the rank
	           * if the rank users exists set the status as 1
	           * else unset status as 0
	           * this status adds to the condition_statuses array
	           *
	           * count the occurence of 0 and 1 in this array
	           *
	           * if the occurence of status is greater than or equals the count of
	           *  required in howmany legs count set the meets flag
	           * else unset
	           * ---------------------------------------------------------------
	          */


	          $downlines = afl_get_user_downlines_uid($uid, array('level'=>1), false);

	          $condition_statuses  = array();
	          //find the ranks ($i) of this downlines
	          foreach ($downlines as $key => $value) {
	              //get the downlines users downlines count having the rank $i
	              $down_downlines_count = afl_get_user_downlines_uid($value->downline_user_id, array('member_rank'=>$i),TRUE);
	              /*
	               * --------------------------------------------------
	               * Get the downlines count of members having the rank
	               * $i
	               * check the downline count meets the required count 
	               * in one leg
	               * if it meets set status as 1
	               * else set 0
	               * --------------------------------------------------
	              */
	              if ( $down_downlines_count >= $required_in_one_count )
	                $status = 1;
	              else
	                $status = 0;
	              $condition_statuses[] = $status;
	          }

	          //count the occurence of 1 and 0
	          $occurence = array_count_values($condition_statuses);
	          
	          //if the occurence of 1 is greater than or equals the count of legs needed it returns true
	          if ( isset($occurence[1])  && $occurence[1] >= $required_in_legs_count ){
	            $meets_flag = 1;
	          } else {
	            $meets_flag = 0;
	            break;
	          }

	        } else {
	          /*
	           * ---------------------------------------------------------------
	           * get the first level downlines of this user
	           * get count of the first level users downlines having the rank
	           * if the count meets required_count_in_leg set meets_flag
	           * else unset
	           * ---------------------------------------------------------------
	          */
	            $downlines = array();
	            $result = afl_get_user_downlines_uid($uid, array('level'=>1), false);
	            foreach ($result as $key => $value) {
	              $downlines[] = $value->downline_user_id;
	            }

	            $implodes = implode(',', $downlines);
	            //check the ranks under this users
	            $query = array();

	            $query['#select'] = _table_name('afl_user_downlines');
	            $query['#where'] = array(
	              '`'._table_name('afl_user_downlines').'`.`member_rank`='.$i,
	            );
	            if (!empty($implodes)) {
	              $query['#where'][] = '`'._table_name('afl_user_downlines').'`.`uid` IN ('.$implodes.')';
	            }

	            $query['#expression'] = array(
	              'COUNT(`'._table_name('afl_user_downlines').'`.`member_rank`) as count'
	            );
	            $result = db_select($query, 'get_row');
	            $rank_existed_count = $result->count;


              if ( $rank_existed_count >= $required_in_one_count ){
                $meets_flag = 1;
              } else {
                $meets_flag = 0;
                break;
              }
	        }
	      } else {
	        $meets_flag = 1;
	      }
	    }
	  } else {
			$meets_flag = 1;
		}

		return $meets_flag;
	}
/*
 * ---------------------------------------------------
 * Check the customer rule
 *
 * each leg group volume * 55% = customer sales
 * ---------------------------------------------------
*/
 function _check_required_customer_rule($uid = '', $rank = '') {
 		$tree = 'unilevel';
 		//get an array of downline user id with their group volume
 		$my_pv   = _get_user_pv($uid);
 		$legs_gv = _get_user_direct_legs_gv($uid);
 		
 		//check conidition meets
 		$required_gv = afl_variable_get('rank_'.$rank.'_gv',0);

 		//get maximum group volume required for this rank
 		$max_taken 			= afl_variable_get('rank_'.$rank.'_max_gv_taken_1_leg',0);
 		$maximum_taken 	= afl_commission($required_gv, $max_taken);
 		//get maximum taken from a leg
 		//check with the maximum 
 		$user_gv = 0;
 		// pr($legs_gv);
 		foreach ($legs_gv as $leg_uid => $amount) {
 			//get the maximum taken from the leg
 			$leg_gv 						= ($amount > $maximum_taken) ? $maximum_taken : $amount;
 			// pr($amount);
 			//get the customers sales details from the leg uid
 			$leg_customer_sale 	= get_user_downline_customers_sales($leg_uid,TRUE);
 			// pr($leg_customer_sale);
 			//customer leg rule
 			$leg_rule 		 		= afl_variable_get('rank_'.$rank.'_customer_rule_from_1_leg',0);
		 	$leg_rule_amount 	= afl_commission($leg_rule,$leg_gv);
 			

 			//check the leg rule amount greater than or equal to the leg_customer_sale
 			if ( empty($leg_customer_sale) || ($leg_rule_amount >= $leg_customer_sale)  ) {
 				return FALSE;
 			}

 			return TRUE;
 		}
 }
/*
 * ---------------------------------------------------
 * get user pv
 * ---------------------------------------------------
*/
 function _get_user_pv ($uid = '') {
 	global $wpdb;
 	if (empty($uid))
 		$uid = afl_current_uid();

 	$table_prefix = $wpdb->prefix ? $wpdb->prefix : 'wp_';
 	$table 				= $table_prefix.'afl_purchases';

 	$query = array();
 	$query['#select'] = $table;
 	$query['#where'] 	= array(
 		'`'.$table.'`.`uid` = '.$uid
 	);
 	$query['#expression'] 	= array(
 		'SUM(`afl_points`) as sum'
 	);
 	$result = db_select($query, 'get_row');
 	$result = (array)$result;
 	if (isset($result['sum'])) {
 		return afl_get_payment_amount($result['sum']);
 	} else {
 		return 0;
 	}
 }
/*
 * ---------------------------------------------------
 * get user pv
 * ---------------------------------------------------
*/
 function _get_user_gv ($uid = '') {
 	global $wpdb;
 	if (empty($uid))
 		$uid = afl_current_uid();

 	$table_prefix = $wpdb->prefix ? $wpdb->prefix : 'wp_';
 	$table 				= $table_prefix.'afl_purchases';

 	//direct downlines
 	$downlines    = afl_get_user_downlines_uid($uid);
 	$downlines_uid = array();
 	foreach ($downlines as $key =>$down_uid) {
 		$downlines_uid[] = $down_uid->downline_user_id;
 	}

 	$query = array();
 	$query['#select'] = $table;
 	$query['#where_in'] 	= array(
 		'uid' => $downlines_uid
 	);

 	$query['#expression'] 	= array(
 		'SUM(`afl_points`) as sum'
 	);
 	$result = db_select($query, 'get_row');
	$result = (array)$result;
	 	if (isset($result['sum'])) {
	 		return afl_get_payment_amount($result['sum']);
	 	} else {
	 		return 0;
	 	}
 }

/*
 * ---------------------------------------------------
 * get user pv V1
 * ---------------------------------------------------
*/
function _get_user_gv_v1($uid = '', $rank ='', $add_with_user_pv = FALSE) {
	$my_pv   = _get_user_pv($uid);
	$legs_gv = _get_user_direct_legs_gv($uid);
	//check conidition meets
	$required_gv = afl_variable_get('rank_'.$rank.'_gv',0);

	//get maximum group volume required for this rank
	$max_taken 			= afl_variable_get('rank_'.$rank.'_max_gv_taken_1_leg',0);
	$maximum_taken 	= afl_commission($max_taken,$required_gv);
	// pr($maximum_taken);
	//get maximum taken from a leg
	//check with the maximum 
	$user_gv = 0;
	foreach ($legs_gv as $key => $amount) {
	// pr($maximum_taken);
	// pr($amount);
		$user_gv += ($amount >= $maximum_taken) ? $maximum_taken : $amount;
		// pr($user_gv);
	}
	if ( $add_with_user_pv ) 
		$user_gv = $my_pv + $user_gv;

	return $user_gv;
}
/*
 * -------------------------------------------------
 * No.of distributor count
 * -------------------------------------------------
*/
 function _get_user_distributor_count ($uid) {
 	$downlines    = afl_get_sponsor_downlines_uid($uid, array(), TRUE);
	// pr($downlines);
 	if ($downlines) {
 		return $downlines;
 	} else
 		return 0;
 }

/**
	* @param $id = payout id from tale wp_afl_payout_requests	 
 	* -----------------------------------------------------------
 	*  withdrawal approval bul operation a affiliate member
 	* -----------------------------------------------------------
**/
function eps_affiliates_withdrawal_approve_callback($id = ''){
	global $wpdb;
	$uid = afl_current_uid();
	$table_prefix = $wpdb->prefix ? $wpdb->prefix : 'wp_';
	$table 				= $table_prefix.'afl_payout_requests';

 	$query 						=   array();
 	$query['#select'] = $table;
 	$query['#where'] 	= array(
 		'afl_payout_id ='.$id
 	);
 	$row = db_select($query, 'get_row');
 	
 	if ($row->request_status != 1) {
      wp_set_message(__('Withdrawal Request is already processed of user id' .$row->uid ) ) ;
    	return false;
  }
	  $update = $wpdb->update(
		 	_table_name('afl_payout_requests'),
		 		array(
		 			'modified'				=> afl_date(),
					'paid_by' 				=> $uid,
					'notes'						=> 'Approved | Waiting For Payment',
					'request_status'	=> 2,
					'paid_status'			=> 1,
		 		),
		 		array(
		 			'afl_payout_id' => $id,
		 			'uid'						=> $row->uid,
		 		)
		);
    if($update){
    	return true;
    }else{
    	return false;
    }
}

/**
	* @param $id = payout id from tale wp_afl_payout_requests	 
 	* -----------------------------------------------------------
 	*  withdrawal reject bulk operation 
 	* -----------------------------------------------------------
**/
function eps_affiliates_withdrawal_reject_callback($id =''){
	
	global $wpdb;
	$uid 					= afl_current_uid();
	$table_prefix = $wpdb->prefix ? $wpdb->prefix : 'wp_';
	$table 				= $table_prefix.'afl_payout_requests';

 
 	$query1 						=   array();
 	$query1['#select'] 	= $table;

 	$query1['#where'] 	= array(
 		'afl_payout_id ='.$id
 	);
 	$row = db_select($query1, 'get_row');
 	
 	if ($row->request_status != 1) {
      wp_set_message(__('Withdrawal Request is already processed of user id' .$row->uid ) ) ;
    	return false;
  }

  $transaction 											=	array();
  $transaction['uid'] 							=	$row->uid;
  $transaction['associated_user_id']= $row->uid;
  $transaction['level'] 						= 0;
  $transaction['currency_code'] 		= afl_currency($row->uid);
  $transaction['order_id'] 					= 1;
  $transaction['int_payout'] 				= 0;
  $transaction['credit_status'] 		= 1;
  $transaction['amount_paid'] 			= $row->amount_requested + $row->charges;
  $transaction['amount_paid'] 			= $row->amount_requested;
  $transaction['category'] 					= 'WITHDRAWAL CANCELLATION';
  $transaction['notes'] 						= __('Amount credited back on withdrawal request rejection');
  $transaction['hidden_transaction']= 0;
  afl_member_transaction($transaction, FALSE, FALSE);

  $b_transactions['category'] 					= 'RE WITHDRAWAL CHARGES';
  $b_transactions['additional_notes'] 	= __('Return of Withdrawal Charges');
  $b_transactions['uid'] 								= $row->uid;
  $b_transactions['associated_user_id'] = $row->uid;
  $b_transactions['credit_status'] 			= 0;
  $b_transactions['amount_paid'] 				= $row->charges;
  $b_transactions['notes']		 					= __('Return of  Withdrawal Charges');
  $b_transactions['currency_code'] 			= afl_currency();
  $b_transactions['order_id'] 					= 1;
  afl_business_transaction($b_transactions);

    $update = $wpdb->update(
	 		_table_name('afl_payout_requests'),
	 			array(
	 				'modified'				=> afl_date(),
	 				'paid_by' 				=> $uid,
	 				'notes'						=> 'Rejected | Try Later',
	 				'paid_status'			=> -99,
	 				'request_status'	=> 3,
	 				'processed_method'=> '',
	 			),
	 			array(
	 				'afl_payout_id' => $id,
	 				'uid'						=> $row->uid,
	 			)
	 		);

  if($update){
    return true;
  }else{
    return false;
  }  
}

/**
	* @param $id = payout id from tale wp_afl_payout_requests	 
 	* -----------------------------------------------------------
 	*  Payout approval bulk operation
 	* -----------------------------------------------------------
**/
function eps_affiliates_payout_paid_callback($id = ''){
	
	$afl_date 				= afl_date();
 	$afl_date_splits 	= afl_date_splits($afl_date);
	$uid 							= afl_current_uid();
 	global $wpdb;

	$table_prefix 		= $wpdb->prefix ? $wpdb->prefix : 'wp_';
	$table 						= $table_prefix.'afl_payout_requests';
 
 	$query1 					= array();
 	$query1['#select']= $table;

 	$query1['#where']	= array(
 		'afl_payout_id ='.$id
 	);
 	$row = db_select($query1, 'get_row');
 	
 	if ($row->request_status != 2) {
      wp_set_message(__('Admin Approval is required' .$row->uid ) ) ;
    	return false;
  }
  if($row->paid_status != 1){
    	wp_set_message(__('Admin Approval is required' .$row->uid ) ) ;
      return false;
  }

  $update = $wpdb->update(
	 			_table_name('afl_payout_requests'),
	 			array(
	 				'modified'				=> $afl_date,
	 				'paid_date' 				=> $afl_date,
	 				'notes'						=> 'Paid | Payment Processed',
	 				'paid_status'			=> 2,
	 				'request_status'	=> 3,
	 				'payment_date' => $afl_date_splits['d'],
          'payment_month' => $afl_date_splits['m'],
          'payment_year' => $afl_date_splits['y'],
          'payment_week' => $afl_date_splits['w'],
	 			),
	 			array(
	 				'afl_payout_id' => $id,
	 				'uid'						=> $row->uid,
	 			)
	 		);
   if($update){
    return true;
  }else{
    return false;
  } 
}

/**
	* @param $id = payout id from tale wp_afl_payout_requests	 
 	* -----------------------------------------------------------
 	*  withdrawal cancellation by user bulk operation
 	* -----------------------------------------------------------
**/
function eps_affliate_user_cancel_withdraw_callback($id = ''){
	global $wpdb;
	$afl_date 		= afl_date();
	$uid 					= afl_current_uid();
	$table_prefix = $wpdb->prefix ? $wpdb->prefix : 'wp_';
	$table 				= $table_prefix.'afl_payout_requests';

 
 	$query 							=   array();
 	$query['#select'] 	= $table;

 	$query['#where'] 		= array(
 		'afl_payout_id ='.$id
 	);
 	$row = db_select($query, 'get_row');
 	
 	if ($uid != $row->uid) {
     wp_set_message(__('You can not cancel other members withdrawal request' .$row->uid ) ) ;
    	return false;
  }
  if ($row->request_status != 1) {
      wp_set_message(__('Withdrawal Request is already processed of user id' .$row->uid ) ) ;
    	return false;
  }
   	$transaction 												= array();
    $transaction['uid'] 								= $row->uid;
    $transaction['associated_user_id'] 	= $row->uid;
    $transaction['level'] 							= 0;
    $transaction['currency_code'] 			= afl_currency($row->uid);
    $transaction['order_id'] 						= 1;
    $transaction['int_payout'] 					= 0;
    $transaction['credit_status'] 			= 1;
    $transaction['hidden_transaction']	= 0;
    $transaction['amount_paid'] 				= $row->amount_requested + $row->charges;
    $transaction['amount_paid'] 				= $row->amount_requested;
    $transaction['category'] 						= 'WITHDRAWAL CANCELLATION';
    $transaction['notes'] 							= __('Amount credited back on withdrawal request cancelation');
    afl_member_transaction($transaction, FALSE, FALSE);


    $b_transactions['category'] 					= 'RE WITHDRAWAL CHARGES';
    $b_transactions['additional_notes'] 	= __('Return of Withdrawal Charges');
    $b_transactions['uid'] 								= $row->uid;
    $b_transactions['associated_user_id'] = $row->uid;
    $b_transactions['credit_status'] 			= 0;
    $b_transactions['amount_paid'] 				= $row->charges;
    $b_transactions['notes'] 							= __('Return of  Withdrawal Charges');
    $b_transactions['currency_code'] 			= afl_currency();
    $b_transactions['order_id']						= 1;
    afl_business_transaction($b_transactions);

    $update = $wpdb->update(
	 			_table_name('afl_payout_requests'),
	 			array(
	 				'modified'				=> $afl_date,
	 				'paid_date' 				=> $afl_date,
	 				'notes'						=> 'Cancelled',
	 				'paid_status'			=> -99,
	 				'request_status'	=> 3,
	 			),
	 			array(
	 				'afl_payout_id' => $id,
	 				'uid'						=> $row->uid,
	 			)
	 		);
   if($update){
    return true;
  }else{
    return false;
  } 

}
 
function _get_company_profit ($type = '') {
	switch ($type) {
		case 'monthly':
			return _get_company_profit_monthly();
		break;
		
		default:
		break;
	}
}
/*
 * --------------------------------------------------
 * Get this month profit
 * --------------------------------------------------
*/
function _get_company_profit_monthly () {

		$date  = afl_date() - (30*24*60*60);
		$afl_date_splits = afl_date_splits($date);
		
		$query = array();
		$query['#select'] = _table_name('afl_business_transactions');
		$query['#where'] 	= array(
			'deleted = 0',
			'hidden_transaction=0',
			'transaction_month='.$afl_date_splits['m'],
			'transaction_year='.$afl_date_splits['y']
		);
		$query['#expression'] = array(
			'SUM(balance) as balance'
		);
		$resp = db_select($query, 'get_row');
		return $resp;
}
/*
 * --------------------------------------------------
 * Get this month profit
 * --------------------------------------------------
*/
function _get_company_profit_yearly () {

		$date  = afl_date() - (12*30*24*60*60);
		$afl_date_splits = afl_date_splits($date);

		$query = array();
		$query['#select'] = _table_name('afl_business_transactions');
		$query['#where'] 	= array(
			'deleted = 0',
			'hidden_transaction=0',
			'transaction_month='.$afl_date_splits['m'],
			'transaction_year='.$afl_date_splits['y']
		);
		$query['#expression'] = array(
			'SUM(balance) as balance'
		);
		$resp = db_select($query, 'get_row');
		return $resp;
}
/*
 * --------------------------------------------------
 * Get howmany days the current rank holding...
 * --------------------------------------------------
*/
 	function _user_current_rank_holding_days ($uid = ''){ 
 		$days = 0;
 		if ( !empty($uid)) {
 			//get the user rank from ranks table
 			$rank_det 		= afl_rank_details($uid);
 			$current_date = afl_date();
 			$rank_updated_date = !empty($rank_det->updated) ? $rank_det->updated : 0;
 			if ( $rank_updated_date ) {
 				$datediff 		 = $current_date - $rank_updated_date;
 				$days = floor($datediff / (60 * 60 * 24));
 			}
 		}
 		return $days;
 	}
/*
 * -------------------------------------------------
 * Get rank details
 * -------------------------------------------------
*/
	function afl_rank_details($uid = ''){
		$query = array();
		$query['#select'] = _table_name('afl_ranks');
		$query['#where'] = array(
			'uid='.$uid
		);
		$result = db_select($query, 'get_results');
		return $result;
	}
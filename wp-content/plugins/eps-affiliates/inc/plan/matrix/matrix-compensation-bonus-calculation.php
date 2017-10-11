<?php
/** 
 * --------------------------------------------------------------------------
 * @author < pratheeshepixelsolutions.com >
 *
 * Here calculates the matrix compensation for users
 * --------------------------------------------------------------------------
*/
 function _calculate_matrix_compensation () {
 		$matrix_given_date 	= afl_variable_get('matrix_compensation_given_day', 1);
	 	$current_date				= afl_date();
	 	$afl_date_splits 		= afl_date_splits(afl_date());

	 	if ( $afl_date_splits['d'] == $matrix_given_date) {

	 		$query = array();
	 		$query['#select'] = _table_name('afl_user_genealogy');
	 		$query['#where']  = array(
	 			'deleted = 0',
	 			'status = 1'
	 		);
			// $query['#limit'] 		 = 100;
	 		$users  = db_select($query, 'get_results');
	 		


	 		foreach ($users as $key => $user) {
				
				//cannot give the bonus, if the user has no renewal on this month
				$hs_distrib_kit = _has_distributor_kit_renewal($user->uid);
				if (!$hs_distrib_kit && afl_variable_get('deactive_member_if_no_distrib_pack',0) ) {
					//update the status of the user, blocked
					apply_filters('eps_affiliates_block_member',$user->uid);
					continue;
				}

	 			
	 		/*
	 		 * -----------------------------------------------------
	 		 * IF a user status is 1 then check the months he actived 
	 		 * 
	 		 * If user status is 0, check howmany months he has been,
	 		 * actived then give the commission only once
	 		 * -----------------------------------------------------
	 		*/

	 			$actived_on  		= $user->actived_on;
	 			$diff						= $current_date - $actived_on;
	 			$years 					= floor($diff / (365*60*60*24));
	 			$months_actived = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	 			$months_actived = $months_actived + 0;
	 			$maximum_period = afl_variable_get('matrix_compensation_period_maximum', 3);
	 			pr(afl_system_date_format($current_date,1));
	 			pr(afl_system_date_format($actived_on,1));
	 		pr( floor($diff / (60 * 60 * 24)),1);

	 			if (!empty($months_actived)) {
	 				//check the difference greater than maximum period
	 				//if yes, taken the maximum
	 				if ($months_actived > $maximum_period) {
	 					$months_actived = $maximum_period;
	 				}
	 				//get the countof actived downlines under this user
	 				$query = array();
			 		$query['#select'] = _table_name('afl_user_downlines');
			 		$query['#join'] 	= array(
			 			_table_name('afl_user_genealogy') => array(
			 				'#condition' => '`'._table_name('afl_user_downlines').'`.`downline_user_id` = `'._table_name('afl_user_genealogy').'`.`uid`'
			 			)
			 		);
			 		//only get the users under 9 level
			 		$max_level  = afl_variable_get('matrix_compensation_max_level', 9);
			 		$query['#where']  = array(
			 			'`'._table_name('afl_user_genealogy').'`.`status` = 1',
			 			'`'._table_name('afl_user_downlines').'`.`uid` = '.$user->uid,
			 			'`'._table_name('afl_user_downlines').'`.`level` <='.$max_level,

			 		);
			 		$query['#expression'] = array(
			 			'COUNT(`'._table_name('afl_user_genealogy').'`.`uid`) as count'
			 		);

			 		$respo = db_select($query, 'get_row');
			 		$count = !empty($respo->count) ? $respo->count : 0;
			 		
			 		//get the bonus for the $months_actived 
			 		$amount_for_actived_month = afl_variable_get('month_'.$months_actived.'_matrix_compensation', 0);
			 		$user_amount = $amount_for_actived_month * $count;

			 		if ( $user_amount > 0) {
			 			 $transaction = array();
					   $transaction['uid'] 								= $user->uid;
					   $transaction['associated_user_id'] = $user->uid;
					   $transaction['payout_id'] 					= 0;
					   $transaction['level']							= 0;
					   $transaction['currency_code'] 			= afl_currency();
					   $transaction['order_id'] 					= 1;
					   $transaction['int_payout'] 				= 0;
					   $transaction['hidden_transaction'] = 0;
					   $transaction['credit_status'] 			= 1;
					   $transaction['amount_paid'] 				= afl_commerce_amount($user_amount);
					   $transaction['category'] 					= 'MATRIX COMPENSATION';
					   $transaction['notes'] 							= 'Matrix compensation for '.$months_actived.' actived months having '.$count.' actived distributors';

					   //check already paid
					   $query = array();
					   $afl_date_splits = afl_date_splits(afl_date());
					   $query['#select'] = _table_name('afl_user_transactions');
					   $query['#where'] = array(
					   	'`uid`='.$user->uid,
					   	'`category` = "MATRIX COMPENSATION"',
					   	'`transaction_month` = '.$afl_date_splits['m'],
					   	'`transaction_year` = '.$afl_date_splits['y'],
					   );
					   $check = db_select($query, 'get_row');
					   
					   if ( empty($check) ){
					   	 afl_member_transaction($transaction, FALSE, FALSE);

						   $b_transactions['category'] 						= 'MATRIX COMPENSATION';
						   $b_transactions['additional_notes']		= 'Matrix compensation';
						   $b_transactions['uid'] 								= $user->uid;
						   $b_transactions['associated_user_id'] 	= $user->uid;
						   $b_transactions['credit_status'] 			= 0;
						   $b_transactions['amount_paid'] 				= afl_commerce_amount($user_amount);
						   $b_transactions['notes'] 							= 'Matrix compensation for '.$months_actived.' actived months';
						   $b_transactions['currency_code'] 			= afl_currency();
						   $b_transactions['order_id'] 						= 1;
						   afl_business_transaction($b_transactions);
					   }
			 		}
	 			}
	 		}
	 	}
 }
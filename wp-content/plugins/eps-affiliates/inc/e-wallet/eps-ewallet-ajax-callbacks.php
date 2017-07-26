<?php 
/*
 * ------------------------------------------------
 * User e-wallet trsnsation summary
 * ------------------------------------------------
*/
function afl_user_ewallet_summary_data_table_callback(){

		global $wpdb;
		$uid 					 = get_current_user_id();
		$result = $wpdb->get_results("SELECT `wp_afl_user_transactions`.`category`, SUM(`wp_afl_user_transactions`.`balance`) as balance FROM `wp_afl_user_transactions` WHERE `uid` = $uid GROUP BY `category` DESC");
		$output = [
	    "draw" 						=> 1,
	    "recordsTotal" 		=> 25,
	    "recordsFiltered" 	=> 2,
	    "data" 						=> [],
		];
		foreach ($result as $key => $value) {
			$output['data'][] = [
	   		$key+1,
	     	$value->category,
	     	$value->balance  	
   		];
		}
	echo json_encode($output);
	die();
}

/*
 * ------------------------------------------------
 * User e-wallet all trsnsaction 
 * ------------------------------------------------
*/
function afl_user_ewallet_all_transaction_data_table(){
	global $wpdb;
	// $uid 						 = get_current_user_id();
	$uid = 7;
// 
$input_valu = $_POST;
 	if(!empty($input_valu['order'][0]['column']) && !empty($fields[$input_valu['order'][0]['column']])){
     $filter['order'][$fields[$input_valu['order'][0]['column']]] = !empty($input_valu['order'][0]['dir']) ? $input_valu['order'][0]['dir'] : 'ASC';
  }
  if(!empty($input_valu['search']['value'])) {
     $filter['search_valu'] = $input_valu['search']['value'];
  }
 
  $filter['start'] 		= !empty($input_valu['start']) 	? $input_valu['start'] 	: 0;
  $filter['length'] 	= !empty($input_valu['length']) ? $input_valu['length'] : 5;

  $result_count = get_all_transaction_details($uid,array(),TRUE); 
  $filter_count = get_all_transaction_details($uid,$filter,TRUE); 

// 
    $result = get_all_transaction_details($uid,$filter);

  	$output = [
     "draw" 						=> $input_valu['draw'],
     "recordsTotal" 		=> $result_count,
     "recordsFiltered" 	=> $filter_count,
     "data" 						=> [],
   ];
    $result = get_all_transaction_details($uid,$filter);
		foreach ($result as $key => $value) { 
			if($value->credit_status == 1 ){
				$status =  "<button type='button' class='btn btn-success btn-sm'>Credit</button>";
			}
			else{
				$status =  "<button type='button' class='btn btn-danger'>Debit</button>";
			}
			$output['data'][] = [
	   		$key+1,
	     	ucfirst(strtolower($value->category)),
	     	$value->display_name." (".$value->associated_user_id.")",
	 			number_format($value->amount_paid, 2, '.', ',')." " .$value->currency_code ,
	     	$status,
	     	$value->transaction_date  	
   		];
		}
	echo json_encode($output);
	die();
}

function get_all_transaction_details ($uid = '7', $filter = array(), $count = false){
		global $wpdb;

	 $query = array();
   $query['#select'] = 'wp_afl_user_transactions';
   $query['#join']  = array(
      'wp_users' => array(
        '#condition' => '`wp_users`.`ID`=`wp_afl_user_transactions`.`associated_user_id`'
      )
    );
   $query['#where'] = array(
      '`wp_afl_user_transactions`.`uid`= '.$uid.''
    );

   	$limit = '';
		if (isset($filter['start']) && isset($filter['length'])) {
			$limit .= $filter['start'].','.$filter['length'];
		}
	
		if (!empty($limit)) {
			$query['#limit'] = $limit;
		}
		if (!empty($filter['search_valu'])) {
			$query['#like'] = array('`display_name`' => $filter['search_valu']);

		}



   $query['#order_by'] = array(
      '`transaction_date`' => 'ASC'
    );
	 $result = db_select($query, 'get_results');
	 if ($count)
			return count($result); 
		return $result;
}
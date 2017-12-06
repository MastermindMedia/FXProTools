<?php

function afl_rank_performance_overview () {
	echo afl_eps_page_header();
		new Afl_enque_scripts('common');
	
	echo afl_content_wrapper_begin();
		afl_rank_occured_details();
		afl_rank_group_volume_details();
		// afl_rank_leg_customer_sales();
		afl_rank_performance_overview_template();
	echo afl_content_wrapper_end();
}

function afl_rank_performance_overview_shortcode_callback () {
		afl_rank_occured_details();
		afl_rank_group_volume_details();
		// afl_rank_leg_customer_sales();
		afl_rank_performance_overview_template();
}

/*
 * ------------------------------------------
 * sales under each leg
 * ------------------------------------------
*/

	function afl_rank_group_volume_details () {
		new Afl_enque_scripts('common');
		
		$uid = get_uid();
		if (isset($_GET['uid'])) {
			$uid = $_GET['uid'];
		}

		$table = array();
		$table['#name'] 			= '';
		$table['#title'] 			= 'Direct Leg Sales Report';
		$table['#prefix'] 		= '';
		$table['#suffix'] 		= '';
		$table['#attributes'] = array(
						'class' => array(
								'table',
								'table-bordered',
								'my-table-center',

							)
						);

		$table['#header'] = array(
			__('Leg 1 sales','affiliates-eps'), 
			__('Leg 2 sales','affiliates-eps'), 
			__('Leg 3 sales','affiliates-eps'), 
		);

		$rows = array();
		$leg_sales 		= _get_user_direct_legs_gv($uid, FALSE, 'matrix', FALSE);
		$direct_legs 	= _get_user_direct_legs($uid);

		$_legnumber_sale = array();
		foreach ($direct_legs as $key => $value) {
			$leg_customer_sale 	= 0;
			$leg_customer_sale 	= get_user_downline_customers_sales($value->uid,TRUE);

			$_legnumber_sale[$value->relative_position]['distrib_sale'] = !empty($leg_sales[$value->uid]) ? $leg_sales[$value->uid] : 0;
			$_legnumber_sale[$value->relative_position]['customer_sale']= $leg_customer_sale;
		}	


		foreach ($_legnumber_sale as $key => $value) {
			$rows[1]['leg_'.$key] = array(
				'#type' => 'markup',
				'#markup' => 'Distributors sale : '.$value['distrib_sale'].'</br>
											Customers sale : '.$value['customer_sale'].''
			);
		}

		$table['#rows'] = $rows;	
		echo afl_render_table($table);
	}
/*
 * -----------------------------------------
 * Leg customers sales
 * -----------------------------------------
*/
 function afl_rank_leg_customer_sales() {
 		$uid = get_uid();
		if (isset($_GET['uid'])) {
			$uid = $_GET['uid'];
		}

		$table = array();
		$table['#name'] 			= '';
		$table['#title'] 			= 'Direct Leg Customer Sales Report';
		$table['#prefix'] 		= '';
		$table['#suffix'] 		= '';
		$table['#attributes'] = array(
						'class' => array(
								'table',
								'table-bordered',
								'my-table-center',

							)
						);

		$table['#header'] = array(
			__('Leg 1 Customers sales','affiliates-eps'), 
			__('Leg 2 Customers sales','affiliates-eps'), 
			__('Leg 3 Customers sales','affiliates-eps'), 
		);

		$rows = array();
		$leg_sales  = _get_user_direct_legs_gv($uid);
		foreach ($leg_sales as $leg_uid => $value) {
			$leg_customer_sale = 0;
 			$leg_customer_sale 	= get_user_downline_customers_sales($leg_uid,TRUE);
 			// pr($leg_customer_sale);
 			$rows[1]['leg_'.$leg_uid] = array(
				'#type' => 'markup',
				'#markup' => $leg_customer_sale
			);
		}

		$table['#rows'] = $rows;	
		echo afl_render_table($table);
 }
/*
 * ------------------------------------------
 * The rank performance overview
 * ------------------------------------------
*/
	function afl_rank_performance_overview_template () {
		$uid = get_uid();
		if (isset($_GET['uid'])) {
			$uid = $_GET['uid'];
		}
	
		$node = afl_genealogy_node($uid);
		if ( empty($node)) {
			$node = afl_genealogy_node($uid, 'unilevel');
		}

		$member_rank = $node->member_rank;

		$table = array();
		$table['#name'] 			= '';
		$table['#title'] 			= 'Rank Advancement Overview';
		$table['#prefix'] 		= '';
		$table['#suffix'] 		= '';
		$table['#attributes'] = array(
						'class' => array(
								'table',
								'table-bordered',
								'my-table-center',

							)
						);

		$table['#header'] = array(
			__('Rank Name','affiliates-eps'), 
			__('PV','affiliates-eps'), 
			__('GV','affiliates-eps'), 
			__('Maximum GV taken (1 leg)','affiliates-eps'), 
			__('Customer Leg rule','affiliates-eps'), 
			__('Distributors','affiliates-eps'),
			__('Qualifications','affiliates-eps'),
			
		);
		$rows = array();

	 	$max_rank = afl_variable_get('number_of_ranks');
	 	for ($i = 1; $i <= $max_rank; $i++) {
	 		
	 		/* ------ Rank name --------------------------------------------------------------------*/
		 		$rows[$i]['label_1'] = array(
					'#type' => 'label',
					'#title'=> afl_variable_get('rank_'.$i.'_name', 'Rank '.$i),

				);
	 		/* ------ Rank name --------------------------------------------------------------------*/
	 		
	 		
	 		/* ------ User PV ----------------------------------------------------------------------*/
				$required = afl_variable_get('rank_'.$i.'_pv',0);
				$earned 	= _get_user_pv($uid); 

				$markup = '';
				$markup .= '<label class="label text-info m-l-xs">Required : '.$required.'</label><br>';
				$markup .= '<label class="label text-info m-l-xs">Earned : '.number_format($earned, 2, '.', ',').'</label><br>';
				if ($required <= $earned) {
					$condition = '<span class="text-center"><i class="text-center fa fa-lg fa-thumbs-o-up  text-success m-b-xs"></i></span>';
				} else {
					$condition = '<span class="text-center"><i class="text-center fa fa-lg fa-thumbs-o-down  text-danger m-b-xs"></i></span>';
				}

				$rows[$i]['markup_1'] = array(
					'#type' => 'markup',
					'#markup'=> $markup.$condition,
				);
	 		
	 		/* ------ User PV ----------------------------------------------------------------------*/


	 		/* ------ User GV ----------------------------------------------------------------------*/
				$required = afl_variable_get('rank_'.$i.'_gv',0);
				$earned 	= _get_user_gv_v1($uid,$i,TRUE); 
				// $leg_customer_sale 	= get_user_downline_customers_sales($uid,TRUE);
				// $earned += $leg_customer_sale;
				// pr($earned);

				$markup = '';
				$markup .= '<label class="label text-info m-l-xs">Required : '.$required.'</label><br>';
				$markup .= '<label class="label text-info m-l-xs">Earned : '.number_format($earned, 2, '.', ',').'</label><br>';
				if ($required <= $earned) {
					$condition = '<span class="text-center"><i class="text-center fa fa-lg fa-thumbs-o-up  text-success m-b-xs"></i></span>';
				} else {
					$condition = '<span class="text-center"><i class="text-center fa fa-lg fa-thumbs-o-down  text-danger m-b-xs"></i></span>';
				}

				$rows[$i]['markup_2'] = array(
					'#type' => 'markup',
					'#markup'=> $markup.$condition,
				);
	 		/* ------ User GV ----------------------------------------------------------------------*/
	 		
	 		/* ------ User GV Maximum taken --------------------------------------------------------*/
	 		// pr(_get_user_direct_legs_gv($uid,TRUE));
	 			$max_taken 			= afl_variable_get('rank_'.$i.'_max_gv_taken_1_leg',0);
				$maximum_taken 	= afl_commission($max_taken,$required);

				$markup = '';
				$markup .= '<label class="label text-info m-l-xs">Rule : '.$max_taken.'</label><br>';
				$markup .= '<label class="label text-info m-l-xs">Maximum amount taken : '.number_format($maximum_taken, 2, '.', ',').'</label><br>';

	 			$rows[$i]['maximum_gv_taken'] = array(
					'#type' => 'markup',
					'#markup'=> $markup,
				);
	 		/* ------ User GV Maximum taken --------------------------------------------------------*/


	 		/* ------ Customer leg rule  -----------------------------------------------------------*/
	 			$markup = '';
	 			$tree = 'unilevel';
		 		//get an array of downline user id with their group volume
		 		$my_pv   = _get_user_pv($uid);
		 		$legs_gv = _get_user_direct_legs_gv($uid);
		 		
		 		//check conidition meets
		 		$required_gv = afl_variable_get('rank_'.$i.'_gv',0);

		 		//get maximum group volume required for this rank
		 		$max_taken 			= afl_variable_get('rank_'.$i.'_max_gv_taken_1_leg',0);
		 		$maximum_taken 	= afl_commission($required_gv, $max_taken);
		 		//get maximum taken from a leg
	 			$leg_rule 		 		= afl_variable_get('rank_'.$i.'_customer_rule_from_1_leg',0);
		 		//check with the maximum 
		 		$user_gv = 0;
		 		// pr($legs_gv);
		 		$leg = 1;

		 		$markup .= '<label class="label text-info m-l-xs">Rule : '.$leg_rule.'</label><br>';
		 		$markup .= '<table class="table-striped  table table-bordered my-table-center">';
		 		$markup .= '<thead>';
		 		$markup .= '<tr>';
		 		$markup .= '<th> Leg GV</th>';
		 		$markup .= '<th> Leg customers sales</th>';
		 		$markup .= '<th>Required </th>';
		 		$markup .= '<th></th>';
		 		$markup .= '</tr>';
		 		$markup .= '</thead>';
		 		// pr($legs_gv);
		 		foreach ($legs_gv as $leg_uid => $amount) {

		 			$markup .= '<tr>';
		 			//get the maximum taken from the leg
		 			$leg_gv 						= ($amount > $maximum_taken) ? $maximum_taken : $amount;
		 			$markup .= '<td>'.$leg_gv.'</td>';

		 			//get the customers sales details from the leg uid
		 			$leg_customer_sale 	= get_user_downline_customers_sales($leg_uid,TRUE);
		 			$markup .= '<td>'.$leg_customer_sale.'</td>';

		 			// pr($leg_customer_sale);
		 			//customer leg rule
		 			$leg_rule_amount 	= afl_commission($leg_rule,$leg_gv);
		 			$markup .= '<td>'.$leg_rule_amount.'</td>';

		 			//check the leg rule amount greater than or equal to the leg_customer_sale
		 			if (empty($leg_customer_sale) || ($leg_rule_amount >= $leg_customer_sale) ) {
		 				$leg_condition = '<span class="text-center"><i class="text-center fa fa-lg fa-thumbs-o-down  text-danger m-b-xs"></i></span>';
		 			} else {
		 				$leg_condition = '<span class="text-center"><i class="text-center fa fa-lg fa-thumbs-o-up  text-success m-b-xs"></i></span>';
		 			}
		 			$markup .= '<td>'.$leg_condition.'</td>';

		 			$markup .= '</tr>';

		 		}
		 		$markup .= '</tr>';
		 		$markup .= '</table>';
		 		if ($i <= $member_rank)  {
		 			$markup  = '';
		 			$markup .= '<label class="label text-info m-l-xs">Rule : '.$leg_rule.'</label><br>';
		 			$markup .= 'Rules meets before and Rank achieved';

	 			}
		 			
	 			$rows[$i]['customer_leg_rule'] = array(
					'#type' => 'markup',
					'#markup'=> $markup,
				);

	 		/* ------ Customer leg rule  -----------------------------------------------------------*/



	 		/* ------ No.of distributors -----------------------------------------------------------*/
				$required = afl_variable_get('rank_'.$i.'_no_of_distributors',0);
				$earned 	= _get_user_distributor_count($uid); 

				$markup = '';
				$markup .= '<label class="label text-info m-l-xs">Required : '.$required.'</label><br>';
				$markup .= '<label class="label text-info m-l-xs">Earned : '.$earned.'</label><br>';
				if ($required <= $earned) {
					$condition = '<span class="text-center"><i class="text-center fa fa-lg fa-thumbs-o-up  text-success m-b-xs"></i></span>';
				} else {
					$condition = '<span class="text-center"><i class="text-center fa fa-lg fa-thumbs-o-down  text-danger m-b-xs"></i></span>';
				}

				$rows[$i]['markup_3'] = array(
					'#type' => 'markup',
					'#markup'=> $markup.$condition,
				);
	 		/* ------ No.of distributors -----------------------------------------------------------*/

	 		/* ------ Rank qualifications ----------------------------------------------------------*/
	 		$markup = '';
	 		$below_rank = $i - 1;
			  if ($below_rank > 0 ) {
			  	for ($j = 1; $j <= $below_rank ; $j++) { 
			  		$count_all = FALSE;
			  		$required = afl_variable_get('rank_'.$i.'_rank_'.$j.'_required_count',0);
			  		// $in_each 	= afl_variable_get('rank_'.$i.'_rank_'.$j.'_required_each_leg',0);
			  		$in_leg_count = afl_variable_get('rank_'.$i.'_rank_'.$j.'_required_in_legs');

			  		if ($required && $in_leg_count) {
			  			$in_each_t = ($in_leg_count * $required).' '.afl_variable_get('rank_'.$j.'_name', 'Rank '.$j).'- from '.( $in_leg_count ).' legs';
			  			$count_all = FALSE;
			  		}

			  		if (empty($in_leg_count) && $required) {
			  			$in_each_t = ($required).' '.afl_variable_get('rank_'.$j.'_name', 'Rank '.$j).'- from any legs';
			  			$count_all = TRUE;

			  		}


			  		$downlines = afl_get_user_downlines_uid($uid, array('level'=>1), false);

	          $condition_statuses  = array();
	          $total_downlines 		 = ''; 
	          //find the ranks ($i) of this downlines
	          foreach ($downlines as $key => $value) {
	            //get the downlines users downlines count having the rank $i
	            $down_downlines_count = afl_get_user_downlines_uid($value->downline_user_id, array('member_rank'=>$j),TRUE);
	            $total_downlines = $total_downlines + $down_downlines_count;
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
	            if ( $down_downlines_count >= $required )
	              $status = 1;
	            else
	              $status = 0;
	            $condition_statuses[] = $status;
	          }
	           //count the occurence of 1 and 0
		         $occurence = array_count_values($condition_statuses);

		         if ( $count_all ) {
		         	if ( $required <= $total_downlines )
		         		$flag = 1;
		         	else 
		         		$flag = 0;
		         } else {
		         		if ( isset($occurence[1])  && $occurence[1] >= $in_leg_count )
		         		$flag = 1;
		         	else 
		         		$flag = 0;
		         }
			  		if ( $flag) {
							$condition = '<br><span class="text-center"><i class="text-center fa fa-lg fa-lg fa-thumbs-o-up text-success m-b-xs"></i></span>';
			  		} else {
							$condition = '<br><span class="text-center"><i class="text-center fa fa-lg fa-lg fa-thumbs-o-down text-danger m-b-xs"></i></span>';
			  		}

			  		// $in_each_t = '';
			  		// if ( $in_each ){
			  		// 	$in_each_t = '- in each leg';
			  		// } else {
			  		// 	$in_leg_count = afl_variable_get('rank_'.$i.'_rank_'.$j.'_required_in_legs');
			  		// 	if ( $in_leg_count ) {
			  		// 		$in_each_t = '- in '.$in_leg_count.' leg';
			  		// 	}
			  		// }
			  		if ($required) 
			  			$markup .= $in_each_t.$condition.'<br>';
			  	}
			  }
			 $rows[$i]['markup_4'] = array(
					'#type' => 'markup',
					'#markup'=> $markup,
				);
	 		/* ------ Rank qualifications ----------------------------------------------------------*/

	 	

	 	}
		$table['#rows'] = $rows;
		echo afl_render_table($table);
	}
/*
 * ------------------------------------------
 * the detailed count of howmany rank occured
 * in downlines
 * ------------------------------------------
*/
	function afl_rank_occured_details () {
		$uid = get_uid();

		$table = array();
		$table['#name'] 			= '';
		$table['#title'] 			= 'Downlines Rank Occured Overview';
		$table['#prefix'] 		= '';
		$table['#suffix'] 		= '';
		$table['#attributes'] = array(
						'class' => array(
								'table',
								'table-bordered',
								'my-table-center',

							)
						);

		$table['#header'] = array(
			__('Downlines','affiliates-eps')
		);

		$max_ranks = afl_variable_get('number_of_ranks',0);
		for ($i = 1; $i <= $max_ranks; $i++) {
			$table['#header'][] = afl_variable_get('rank_'.$i.'_name', 'Rank '.$i);
		}

		$rows = array();

		$rows[0]['markup_0'] = array(
			'#type' =>'markup',
			'#markup'=>'Direct Legs'
		);

		$width = afl_variable_get('matrix_plan_width', 0);
		for ($i = 1; $i <= $width; $i++ ) {
			$rows[$i]['markup_1'] = array(
				'#type' =>'markup',
				'#markup'=>'Leg '.$i.' Downlines'
			);
		}
	/* -------------------------- Get first level users occured ranks count -------------------------------*/

		//get the direct downlines ranks occured count
		$downline_uids = afl_get_user_downlines($uid, array('level'=>1), false);
		
		$downlines  = array();
	  foreach ($downline_uids as $key => $value) {
	    $downlines[$value->relative_position] = $value->downline_user_id;
	  }
	  // pr($downline_uids);
	  $implodes = implode(',', $downlines);
	  //check the ranks under this users
	  $query = array();
	  $query['#select'] = _table_name('afl_user_genealogy');
	  $query['#fields'] = array(
	  	_table_name('afl_user_genealogy') => array('member_rank')
	  );
	  $query['#expression'] = array(
	  	'COUNT(`'._table_name('afl_user_genealogy').'`.`member_rank`) as count'
	  );

	  $query['#where'] = array(
	    '`'._table_name('afl_user_genealogy').'`.`uid` IN ('.$implodes.')'
	  );
	  $query['#group_by'] = array(
	  	'member_rank'
	  );

	  $result = array();
	  if (!empty($downlines)) 
	  	$result = db_select($query, 'get_results');

	  // here get the first level users ranks
	  $ranks_count = array();
	  foreach ($result as $key => $value) {
	  	$ranks_count[$value->member_rank] = $value->count;
	  }

	  //print the rank count
	  for ($i = 1; $i <= $max_ranks; $i++) {
			$rows[0]['markup_0'.$i] = array(
				'#type' => 'markup',
				'#markup' => !empty($ranks_count[$i]) ? $ranks_count[$i] : '-'
			);
		}
	/* -------------------------- Get first level users occured ranks count -------------------------------*/


	/*---------------- Find the ranks occured under the downlines of first legs ---------------------------*/
	 //get all doenlines under this users
		foreach ($downlines as $rel_pos => $value) {
			$query = array();
			$query['#select'] = _table_name('afl_user_downlines');
			$query['#fields'] = array(
			 	_table_name('afl_user_downlines') => array('member_rank')
			);
			$query['#expression'] = array(
			 	'COUNT(`'._table_name('afl_user_downlines').'`.`member_rank`) as count'
			);
			$query['#where'] = array(
			   '`'._table_name('afl_user_downlines').'`.`uid` = '.$value
			);
			$query['#group_by'] = array(
			 	'member_rank'
			);
		  $result = array();
	  	$result = db_select($query, 'get_results');
		 	
		 	// here get the first level users ranks
		  $ranks_count = array();
		  foreach ($result as $key => $value) {
		  	$ranks_count[$value->member_rank] = $value->count;
		  }
		   //print the rank count
		  for ($i = 1; $i <= $max_ranks; $i++) {
				$rows[$rel_pos]['markup_1'.$i] = array(
					'#type' => 'markup',
					'#markup' => !empty($ranks_count[$i]) ? $ranks_count[$i] : '-'
				);
			}
		}
	/*---------------- Find the ranks occured under the downlines of first legs ---------------------------*/
		$table['#rows'] = $rows;
		echo afl_render_table($table);

	}
<?php
function afl_admin_test_codes(){
  echo afl_eps_page_header();
  echo afl_content_wrapper_begin();
    afl_test_codes_callback();
  echo afl_content_wrapper_begin();
}


function check_rank_achied() {
 pr(_check_required_pv_meets(4021,2));
 pr(_check_required_gv_meets(4021,2));
 pr(_check_required_distributors_meets(4021,2));
 pr(_check_required_qualifications_meets(4021,2));
 pr(_check_required_customer_rule(4021,2));
  
}

function afl_test_codes_callback () {
   /*$uid = get_uid();
  
  if (isset($_POST['search_key'])) {
    $search_key = $_POST['search_key'];
  }

  $response = array();

  $tree = _table_name('afl_user_downlines');
  if ( !empty($_POST['tree_mode']) && $_POST['tree_mode'] == 'unilevel') {
    $tree = _table_name('afl_unilevel_user_downlines');
  }

  $query = array();
  $query['#select']  = $tree;
  $query['#join'] = array(
    _table_name('users') => array(
     '#condition'=> '`'._table_name('users').'`.`ID` = `'.$tree.'`.`downline_user_id` '
    )
  );
  // if (!eps_is_admin()) {
    $query['#where'] = array(
      '`'.$tree.'`.`uid` = '.$uid
    );
  // }
  $query['#fields'] = array(
    _table_name('users') => array('user_login','ID')
  );
  // $query['#expression'] = array(
  //   'DISTINCT(`'._table_name('users').'`.`user_login`) as `user_login`'
  // );
  $result = db_select($query, 'get_results');
  

  foreach ($result as $key => $value) {
    $response[] = array('name'=> ($value->user_login.' ('.$value->ID.')'));
  }
  pr($response);*/
  pr('create Table');
  $table_name = _table_name( 'afl_user_holding_transactions');
      $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
            `afl_user_transactions_id` int(11) NOT NULL,
            `uid` int(10) unsigned NOT NULL COMMENT 'Member',
            `rejoined_phase` int(10) unsigned DEFAULT '0' COMMENT 'Rejoined Phase',
            `associated_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Associated user id',
            `level` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Level',
            `credit_status` tinyint(4) NOT NULL COMMENT 'Credit Status',
            `amount_paid` decimal(50,25) NOT NULL DEFAULT '0.0000000000000000000000000',
            `currency_code` varchar(100) DEFAULT NULL COMMENT 'Currency Code',
            `balance` decimal(50,25) NOT NULL DEFAULT '0.0000000000000000000000000',
            `category` varchar(100) DEFAULT NULL COMMENT 'Payment Source',
            `notes` varchar(350) DEFAULT NULL COMMENT 'Notes',
            `created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Created',
            `additional_notes` varchar(350) DEFAULT NULL COMMENT 'Additional Notes',
            `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Order ID',
            `transaction_day` int(10) unsigned DEFAULT '0' COMMENT 'Transaction day 1-31',
            `transaction_month` int(10) unsigned DEFAULT '0' COMMENT 'Transaction Month 1-12',
            `transaction_year` int(10) unsigned DEFAULT '0' COMMENT 'Transaction Year',
            `transaction_week` int(10) unsigned DEFAULT '0' COMMENT 'Transaction Week',
            `transaction_date` varchar(100) DEFAULT NULL COMMENT 'Transaction Date',
            `deleted` int(10) unsigned DEFAULT '0' COMMENT 'Deleted Status',
            `int_return` int(11) unsigned DEFAULT '0' COMMENT 'Return Status',
            `int_payout` int(11) DEFAULT '0' COMMENT 'Payment Initiated',
            `hidden_transaction` int(11) DEFAULT '0' COMMENT 'Hidden Transactions',
            `merchant_id` varchar(250) DEFAULT 'default' COMMENT 'Merchant Id',
            `extra_params` varchar(250) DEFAULT '' COMMENT 'Extra Params',
            `project_name` varchar(250) DEFAULT 'default' COMMENT 'Project name',
            `payout_id` int(10) unsigned DEFAULT '0' COMMENT 'Order ID',
            `withdrawal_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Withdrawal Date',
            `paid_status` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Paid Status'
          ) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='Stores the user transactions';";
      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      dbDelta( $sql );

      global $wpdb;
      //indexes
      $wpdb->query('ALTER TABLE `'.$table_name.'`
                ADD PRIMARY KEY (`afl_user_transactions_id`);');

      //AUTO_INCREMENT
      $wpdb->query( 'ALTER TABLE `'.$table_name.'`
                MODIFY `afl_user_transactions_id` int(11) NOT NULL AUTO_INCREMENT;' );
 
}








function insertuser () {
  $uid  = 162;
  for ($rank = 13; $rank >0; $rank--)  :
  $below_rank = $rank - 1;
  $meets_flag = 0;

  if ( $below_rank > 0 ){
    //loop through the below ranks qualifications exists or not
    for ( $i = $below_rank; $i > 0; $i-- ) {
      pr(' ----------------------------------------------------------- ');
      pr('Main Rank : '.$rank);
      pr('Rank : '.$i);
      /*
       * --------------------------------------------------------------
       * get the required rank holders neede in one leg
       * --------------------------------------------------------------
      */
        $required_in_one_count = afl_variable_get('rank_'.$rank.'_rank_'.$i.'_required_count', 0);
        pr( "Required in 1 leg : ". $required_in_one_count);
      if ( $required_in_one_count ) {
        /*
         * --------------------------------------------------------------
         * get the required count in how many legs
         * --------------------------------------------------------------
        */
          $required_in_legs_count    = afl_variable_get('rank_'.$rank.'_rank_'.$i.'_required_in_legs ', 0);
          pr("Coutable legs : ".$required_in_legs_count);
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
              $down_downlines_count = afl_get_user_downlines_uid($value->downline_user_id, array('member_rank'=>$i), true);
              if ( $down_downlines_count )
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
           * get count of the first level users having the rank
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
              '`'._table_name('afl_user_downlines').'`.`uid` IN ('.$implodes.')'
            );
            $query['#expression'] = array(
              'COUNT(`'._table_name('afl_user_downlines').'`.`member_rank`) as count'
            );
            $result = db_select($query, 'get_row');
            $rank_existed_count = $result->count;

            // foreach ($downlines as $key => $value) {
            //   //get the downlines users downlines count having the rank $i
            //   $down_downlines_count = afl_get_user_downlines_uid($value->downline_user_id, array('member_rank'=>$i), true);
            //   pr($down_downlines_count);
              if ( $rank_existed_count >= $required_in_one_count ){
                $meets_flag = 1;
              } else {
                $meets_flag = 0;
                break;
              }
            // }
        }
      } else {
        $meets_flag = 1;
      }

      pr(' ----------------------------------------------------------- ');
    }
  }
  pr('Rank '.$rank. " -" .$meets_flag);
endfor;
}

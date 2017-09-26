<?php 
/*
 * -------------------------------------------------------------------------
 * Includes All the menus of admin
 * -------------------------------------------------------------------------
 *
*/
	class Eps_Affiliates_Admin_Menu {
		/* -------------------------------------------------------------------------
		 * Construct Admin Menus
		 * -------------------------------------------------------------------------
		*/
			public function __construct() {

				add_action( 'admin_menu', array( $this , 'afl_network_menus' ) );
				add_action( 'admin_menu', array( $this , 'afl_ewallet_menus') );
				add_action( 'admin_menu', array( $this , 'afl_unilevel_network_menus' ) );
				// add_action( 'admin_menu', array( $this , 'afl_epin_menus') );
				add_action( 'admin_menu', array( $this , 'afl_business_menus') );
				add_action( 'admin_menu', array( $this , 'afl_manage_members_menus') );
				add_action( 'admin_menu', array( $this , 'afl_promotion_tools_menus') );
				add_action( 'admin_menu', array( $this , 'afl_payout_menus') );
				add_action( 'admin_menu', array( $this , 'afl_general_help_menus') );

				add_action( 'admin_menu', array( $this , 'afl_system_settings') );

				add_action( 'admin_menu', array( $this , 'eps_affiiliates_dashboard') );

				add_action( 'admin_menu', array( $this , 'eps_affiiliates_system_configurations') );
				
				add_action( 'admin_menu', array( $this , 'eps_admin_test_menus') );

				add_action( 'admin_menu', array( $this , 'eps_admin_purchase') );

				add_action( 'admin_menu', array( $this , 'afl_reports') );
				
				add_action( 'admin_menu', array( $this , 'afl_no_parent_pages') );

				add_action( 'admin_menu', array( $this , 'afl_admin_remote_api') );



			}
			
		/* -------------------------------------------------------------------------
		 *  All system Configuration
		 * -------------------------------------------------------------------------
		*/
			public function afl_system_settings (){

				$menu = array();
				$menu['system_settings'] = array(
					'#page_title'			=> __( 'Eps Affiliates System Settings', 'System Settings' ), 
					'#menu_title' 		=> __( 'Eps Affiliates System Settings', 'System Settings' ), 
					'#access_callback'=> 'system_settings', 
					'#menu_slug' 			=> 'affiliate-eps-system-configurations', 
					'#page_callback' 	=> 'afl_admin_advanced_configuration', 
				);
				//advanced configurations
				$menu['advanced_config'] = array(
					'#parent'					=> 'affiliate-eps-system-configurations',
					'#page_title'			=> __( 'Advanced Configurations', 'eps-affiliates' ), 
					'#menu_title' 		=> __( 'Advanced Configurations', 'eps-affiliates' ), 
					'#access_callback'=> 'system_settings', 
					'#menu_slug' 			=> 'affiliate-eps-system-configurations', 
					'#page_callback' 	=> 'afl_admin_advanced_configuration', 
				);
				//variable configuration
				$menu['afl_logs'] = array(
					'#parent'					=> 'affiliate-eps-system-configurations',
					'#page_title'			=> __( 'Recent log messages', 'eps-affiliates' ), 
					'#menu_title' 		=> __( 'Recent log messages', 'eps-affiliates' ), 
					'#access_callback'=> 'recent_log_messages', 
					'#menu_slug' 			=> 'affiliate-eps-recent-log-messages', 
					'#page_callback' 	=> 'afl_admin_recent_log_messages', 
				);
				//compensation plan
				$menu['compensation_plan'] = array(
					// '#parent'					=> 'affiliate-eps-system-configurations',
					'#parent'					=> 'no-parent',
					'#page_title'			=> __( 'Compensation Plan Configurations', 'eps-affiliates' ),
					'#menu_title' 		=> __( 'Compensation Plan Configurations', 'eps-affiliates' ),
					'#access_callback'=> 'compensation_plan_configurations', 
					'#menu_slug' 			=> 'affiliate-eps-compensation-plan-configurations', 
					'#page_callback' 	=> 'afl_admin_compensation_plan_configuration', 
				);
				//rank configuration
				$menu['rank_configurations'] = array(
					// '#parent'					=> 'affiliate-eps-system-configurations',
					'#parent'					=> 'no-parent',
					'#page_title'			=> __( 'Rank Configurations', 'eps-affiliates' ),
					'#menu_title' 		=> __( 'Rank Configurations', 'eps-affiliates' ),
					'#access_callback'=> 'system_rank_configurations', 
					'#menu_slug' 			=> 'affiliate-eps-rank-configurations', 
					'#page_callback' 	=> 'afl_admin_rank_configuration', 
				);
				//role permission set
				$menu['role_permissions'] = array(
					// '#parent'					=> 'affiliate-eps-system-configurations',
					'#parent'					=> 'no-parent',
					'#page_title'			=> __( 'Roles permission Settings', 'Roles permission Settings' ), 
					'#menu_title' 		=> __( 'Roles permission Settings', 'Roles permission Settings' ), 
					'#access_callback'=> 'afl_roles_configuration', 
					'#menu_slug' 			=> 'affiliate-eps-role-config-settings', 
					'#page_callback' 	=> 'afl_roles_config_settings', 
				);
				
				//genealogy configuration
				$menu['genealogy_configuration'] = array(
					'#parent'					=> 'no-parent',
					'#page_title'			=> __( 'Genealogy Configurations', 'Genealogy Configurations' ),
					'#menu_title' 		=> __( 'Genealogy Configurations', 'Genealogy Configurations' ),
					'#access_callback'=> 'system_settings', 
					'#menu_slug' 			=> 'affiliate-eps-genealogy-configurations', 
					'#page_callback' 	=> 'afl_system_genealogy_configurations', 
				);
				//payout configurations
				$menu['payout_config'] = array(
					// '#parent'					=> 'affiliate-eps-system-configurations',
					'#parent'					=> 'no-parent',
					'#page_title'			=> __( 'Payout Configuration', 'eps-affiliates' ), 
					'#menu_title' 		=> __( 'Payout Configurations', 'eps-affiliates' ), 
					'#access_callback'=> 'system_settings', 
					'#menu_slug' 			=> 'affiliate-eps-payout-configurations', 
					'#page_callback' 	=> 'afl_admin_payout_configuration', 
				);
				//payment method configuration
				$menu['payment_method_conf'] = array(
					// '#parent'					=> 'affiliate-eps-system-configurations',
					'#parent'					=> 'no-parent',
					'#page_title'			=> __( 'Payment Method Configuration', 'eps-affiliates' ), 
					'#menu_title' 		=> __( 'Payment Method Configurations', 'eps-affiliates' ), 
					'#access_callback'=> 'system_settings', 
					'#menu_slug' 			=> 'affiliate-eps-payment-method-configurations', 
					'#page_callback' 	=> 'afl_dev_payment_method_configuration', 
				);
				//payment method configuration
				$menu['pool_bonus'] = array(
					// '#parent'					=> 'affiliate-eps-system-configurations',
					'#parent'					=> 'no-parent',
					'#page_title'			=> __( 'Pool Bonus Configuration', 'eps-affiliates' ), 
					'#menu_title' 		=> __( 'Pool Bonus Configurations', 'eps-affiliates' ), 
					'#access_callback'=> 'system_settings', 
					'#menu_slug' 			=> 'affiliate-eps-pool-bonus-configurations', 
					'#page_callback' 	=> 'afl_admin_pool_bonus_configuration', 
				);
				//variable configuration
				$menu['variable_conf'] = array(
					// '#parent'					=> 'affiliate-eps-system-configurations',
					'#parent'					=> 'no-parent',
					'#page_title'			=> __( 'Variables Configuration', 'eps-affiliates' ), 
					'#menu_title' 		=> __( 'Variables Configuration', 'eps-affiliates' ), 
					'#access_callback'=> 'system_settings', 
					'#menu_slug' 			=> 'affiliate-eps-variable-configurations', 
					'#page_callback' 	=> 'afl_admin_variable_configurations', 
				);

				//variable configuration
				$menu['adv_queue_conf'] = array(
					// '#parent'					=> 'affiliate-eps-system-configurations',
					'#parent'					=> 'no-parent',
					'#page_title'			=> __( 'Advanced Queue Configuration', 'eps-affiliates' ), 
					'#menu_title' 		=> __( 'Advanced Queue Configuration', 'eps-affiliates' ), 
					'#access_callback'=> 'system_settings', 
					'#menu_slug' 			=> 'affiliate-eps-advanced-queue-configurations', 
					'#page_callback' 	=> 'afl_admin_advanced_queue_conf', 
				);
				afl_system_admin_menu($menu);

			}
		
		/*
		 * -------------------------------------------------------------------------
		 * Matrix Network menus callback
		 * -------------------------------------------------------------------------
		 *
		 * -------------------------------------------------------------------------
		*/
			public function afl_network_menus(){
				$menu = array();
				$menu['network'] = array(
					'#page_title'			=> __( 'Matrix Network', 'network' ), 
					'#menu_title' 		=> __( 'Matrix Network', 'network' ), 
					'#access_callback'=> 'afl_add_new_member', 
					'#menu_slug' 			=> 'affiliate-eps-user-network', 
					'#page_callback' 	=> 'afl_add_new_member', 
					'#weight'					=> 2
				);
				$menu['add_new_member'] = array(
					'#parent'					=> 'affiliate-eps-user-network',
					'#page_title'			=> __( 'Add new member-Matrix', 'Add new Member-Matrix' ), 
					'#menu_title' 		=> __( 'Add new member', 'Add new Member' ), 
					'#access_callback'=> 'afl_add_new_member', 
					'#menu_slug' 			=> 'affiliate-eps-user-network', 
					'#page_callback' 	=> 'afl_add_new_member', 
				);

				$menu['add_new_customer'] = array(
					'#parent'					=> 'affiliate-eps-user-network',
					'#page_title'			=> __( 'Add new customer-Matrix', 'Add new customer-Matrix' ), 
					'#menu_title' 		=> __( 'Add new customer', 'Add new customer' ), 
					'#access_callback'=> 'afl_add_new_customer', 
					'#menu_slug' 			=> 'affiliate-eps-add-new-customer', 
					'#page_callback' 	=> 'afl_add_new_customer', 
				);

				$menu['network_explorer'] = array(
					'#parent'					=> 'user-network',
					'#page_title'			=> __( 'Network Explorer-Matrix', 'Network Explorer-Matrix' ),    
					'#menu_title' 		=> __( 'Network Explorer', 'Network Explorer' ),    
					'#access_callback'=> 'afl_network_view', 
					'#menu_slug' 			=> 'affiliate-eps-network-explorer', 
					'#page_callback' 	=> 'afl_network_explorer', 
				);

				$menu['network_downlines'] = array(
					'#parent'					=> 'affiliate-eps-user-network',
					'#page_title'			=> __( 'Downline-members-Matrix', 'Downline-members-Matrix' ),    
					'#menu_title' 		=> __( 'Downline-members', 'Downline-members' ),    
					'#access_callback'=> 'afl_network_view', 
					'#menu_slug' 			=> 'affiliate-eps-downline-members', 
					'#page_callback' 	=> 'afl_downline_members', 
				);
				$menu['referal_downlines'] = array(
					'#parent'					=> 'affiliate-eps-user-network',
					'#page_title'			=> __( 'Refered-members-Matrix', 'Refered-members-Matrix' ),    
					'#menu_title' 		=> __( 'Refered-members', 'Refered-members' ),    
					'#access_callback'=> 'afl_network_view', 
					'#menu_slug' 			=> 'affiliate-eps-refered-members', 
					'#page_callback' 	=> 'afl_refered_members', 
				);

				$menu['network_genealogy'] = array(
					'#parent'					=> 'affiliate-eps-user-network',
					'#page_title'			=> __( 'Genealogy-tree-Matrix', 'Genealogy-tree-Matrix' ),    
					'#menu_title' 		=> __( 'Genealogy-tree', 'Genealogy-tree' ),    
					'#access_callback'=> 'afl_network_view', 
					'#menu_slug' 			=> 'affiliate-eps-genealogy-tree', 
					'#page_callback' 	=> 'afl_genealogy_tree', 
				);

				$menu['holding_tank'] = array(
					'#parent'					=> 'affiliate-eps-user-network',
					'#page_title'			=> __( 'Holding tank-Matrix', 'Holding tank-Matrix' ),    
					'#menu_title' 		=> __( 'Holding tank', 'Holding tank' ),    
					'#access_callback'=> 'afl_network_view', 
					'#menu_slug' 			=> 'affiliate-eps-holding-tank', 
					'#page_callback' 	=> 'afl_network_holding_tank', 
				);

				$menu['my_customers'] = array(
					'#parent'					=> 'affiliate-eps-user-network',
					'#page_title'			=> __( 'My Customers-Matrix', 'My Customers-Matrix' ),    
					'#menu_title' 		=> __( 'My Customers', 'My Customers' ),    
					'#access_callback'=> 'afl_add_new_customer', 
					'#menu_slug' 			=> 'affiliate-eps-my-customers', 
					'#page_callback' 	=> 'afl_my_customers', 
				);

				// $menu['holding_toggle_placement'] = array(
				// 	// '#parent'					=> 'no-parent',
				// 	'#parent'					=> 'affiliate-eps-user-network',
				// 	'#page_title'			=> __( '', '' ),    
				// 	'#menu_title' 		=> __( 'Holding tank toggle placement', 'Holding-tank-toggle-placement' ),    
				// 	'#access_callback'=> 'afl_network_view', 
				// 	'#menu_slug' 			=> 'affiliate-eps-user-holding-toggle-placement', 
				// 	'#page_callback' 	=> 'afl_holding_tank_toggle_placement', 
				// );
				$menu['holding_genealogy_toggle_placement'] = array(
					// '#parent'					=> 'no-parent',
					'#parent'					=> 'affiliate-eps-user-network',
					'#page_title'			=> __( '', '' ),    
					'#menu_title' 		=> __( 'Holding tank Genealogy toggle placement', 'Holding-tank-genealogy-toggle-placement' ),    
					'#access_callback'=> 'afl_network_view', 
					'#menu_slug' 			=> 'affiliate-eps-user-holding-genealogy-toggle-placement', 
					'#page_callback' 	=> 'afl_holding_tank_genealogy_toggle_placement', 
				);
				afl_system_admin_menu($menu);

			}

		/*
		 * -------------------------------------------------------------------------
		 * Unilevel Network menus callback
		 * -------------------------------------------------------------------------
		 *
		 * -------------------------------------------------------------------------
		*/
			public function afl_unilevel_network_menus(){
				$menu = array();
				$menu['network'] = array(
					'#page_title'			=> __( 'Unilevel Network', 'network' ), 
					'#menu_title' 		=> __( 'Unilevel Network', 'network' ), 
					'#access_callback'=> 'afl_unilevel_add_new_member', 
					'#menu_slug' 			=> 'affiliate-eps-unilevel-user-network', 
					'#page_callback' 	=> 'afl_unilevel_add_new_member', 
					'#weight'					=> 2
				);
				$menu['add_new_member'] = array(
					'#parent'					=> 'affiliate-eps-unilevel-user-network',
					'#page_title'			=> __( 'Add new member-Unilevel', 'Add new Member-Unilevel' ), 
					'#menu_title' 		=> __( 'Add new member', 'Add new Member' ), 
					'#access_callback'=> 'afl_unilevel_add_new_member', 
					'#menu_slug' 			=> 'affiliate-eps-unilevel-user-network', 
					'#page_callback' 	=> 'afl_unilevel_add_new_member', 
				);

				$menu['add_new_customer'] = array(
					'#parent'					=> 'affiliate-eps-unilevel-user-network',
					'#page_title'			=> __( 'Add new customer-Unilevel', 'Add new customer-Unilevel' ), 
					'#menu_title' 		=> __( 'Add new customer', 'Add new customer' ), 
					'#access_callback'=> 'afl_unilevel_add_new_customer', 
					'#menu_slug' 			=> 'affiliate-eps-unilevel-add-new-customer', 
					'#page_callback' 	=> 'afl_unilevel_add_new_customer', 
				);

				$menu['network_explorer'] = array(
					'#parent'					=> 'user-network',
					'#page_title'			=> __( 'Network Explorer-Unilevel', 'Network Explorer-Unilevel' ),    
					'#menu_title' 		=> __( 'Network Explorer', 'Network Explorer' ),    
					'#access_callback'=> 'afl_unilevel_network_view', 
					'#menu_slug' 			=> 'affiliate-eps-unilevel-network-explorer', 
					'#page_callback' 	=> 'afl_unilevel_network_explorer', 
				);

				$menu['network_downlines'] = array(
					'#parent'					=> 'affiliate-eps-unilevel-user-network',
					'#page_title'			=> __( 'Downline-members-unilevel', 'Downline-members-unilevel' ),    
					'#menu_title' 		=> __( 'Downline-members', 'Downline-members' ),    
					'#access_callback'=> 'afl_unilevel_network_view', 
					'#menu_slug' 			=> 'affiliate-eps-unilevel-downline-members', 
					'#page_callback' 	=> 'afl_unilevel_downline_members', 
				);
				$menu['referal_downlines'] = array(
					'#parent'					=> 'affiliate-eps-unilevel-user-network',
					'#page_title'			=> __( 'Refered-members-unilevel', 'Refered-members-unilevel' ),    
					'#menu_title' 		=> __( 'Refered-members', 'Refered-members' ),    
					'#access_callback'=> 'afl_unilevel_network_view', 
					'#menu_slug' 			=> 'affiliate-eps-unilevel-refered-members', 
					'#page_callback' 	=> 'afl_unilevel_refered_members', 
				);

				$menu['network_genealogy'] = array(
					'#parent'					=> 'affiliate-eps-unilevel-user-network',
					'#page_title'			=> __( 'Genealogy-tree-unilevel', 'Genealogy-tree-unilevel' ),    
					'#menu_title' 		=> __( 'Genealogy-tree', 'Genealogy-tree' ),    
					'#access_callback'=> 'afl_unilevel_network_view', 
					'#menu_slug' 			=> 'affiliate-eps-unilevel-genealogy-tree', 
					'#page_callback' 	=> 'afl_unilevel_genealogy_tree', 
				);

				$menu['holding_tank'] = array(
					'#parent'					=> 'affiliate-eps-unilevel-user-network',
					'#page_title'			=> __( 'Holding tank-unilevel', 'Holding tank-unilevel' ),    
					'#menu_title' 		=> __( 'Holding tank', 'Holding tank' ),    
					'#access_callback'=> 'afl_unilevel_network_view', 
					'#menu_slug' 			=> 'affiliate-eps-unilevel-holding-tank', 
					'#page_callback' 	=> 'afl_unilevel_network_holding_tank', 
				);

				$menu['my_customers'] = array(
					'#parent'					=> 'affiliate-eps-unilevel-user-network',
					'#page_title'			=> __( 'My Customers-unilevel', 'My Customers-unilevel' ),    
					'#menu_title' 		=> __( 'My Customers', 'My Customers' ),    
					'#access_callback'=> 'afl_unilevel_add_new_customer', 
					'#menu_slug' 			=> 'affiliate-eps-unilevel-my-customers', 
					'#page_callback' 	=> 'afl_unilevel_my_customers', 
				);

				$menu['holding_genealogy_toggle_placement'] = array(
					// '#parent'					=> 'no-parent',
					'#parent'					=> 'affiliate-eps-unilevel-user-network',
					'#page_title'			=> __( '', '' ),    
					'#menu_title' 		=> __( 'Holding tank Genealogy toggle placement', 'Holding-tank-genealogy-toggle-placement' ),    
					'#access_callback'=> 'afl_unilevel_network_view', 
					'#menu_slug' 			=> 'affiliate-eps-user-unilevel-holding-genealogy-toggle-placement', 
					'#page_callback' 	=> 'afl_unilevel_holding_tank_genealogy_toggle_placement', 
				);

				afl_system_admin_menu($menu);

			}
		/*
		 * -------------------------------------------------------------------------
		 * E-wallet menus
		 * ------------- ------------------------------------------------------------
		*/
			public function afl_ewallet_menus(){
				$menu = array();
				$menu['e_wallet'] = array(
					'#page_title'			=> __( 'E-wallet', 'e_wallet' ), 
					'#menu_title' 		=> __( 'E-wallet', 'e_wallet' ), 
					'#access_callback'=> 'ewallet', 
					'#menu_slug' 			=> 'affiliate-eps-e-wallet', 
					'#page_callback' 	=> 'afl_ewallet_summary', 
					'#weight'					=> 3
				);
				// $menu['e_wallet_sub'] = array(
				// 	'#parent'					=> 'affiliate-eps-e-wallet', 
				// 	'#page_title'			=> __( 'E-wallet', 'e_wallet' ), 
				// 	'#menu_title' 		=> __( 'E-wallet', 'e_wallet' ), 
				// 	'#access_callback'=> 'ewallet', 
				// 	'#menu_slug' 			=> 'affiliate-eps-e-wallet', 
				// 	'#page_callback' 	=> 'afl_ewallet_transactions', 
				// );
				$menu['e_wallet_summary'] = array(
					'#parent'					=> 'affiliate-eps-e-wallet', 
					'#page_title'			=> __( 'E-wallet Summary', 'E-wallet Summary' ),    
					'#menu_title' 		=> __( 'E-wallet Summary', 'E-wallet Summary' ),    
					'#access_callback'=> 'ewallet', 
					'#menu_slug' 			=> 'affiliate-eps-e-wallet', 
					'#page_callback' 	=> 'afl_ewallet_summary', 
				);
				$menu['e_wallet_all_trans'] = array(
					'#parent'					=> 'affiliate-eps-e-wallet', 
					'#page_title'			=> __( 'All Transactions', 'All Transactions' ),    
					'#menu_title' 		=> __( 'All Transactions', 'All Transactions' ),    
					'#access_callback'=> 'ewallet', 
					'#menu_slug' 			=> 'affiliate-eps-ewallet-all-transactions', 
					'#page_callback' 	=> 'afl_ewallet_all_transactions', 
				);
				$menu['e_wallet_inc_report'] = array(
					'#parent'					=> 'affiliate-eps-e-wallet', 
					'#page_title'			=> __( 'Income Report', 'Income Report' ),    
					'#menu_title' 		=> __( 'E wallet Income Report', 'Income Report' ),    
					'#access_callback'=> 'ewallet', 
					'#menu_slug' 			=> 'affiliate-eps-ewallet-income-report', 
					'#page_callback' 	=> 'afl_ewallet_income_report', 
				);
				$menu['e_wallet_withdraw_report'] = array(
					'#parent'					=> 'affiliate-eps-e-wallet', 
					'#page_title'			=> __( 'Withdrawal & Expense Report', 'Withdrawal & Expense Report' ),    
					'#menu_title' 		=> __( 'Withdrawal & Expense Report', 'Withdrawal & Expense Report' ),    
					'#access_callback'=> 'ewallet', 
					'#menu_slug' 			=> 'affiliate-eps-ewallet-withdraw-report', 
					'#page_callback' 	=> 'afl_ewallet_withdrawal_report', 
				);
				$menu['e_wallet_w_fund'] = array(
					'#parent'					=> 'affiliate-eps-e-wallet', 
					'#page_title'			=> __( 'Withdraw Fund', 'Withdraw Fund' ),    
					'#menu_title' 		=> __( 'Withdraw Fund', 'Withdraw Fund' ),    
					'#access_callback'=> 'ewallet', 
					'#menu_slug' 			=> 'affiliate-eps-ewallet-withdraw-fund', 
					'#page_callback' 	=> 'afl_ewallet_withdraw_fund', 
				);
				$menu['e_wallet_pending_withdrawal'] = array(
					'#parent'					=> 'affiliate-eps-e-wallet', 
					'#page_title'			=> __( 'My Withdrawal Request', 'My Withdrawal Request' ),    
					'#menu_title' 		=> __( 'My Withdrawal Request', 'My Withdrawal Request' ),    
					'#access_callback'=> 'ewallet', 
					'#menu_slug' 			=> 'affiliate-eps-ewallet-my-withdrawal', 
					'#page_callback' 	=> 'afl_ewallet_my_withdraw_requests', 
				);
				$menu['user_payment_method'] = array(
					'#parent'					=> 'affiliate-eps-e-wallet', 
					'#page_title'			=> __( 'Select Payment method', 'Select Payment method' ),    
					'#menu_title' 		=> __( 'Select Payment method', 'Select Payment method' ),    
					'#access_callback'=> 'user_payment_method_conf', 
					'#menu_slug' 			=> 'affiliate-eps-payment_method', 
					'#page_callback' 	=> 'afl_user_payment_methods', 
				);

				afl_system_admin_menu($menu);
			}
		
		/*
		 * --------------------------------------------------------------------------
		 * Business menus
		 * --------------------------------------------------------------------------
		*/
			public function afl_business_menus(){
				$menu = array();
				$menu['business'] = array(
					'#page_title'			=> __( 'Business', 'Business' ),
					'#menu_title' 		=> __( 'Business ', 'Business' ),
					'#access_callback'=> 'business_transactions', 
					'#menu_slug' 			=> 'affiliate-eps-business', 
					'#page_callback' 	=> 'afl_business_summary', 
					'#weight'					=> 6
				);	
			
				$menu['b_summary'] = array(
					'#parent'					=> 'affiliate-eps-business',
					'#page_title'			=> __( 'Business', 'Business' ),
					'#menu_title' 		=> __( 'Business Summary', 'Business Summary' ),
					'#access_callback'=> 'business_transactions', 
					'#menu_slug' 			=> 'affiliate-eps-business', 
					'#page_callback' 	=> 'afl_business_summary',
				);
				
				$menu['b_income'] = array(
					'#parent'					=> 'affiliate-eps-business',
					'#page_title'			=> __( 'Income history', 'Income history' ),
					'#menu_title' 		=> __( 'Income history', 'Income history' ),
					'#access_callback'=> 'business_transactions', 
					'#menu_slug' 			=> 'affiliate-eps-business-income-history', 
					'#page_callback' 	=> 'afl_business_income_history',
				);
				$menu['b_expence'] = array(
					'#parent'					=> 'affiliate-eps-business',
					'#page_title'			=> __( 'Expense Report', 'Expense Report' ),
					'#menu_title' 		=> __( 'Expense Report', 'Expense Report' ),
					'#access_callback'=> 'business_transactions', 
					'#menu_slug' 			=> 'affiliate-eps-business-expense-report', 
					'#page_callback' 	=> 'afl_business_expense_history',
				);
				$menu['b_transactions'] = array(
					'#parent'					=> 'affiliate-eps-business',
					'#page_title'			=> __( 'Business Transactions', 'Business Transactions' ),
					'#menu_title' 		=> __( 'Business Transactions', 'Business Transactions' ),
					'#access_callback'=> 'business_transactions', 
					'#menu_slug' 			=> 'affiliate-eps-business-transaction', 
					'#page_callback' 	=> 'afl_business_transactions',
				);
				//system business members manage
				/*$menu['business_system_members'] = array(
					'#parent'					=> 'affiliate-eps-business',
					'#page_title'			=> __( 'Business System Members', 'Business System Members' ),
					'#menu_title' 		=> __( 'Business System Members', 'Business System Members' ),
					'#access_callback'=> 'business_system_members', 
					'#menu_slug' 			=> 'affiliate-eps-business-system-members', 
					'#page_callback' 	=> 'afl_add_edit_business_system_members', 
				);*/
				//system business profit report
				$menu['business_system_profit_report'] = array(
					'#parent'					=> 'affiliate-eps-business',
					'#page_title'			=> __( 'Business Profit Report', 'Business Profit Report' ),
					'#menu_title' 		=> __( 'Business Profit Report', 'Business Profit Report' ),
					'#access_callback'=> 'business_system_members', 
					'#menu_slug' 			=> 'affiliate-eps-business-profit', 
					'#page_callback' 	=> 'afl_system_business_profit_report', 
				);
				afl_system_admin_menu($menu);
			}
		/* 
		 * --------------------------------------------------------------------------
		 * Manage members
		 * --------------------------------------------------------------------------
		*/
		 public function afl_manage_members_menus(){
		 	$menu = array();
			$menu['manage_members'] = array(
				'#page_title'			=> __( 'Manage Members', 'Manage Members' ),
				'#menu_title' 		=> __( 'Manage Members ', 'Manage Members' ),
				'#access_callback'=> 'manage_members', 
				'#menu_slug' 			=> 'affiliate-eps-manage-members', 
				'#page_callback' 	=> 'afl_members_manage', 
				'#weight'					=>	5.2
			);
			$menu['members_manage'] = array(
				'#parent'					=> 'affiliate-eps-manage-members',
				'#page_title'			=> __( 'Manage Members', 'Manage Members' ),
				'#menu_title' 		=> __( 'Manage Members ', 'Manage Members' ),
				'#access_callback'=> 'manage_members', 
				'#menu_slug' 			=> 'affiliate-eps-manage-members', 
				'#page_callback' 	=> 'afl_members_manage', 
			);
			$menu['members_blocked'] = array(
				'#parent'					=> 'affiliate-eps-manage-members',
				'#page_title'			=> __( 'Blocked Members', 'Blocked Members' ),
				'#menu_title' 		=> __( 'Blocked Members ', 'Blocked Members' ),
				'#access_callback'=> 'manage_members', 
				'#menu_slug' 			=> 'affiliate-eps-blocked-members', 
				'#page_callback' 	=> 'afl_members_blocked', 
			);
			$menu['members_find'] = array(
				'#parent'					=> 'affiliate-eps-manage-members',
				'#page_title'			=> __( 'Find Members', 'Find Members' ),
				'#menu_title' 		=> __( 'Find Members ', 'Find Members' ),
				'#access_callback'=> 'manage_members', 
				'#menu_slug' 			=> 'affiliate-eps-find-members', 
				'#page_callback' 	=> 'afl_members_find', 
			);
			afl_system_admin_menu($menu);

		 }
		/*
		 * --------------------------------------------------------------------------
		 * Promotional Tools
		 * --------------------------------------------------------------------------
		*/
			public function afl_promotion_tools_menus() {
				$menu = array();
				$menu['promotional_tools'] = array(
					'#page_title'			=> __( 'Promotional Tools', 'Promotional Tools' ),
					'#menu_title' 		=> __( 'Promotional Tools ', 'Promotional Tools' ),
					'#access_callback'=> 'promotional_tools', 
					'#menu_slug' 			=> 'affiliate-eps-promotional-tools', 
					'#page_callback' 	=> 'afl_referal_link', 
					'#weight'					=>	6
				);
				$menu['referal_link'] = array(
					'#parent'					=> 'affiliate-eps-promotional-tools',
					'#page_title'			=> __( 'Referal Link', 'Referal Link' ),
					'#menu_title' 		=> __( 'Referal Link', 'Referal Link' ),
					'#access_callback'=> 'promotional_tools', 
					'#menu_slug' 			=> 'affiliate-eps-promotional-tools', 
					'#page_callback' 	=> 'afl_referal_link', 
				);
				afl_system_admin_menu($menu);
			}
		/*
		 * --------------------------------------------------------------------------
		 * Payout 
		 * --------------------------------------------------------------------------
		*/
			public function afl_payout_menus() {
				$menu = array();
				$menu['payout'] = array(
					'#page_title'			=> __( 'Payout', 'Payout' ),
					'#menu_title' 		=> __( 'Payout', 'Payout' ),
					'#access_callback'=> 'payout', 
					'#menu_slug' 			=> 'affiliate-eps-payout', 
					// '#page_callback' 	=> 'afl_payout_processing', 
					'#weight'					=>	6
				);
				$menu['payout_processing'] = array(
					'#parent'					=> 'affiliate-eps-payout',
					'#page_title'			=> __( 'Withdrawal requests', 'Withdrawal requests' ),
					'#menu_title' 		=> __( 'Withdrawal requests', 'Withdrawal requests' ),
					'#access_callback'=> 'payout', 
					'#menu_slug' 			=> 'affiliate-eps-payout', 
					'#page_callback' 	=> 'afl_payout_withdrawal_requests', 
				);
				/*$menu['payout_reports'] = array(
					'#parent'					=> 'affiliate-eps-payout',
					'#page_title'			=> __( 'Payout reports', 'Payout reports' ),
					'#menu_title' 		=> __( 'Payout reports', 'Payout reports' ),
					'#access_callback'=> 'payout', 
					'#menu_slug' 			=> 'affiliate-eps-payout-reports', 
					'#page_callback' 	=> 'afl_payout_reports', 
				);*/
				$menu['payout_remittance'] = array(
					'#parent'					=> 'affiliate-eps-payout',
					'#page_title'			=> __( 'Payout in Remittance', 'Payout in Remittance' ),
					'#menu_title' 		=> __( 'Payout in Remittance', 'Payout in Remittance' ),
					'#access_callback'=> 'payout', 
					'#menu_slug' 			=> 'affiliate-eps-payout-in-remittance', 
					'#page_callback' 	=> 'afl_payout_in_remittance', 
				);
				afl_system_admin_menu($menu);
			}
		/*
		 * --------------------------------------------------------------------------
		 * General Helps
		 * --------------------------------------------------------------------------
		*/
			public function afl_general_help_menus() {
				$menu = array();
				$menu['general_help'] = array(
					'#page_title'			=> __( 'General Help', 'General Help' ),
					'#menu_title' 		=> __( 'General Help', 'General Help' ),
					'#access_callback'=> 'general_help', 
					'#menu_slug' 			=> 'affiliate-eps-general-help', 
					'#page_callback' 	=> 'afl_general_help', 
					'#weight'					=>	6
				);
			}
		/*
		 * --------------------------------------------------------------------------
		 * Eps affiliates dashboard 
		 * --------------------------------------------------------------------------
		*/
			public function eps_affiiliates_dashboard () {
				add_dashboard_page( 'EPS Dashboard', 'EPS Dashboard', 'eps_affiliates_dashboard', 'eps-dashboard', array( $this,'eps_affiliates_dashboard_callback') );
			}
			public function eps_affiliates_dashboard_callback () {
				afl_get_template('dashboard/eps_dashboard_template.php');
			}
		
		/*
		 * --------------------------------------------------------------------------
		 * Features and configurations
		 * --------------------------------------------------------------------------
		*/
		 public function eps_affiiliates_system_configurations () {
		 		$menu = array();
				$menu['feactures_and_settings'] = array(
					'#parent'					=> 'affiliate-eps-system-configurations',
					'#page_title'			=> __( 'Feactures & configuration settings', 'Feactures & configuration settings' ),
					'#menu_title' 		=> __( 'Feactures & configuration settings', 'Feactures & configuration settings' ),
					'#access_callback'=> 'features_and_configuration', 
					'#menu_slug' 			=> 'affiliate-eps-features-and-configurations', 
					'#page_callback' 	=> 'afl_system_features_and_configurations', 
					'#weight'					=>	7
				);
				afl_system_admin_menu($menu);
		 }
		/*
		 * --------------------------------------------------------------------------
		 * test menus
		 * --------------------------------------------------------------------------
		*/
		 function eps_admin_test_menus () {
		 	$menu = array();
				$menu['test_menu'] = array(
					'#page_title'			=> __( 'Test', 'Test' ),
					'#menu_title' 		=> __( 'Test', 'Test' ),
					'#access_callback'=> 'afl_code_testing', 
					'#menu_slug' 			=> 'eps-test', 
					'#page_callback' 	=> 'afl_generate_users', 
				);
				$menu['generate_users'] = array(
					'#parent'					=> 'eps-test',
					'#page_title'			=> __( 'Generate Users', 'Generate Users' ),
					'#menu_title' 		=> __( 'Generate Users', 'Generate Users' ),
					'#access_callback'=> 'afl_code_testing', 
					'#menu_slug' 			=> 'eps-test', 
					'#page_callback' 	=> 'afl_generate_users', 
				);
				$menu['generate_purchase'] = array(
					'#parent'					=> 'eps-test',
					'#page_title'			=> __( 'Generate Purchase', 'Generate Purchase' ),
					'#menu_title' 		=> __( 'Generate Purchase', 'Generate Purchase' ),
					'#access_callback'=> 'afl_code_testing', 
					'#menu_slug' 			=> 'eps-generate-purchase', 
					'#page_callback' 	=> 'afl_generate_purchase', 
				);

				$menu['test_codes'] = array(
					'#parent'					=> 'eps-test',
					'#page_title'			=> __( 'Test codes', 'Test codes' ),
					'#menu_title' 		=> __( 'Test codes', 'Test codes' ),
					'#access_callback'=> 'afl_code_testing', 
					'#menu_slug' 			=> 'eps-test-codes', 
					'#page_callback' 	=> 'afl_admin_test_codes', 
				);

				$menu['fund_deposit'] = array(
					'#parent'					=> 'eps-test',
					'#page_title'			=> __( 'Fund Deposit', 'Fund Deposit' ),
					'#menu_title' 		=> __( 'Fund Deposit', 'Fund Deposit' ),
					'#access_callback'=> 'afl_code_testing', 
					'#menu_slug' 			=> 'eps-fund-deposit', 
					'#page_callback' 	=> 'afl_admin_fund_deposit', 
				);
				afl_system_admin_menu($menu);
		 }
		/*
		 * --------------------------------------------------------------------------
		 * Purchase
		 * --------------------------------------------------------------------------
		*/
		 function eps_admin_purchase () {
		 	$menu['purchase'] = array(
					'#page_title'			=> __( 'Purchase', 'Purchase' ),
					'#menu_title' 		=> __( 'Purchase', 'Purchase' ),
					'#access_callback'=> 'afl_purchase', 
					'#menu_slug' 			=> 'affiliate-eps-purchases', 
					'#page_callback' 	=> 'afl_test_purchases',
					'#weight' 				=> 8, 
				);
				afl_system_admin_menu($menu);
		 }
		/*
		 * --------------------------------------------------------------------------
		 * Reports
		 * --------------------------------------------------------------------------
		*/
		 function afl_reports () {
		 		$menu['reports'] = array(
					'#page_title'			=> __( 'Reports', 'Reports' ),
					'#menu_title' 		=> __( 'Reports', 'Reports' ),
					'#access_callback'=> 'afl_rank_performance_overview', 
					'#menu_slug' 			=> 'affiliate-eps-reports', 
					'#page_callback' 	=> 'afl_rank_performance_overview',
					'#weight' 				=> 8, 
				);
				$menu['rank_performance'] = array(
					'#parent' 				=> 'affiliate-eps-reports',
					'#page_title'			=> __( 'Rank Performance Overview', 'Rank Performance Overview' ),
					'#menu_title' 		=> __( 'Rank Performance Overview', 'Rank Performance Overview' ),
					'#access_callback'=> 'afl_rank_performance_overview', 
					'#menu_slug' 			=> 'affiliate-eps-reports', 
					'#page_callback' 	=> 'afl_rank_performance_overview',
					'#weight' 				=> 8, 
				);
				$menu['team_purchases'] = array(
					'#parent' 				=> 'affiliate-eps-reports',
					'#page_title'			=> __( 'Team Purchases Overview', 'Team Purchases Overview' ),
					'#menu_title' 		=> __( 'Team Purchases Overview', 'Team Purchases Overview' ),
					'#access_callback'=> 'afl_team_purchases_overview', 
					'#menu_slug' 			=> 'affiliate-eps-team-purchases-reports', 
					'#page_callback' 	=> 'afl_team_purchases_overview',
					'#weight' 				=> 8, 
				);
				$menu['bonus_summary'] = array(
					'#parent' 				=> 'affiliate-eps-reports',
					'#page_title'			=> __( 'Bonus Summary', 'Bonus Summary' ),
					'#menu_title' 		=> __( 'Bonus Summary', 'Bonus Summary' ),
					'#access_callback'=> 'afl_bonus_summary_report', 
					'#menu_slug' 			=> 'affiliate-eps-bonus-summary-report', 
					'#page_callback' 	=> 'afl_bonus_summary_report',
				);
				afl_system_admin_menu($menu);
		 }

		 function afl_no_parent_pages(){
		 	$payment_methods= list_extract_allowed_values(afl_variable_get('payment_methods'),'list_text',FALSE);
		 	foreach ($payment_methods as $key => $value) {
		 		$menu['payout_method_conf_'.$key] = array(
		 			'#parent'					=>'no-parent',
					'#page_title'			=> __( $value, $value ),
					'#menu_title' 		=> __( $value, $value ),
					'#access_callback'=> 'user_payment_method_conf', 
					'#menu_slug' 			=> 'user-payment-configuration', 
					'#page_callback' 	=> 'afl_user_payment_configuration',
				);
		 	}
		 		afl_system_admin_menu($menu);		
		 }
		/*
		 * ---------------------------------------------------------------------------
		 * Admin Remote Access
		 * ---------------------------------------------------------------------------
		*/
     function afl_admin_remote_api () {

				//Remote users
				$menu['remote_users'] = array(
					'#page_title'			=> __( 'Remote API', 'eps-affiliates' ), 
					'#menu_title' 		=> __( 'Remote API', 'eps-affiliates' ), 
					'#access_callback'=> 'remote_api_access', 
					'#menu_slug' 			=> 'affiliate-eps-remote-user-get', 
					'#page_callback' 	=> 'afl_admin_user_remote_access', 
				);
				afl_system_admin_menu($menu);
     }

	}
$eps_afl_admin_menu = new Eps_Affiliates_Admin_Menu;


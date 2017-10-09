<?php

if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('WC_Subscriptions_Settings')){

	class WC_Subscriptions_Settings {
		
		public function __construct()
		{
			//action when subscription became expired, if its a trial subscription, create regular subscription
			add_action('woocommerce_scheduled_subscription_expiration', array($this, 'wc_process_new_subscription'), 10, 1);
		}

		public function wc_process_new_subscription( $subscription_id )
		{
			$subscription = wcs_get_subscription( $subscription_id );
		    if  ( self::wc_is_subcription_trial( $subscription) ){
		    	
		    } else{

		    }
		    exit;
		}

		public static function wc_is_subcription_trial( $subscription )
		{
			
			if ( $subscription ) {
				if( $subscription->get_parent_id() ){
					$order = $subscription->get_parent();
					$items =  $order->get_items();

					foreach($items as $key => $item){
						$subscription_type = wc_get_order_item_meta($key, 'subscription-type', true);
				    	if($subscription_type == 'trial'){
							return true;
				    	}
					}
				}
			} else{
				return false;
			}
		}
	}
}

return new WC_Subscriptions_Settings();

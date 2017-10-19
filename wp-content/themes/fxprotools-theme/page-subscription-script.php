<?php get_header(); ?>
<?php  
function create_order_subscription($user_id){
	//setup the billing details
	$address = array(
	    'first_name' => get_the_author_meta('first_name',$user_id),
	    'last_name'  => get_the_author_meta('last_name',$user_id),
	    'company'    => get_the_author_meta('billing_company',$user_id),
	    'email'      => get_the_author_meta('email',$user_id),
	    'phone'      => get_the_author_meta('billing_phone',$user_id),
	    'address_1'  => get_the_author_meta('billing_address_1',$user_id),
	    'address_2'  => get_the_author_meta('billing_address_2',$user_id),
	    'city'       => get_the_author_meta('billing_city',$user_id),
	    'state'      => get_the_author_meta('billing_state',$user_id),
	    'postcode'   => get_the_author_meta('billing_postcode',$user_id),
	    'country'    => get_the_author_meta('billing_country',$user_id)
	);

	$start_date = date("Y-m-d h:i:sa");
	$start_to_time = strtotime(date("Y-m-d h:i:sa"));
	$next_payment = date("Y-m-d h:i:sa", strtotime("+1 month", $start_to_time));
	$parent_product = wc_get_product(48);

	$args = array(
	    'attribute_subscription-type' => 'normal'
	);

	$product_variation = $parent_product->get_matching_variation($args);
	$product = wc_get_product($product_variation);  

	// Each variation also has its own shipping class

	$shipping_class = get_term_by('slug', $product->get_shipping_class(), 'product_shipping_class');

	WC()->shipping->load_shipping_methods();
	$shipping_methods = WC()->shipping->get_shipping_methods();

	$selected_shipping_method = $shipping_methods['free_shipping'];
	$class_cost = $selected_shipping_method->get_option('class_cost_' . $shipping_class->term_id);
	$quantity = 1;


	$order = wc_create_order(array('customer_id' => $user_id));

	$order->add_product( $product, $quantity, $args);
	$order->set_address( $address, 'billing' );

	//comment out shipping settings for now
	//$order->set_address( $address, 'shipping' );

	// $order->add_shipping((object)array (
	//     'id' => $selected_shipping_method->id,
	//     'label'    => $selected_shipping_method->title,
	//     'cost'     => (float)$class_cost,
	//     'taxes'    => array(),
	//     'calc_tax'  => 'per_order'
	// ));

	$order->calculate_totals();

	$order->update_status("completed", 'Imported order', TRUE);

	// CREATE SUBSCRIPTION
	$period = WC_Subscriptions_Product::get_period( $product );
	$interval = WC_Subscriptions_Product::get_interval( $product );

	$sub = wcs_create_subscription(array('order_id' => $order->id, 'billing_period' => $period, 'billing_interval' => $interval, 'start_date' => $start_date));
	$sub->update_dates(array('schedule_next_payment' => $next_payment));
	$sub->add_product( $product, $quantity, $args);
	$sub->set_address( $address, 'billing' );

	//comment out shipping settings for now
	// $sub->set_address( $address, 'shipping' );

	// $sub->add_shipping((object)array (
	//     'id' => $selected_shipping_method->id,
	//     'label'    => $selected_shipping_method->title,
	//     'cost'     => (float)$class_cost,
	//     'taxes'    => array(),
	//     'calc_tax'  => 'per_order'
	// ));

	$sub->calculate_totals();
	WC_Subscriptions_Manager::activate_subscriptions_for_order($order);
}

/* LOOP THROUGH USERS */
//check if user has brought the item
function has_bought_items($user_id) {
    $bought = false;
    $prod_arr = array( '48' );
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => $user_id,
        'post_type'   => 'shop_order', 
        'post_status' => 'wc-completed'
    ) );
    foreach ( $customer_orders as $customer_order ) {
        $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;
        $order = wc_get_order( $customer_order );

        foreach ($order->get_items() as $item) {
            if ( version_compare( WC_VERSION, '3.0', '<' ) ) 
                $product_id = $item['product_id'];
            else
                $product_id = $item->get_product_id();

            if ( in_array( $product_id, $prod_arr ) ) 
                $bought = true;
        }
    }
    return $bought;
}

//execute order and subscription for users
$affiliates = $wpdb->get_results( "SELECT affiliate_id,user_id FROM wp_affiliate_wp_affiliates" );

foreach($affiliates as $affiliate){
	if(has_bought_items($affiliate->user_id) == true){
		create_order_subscription($affiliate->user_id);
	}
}

?>

<?php get_footer(); ?>

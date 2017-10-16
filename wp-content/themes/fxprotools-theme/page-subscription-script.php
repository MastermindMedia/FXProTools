

<?php get_header(); ?>
<?php  
$address = array(
    'first_name' => get_the_author_meta('first_name',get_current_user_id()),
    'last_name'  => get_the_author_meta('last_name',get_current_user_id()),
    'company'    => '',
    'email'      => get_the_author_meta('email',get_current_user_id()),
    'phone'      => get_the_author_meta('billing_phone',get_current_user_id()),
    'address_1'  => '',
    'address_2'  => '',
    'city'       => '',
    'state'      => '',
    'postcode'   => '',
    'country'    => ''
);
$start_date = date("Y-m-d h:i:sa");
$parent_product = wc_get_product(48);

$args = array(
    'attribute_subscription-type' => 'trial'
);

$product_variation = $parent_product->get_matching_variation($args);

$product = wc_get_product($product_variation);  

// Each variation also has its own shipping class

$shipping_class = get_term_by('slug', $product->get_shipping_class(), 'product_shipping_class');

WC()->shipping->load_shipping_methods();
$shipping_methods = WC()->shipping->get_shipping_methods();

// I have some logic for selecting which shipping method to use; your use case will likely be different, so figure out the method you need and store it in $selected_shipping_method

$selected_shipping_method = $shipping_methods['free_shipping'];

$class_cost = $selected_shipping_method->get_option('class_cost_' . $shipping_class->term_id);

$quantity = 1;

// As far as I can see, you need to create the order first, then the sub

$order = wc_create_order(array('customer_id' => get_current_user_id()));

$order->add_product( $product, $quantity, $args);
$order->set_address( $address, 'billing' );
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

//////////////////////**********************  SUBSCRIPTION
$period = WC_Subscriptions_Product::get_period( $product );
$interval = WC_Subscriptions_Product::get_interval( $product );

$sub = wcs_create_subscription(array('order_id' => $order->id, 'billing_period' => $period, 'billing_interval' => $interval, 'start_date' => $start_date));

$sub->add_product( $product, $quantity, $args);
$sub->set_address( $address, 'billing' );
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

print "<a href='/wp-admin/post.php?post=" . $sub->id . "&action=edit'>Sub created! Click here to edit</a>";


/* LOOP TO USERS */
// function has_bought_items($user_id) {
//     $bought = false;
//     $prod_arr = array( '48' );
//     $customer_orders = get_posts( array(
//         'numberposts' => -1,
//         'meta_key'    => '_customer_user',
//         'meta_value'  => $user_id,
//         'post_type'   => 'shop_order', 
//         'post_status' => 'wc-completed'
//     ) );
//     foreach ( $customer_orders as $customer_order ) {
//         $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;
//         $order = wc_get_order( $customer_order );

//         foreach ($order->get_items() as $item) {
//             if ( version_compare( WC_VERSION, '3.0', '<' ) ) 
//                 $product_id = $item['product_id'];
//             else
//                 $product_id = $item->get_product_id();

//             if ( in_array( $product_id, $prod_arr ) ) 
//                 $bought = true;
//         }
//     }
//     return $bought;
// }

// var_dump(has_bought_items(2939));

// $users = get_users();
// foreach($users as $user){
// 	if(has_bought_items($user->ID) != true){
// 		echo $user->user_login;
// 		echo '<br>';
// 	}
// }

?>
<?php get_footer(); ?>

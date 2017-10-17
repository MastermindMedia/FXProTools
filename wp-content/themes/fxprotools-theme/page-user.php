<?php get_header(); ?>
<?php  
foreach($_POST as $user_key => $user_value)
{
	update_usermeta( $_GET['id'], $user_key,  $user_value );
}
?>
	<?php get_template_part('inc/templates/nav-marketing'); ?>

	<div class="container woocommerce">
		<div class="row">
			<div class="col-md-12">
				<div class="fx-header-title">
					<h1>Your Contact</h1>
					<p>Check Below for your available contact</p>
				</div>
				<div class="panel panel-default fx-contact-panel">
					<div class="panel-body">
						<div class="media">
							<div class="media-left">
								<img src="<?php echo get_avatar_url($_GET['id']); ?>" class="media-object">
							</div>
							<div class="media-body">
								<div class="info">
									<h4 class="media-heading text-normal">
										<?php  
											if(get_the_author_meta('first_name', $_GET['id'])){
												echo get_the_author_meta('first_name', $_GET['id']) . ' ' . get_the_author_meta('last_name', $_GET['id']);
											}else{
												echo get_the_author_meta('user_login', $_GET['id']);
											}
										?>
									</h4>
									<ul class="info-list">
										<li><i class="fa fa-envelope-o"></i> <?php echo get_the_author_meta('email', $_GET['id']); ?></li>
										<li><i class="fa fa-mobile"></i> <?php echo get_the_author_meta('billing_phone', $_GET['id']); ?></li>
										<li><i class="fa fa-home"></i> <?php echo get_the_author_meta('billing_city', $_GET['id']); ?>, <?php echo get_the_author_meta('billing_state', $_GET['id']); ?></li>
									</ul>
									<p>IP Address: 192.168.8.1</p>
								</div>
								<div class="action">
									<div>
										<i class="fa fa-inbox block"></i>
										<a href="#">Send Message</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="fx-tabs-vertical marketing-contacts">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#a" data-toggle="tab">Contact Card</a></li>
								<li><a href="#b" data-toggle="tab">Edit Contact</a></li>
								<li><a href="#c" data-toggle="tab">Purchases</a></li>
								<li><a href="#d" data-toggle="tab">Memberships</a></li>
								<li><a href="#e" data-toggle="tab">Genealogy</a></li>
								<li><a href="#f" data-toggle="tab">Recent Activity</a></li>
								<li><a href="<?php echo wp_logout_url('/login/'); ?>">Logout</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade in active" id="a">
									<form action="<?php echo get_the_permalink(); ?>" method="POST" class="<?php echo ($_GET['action'] == 'edit' ? 'form-edit' : ''); ?>">
										<div class="row">
											<div class="col-md-6 m-b-lg">
												<p class="text-bold text-center">General Information</p>
												<ul class="list-info list-info-fields">
													<li><span>First Name:</span> <?php echo get_the_author_meta('first_name', $_GET['id']) ?></li>
													<li><span>Last Name:</span> <?php echo get_the_author_meta('last_name', $_GET['id']); ?></li>
													<li><span>Website:</span> <?php echo get_the_author_meta('website', $_GET['id']) ?></li>
													<li><span>Facebook:</span> <?php echo get_the_author_meta('facebook', $_GET['id']); ?></li>
													<li><span>Twitter:</span> <?php echo get_the_author_meta('twitter', $_GET['id']); ?></li>
													<li><span>Google Plus:</span> <?php echo get_the_author_meta('googleplus', $_GET['id']); ?></li>
												</ul>
											</div>
											<div class="clearfix"></div>
											<div class="col-md-6">
												<p class="text-bold text-center">Billing Information</p>
												<ul class="list-info list-info-fields">
													<li><span>Business Name:</span> <?php echo get_the_author_meta('billing_company', $_GET['id']) ?></li>
													<li><span>House # & Street Name:</span> <?php echo get_the_author_meta('billing_address_1', $_GET['id']) ?></li>
													<li><span>Apt.,suite,unit,etc.:</span> <?php echo get_the_author_meta('billing_address_2', $_GET['id']) ?></li>
													<li><span>City:</span> <?php echo get_the_author_meta('billing_city', $_GET['id']) ?></li>
													<li><span>State:</span> <?php echo get_the_author_meta('billing_state', $_GET['id']) ?></li>
													<li><span>Zip Code:</span> <?php echo get_the_author_meta('billing_postcode', $_GET['id']) ?></li>
												</ul>
											</div>
											<div class="col-md-6">
												<p class="text-bold text-center">Shipping Information</p>
												<ul class="list-info list-info-fields">
													<li><span>Business Name:</span> <?php echo get_the_author_meta('shipping_company', $_GET['id']) ?></li>
													<li><span>House # & Street Name:</span> <?php echo get_the_author_meta('shipping_address_1', $_GET['id']) ?></li>
													<li><span>Apt.,suite,unit,etc.:</span> <?php echo get_the_author_meta('shipping_address_2', $_GET['id']) ?></li>
													<li><span>City:</span> <?php echo get_the_author_meta('shipping_city', $_GET['id']) ?></li>
													<li><span>State:</span> <?php echo get_the_author_meta('shipping_state', $_GET['id']) ?></li>
													<li><span>Zip Code:</span> <?php echo get_the_author_meta('shipping_postcode', $_GET['id']) ?></li>
												</ul>
											</div>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="b">
									<form action="<?php echo get_the_permalink(); ?>/?id=<?php echo $_GET['id']; ?>" method="POST" class="form-edit">
										<div class="row">
											<div class="col-md-6 m-b-lg">
												<p class="text-bold text-center">General Information</p>
												<ul class="list-info list-info-fields">
													<li><span>First Name:</span> <input type="text" name="first_name" id="first_name" value="<?php echo get_the_author_meta('first_name', $_GET['id']) ?>" /></li>
													<li><span>Last Name:</span> <input type="text" name="last_name" id="last_name" value="<?php echo get_the_author_meta('last_name', $_GET['id']) ?>" /></li>
													<li><span>Website:</span> <input type="text" name="website" id="website" value="<?php echo get_the_author_meta('website', $_GET['id']) ?>" /></li>
													<li><span>Facebook:</span> <input type="text" name="facebook" id="facebook" value="<?php echo get_the_author_meta('facebook', $_GET['id']) ?>" /></li>
													<li><span>Twitter:</span> <input type="text" name="twitter" id="twitter" value="<?php echo get_the_author_meta('twitter', $_GET['id']) ?>" /></li>
													<li><span>Google Plus:</span> <input type="text" name="googleplus" id="googleplus" value="<?php echo get_the_author_meta('googleplus', $_GET['id']) ?>" /></li>
												</ul>
											</div>
											<div class="clearfix"></div>
											<div class="col-md-6">
												<p class="text-bold text-center">Billing Information</p>
												<ul class="list-info list-info-fields">
													<li><span>Business Name:</span> <input type="text" name="billing_company" id="billing_company" value="<?php echo get_the_author_meta('billing_company', $_GET['id']) ?>" /></li>
													<li><span>House # & Street Name:</span> <input type="text" name="billing_address_1" id="billing_address_1" value="<?php echo get_the_author_meta('billing_address_1', $_GET['id']) ?>" /></li>
													<li><span>Apt.,suite,unit,etc.:</span> <input type="text" name="billing_address_2" id="billing_address_2" value="<?php echo get_the_author_meta('billing_address_2', $_GET['id']) ?>" /></li>
													<li><span>City:</span> <input type="text" name="billing_city" id="billing_city" value="<?php echo get_the_author_meta('billing_city', $_GET['id']) ?>" /></li>
													<li><span>State:</span> <input type="text" name="billing_state" id="billing_state" value="<?php echo get_the_author_meta('billing_state', $_GET['id']) ?>" /></li>
													<li><span>Zip Code:</span> <input type="text" name="billing_postcode" id="billing_postcode" value="<?php echo get_the_author_meta('billing_postcode', $_GET['id']) ?>" /></li>
												</ul>
											</div>
											<div class="col-md-6">
												<p class="text-bold text-center">Shipping Information</p>
												<ul class="list-info list-info-fields">
													<li><span>Business Name:</span> <input type="text" name="shipping_company" id="shipping_company" value="<?php echo get_the_author_meta('shipping_company', $_GET['id']) ?>" /></li>
													<li><span>House # & Street Name:</span> <input type="text" name="shipping_address_1" id="shipping_address_1" value="<?php echo get_the_author_meta('shipping_address_1', $_GET['id']) ?>" /></li>
													<li><span>Apt.,suite,unit,etc.:</span> <input type="text" name="shipping_address_2" id="shipping_address_2" value="<?php echo get_the_author_meta('shipping_address_2', $_GET['id']) ?>" /></li>
													<li><span>City:</span> <input type="text" name="shipping_city" id="shipping_city" value="<?php echo get_the_author_meta('shipping_city', $_GET['id']) ?>" /></li>
													<li><span>State:</span> <input type="text" name="shipping_state" id="shipping_state" value="<?php echo get_the_author_meta('shipping_state', $_GET['id']) ?>" /></li>
													<li><span>Zip Code:</span> <input type="text" name="shipping_postcode" id="shipping_postcode" value="<?php echo get_the_author_meta('shipping_postcode', $_GET['id']) ?>" /></li>
												</ul>
											</div>
										</div>
										<div class="btn-holder btn-right m-t-lg">
											<button type="submit" class="btn btn-default">Save</button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="c">
									<div class="user-cancellation">
										<div class="progress">
										  <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" style="width: 80%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">STEP 3 of 3</div>
										</div>
										<h2 class="text-center;">WAIT! Final Step BEFORE Your Account Is Deleted!</h2>
										<p>This is a special one time offer! You may not see this offer available again if you close this page.</p>
										<p>You don't currently qualify for any downgraded plan option other then "Paused". </p>
										<div class="row">
											<div class="col-md-6">
												<h3>Pause Account - $9.99 Month</h3>
											</div>
											<div class="col-md-6">
												<a href="#" class="btn btn-danger btn-block btn-lg btn-pause" data-subscription-id="<?php echo isset( $_GET['subs_id'] ) ? $_GET['subs_id'] : 0;?>">Pause My Account - $9.99 / Month</a>
											</div>
										</div>
										<p>(If you pause, your pages will not display live, you won't be able to use the ClickFunnels App... but we'll keep your subdomain reserved and all your pages and funnels waiting so you can resume your account anytime.)</p>
										<div class="row">
											<div class="col-md-6">
												<h3>Or...Finalize Account Cancellation:</h3>
											</div>
											<div class="col-md-6">
												<button type="button" data-toggle="modal" data-target="#cancellation-modal" class="btn btn-danger btn-block btn-lg">Finalize Cancellation</button>
											</div>
										</div>
										<p><strong>IMPORTANT:</strong> If you cancel your account, please note that your username (<?php echo  wp_get_current_user()->user_login;?>) will be made available for someone else; any progress and access to pages you've created will be disabled; optins and leads will not be collected; and videos will not display if you added your own.</p>
									</div>

									<?php
									$my_orders_columns = get_order_columns();
									$customer_orders = get_purchased_items($_GET['id']);
									if ( $customer_orders ){ ?>
										<p class="text-bold hide-on-cancel">Purchases</p>
										<table class="shop_table shop_table_responsive my_account_orders">
											<thead>
												<tr>
													<?php foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
														<th class="<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
													<?php endforeach; ?>
												</tr>
											</thead>

											<tbody>
												<?php foreach ( $customer_orders as $customer_order ) :
													$order      = wc_get_order( $customer_order );
													$item_count = $order->get_item_count();
													?>
													<tr class="order">
														<?php foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
															<td class="<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
																<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
																	<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

																<?php elseif ( 'order-number' === $column_id ) : ?>
																	<?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number(); ?>

																<?php elseif ( 'order-date' === $column_id ) : ?>
																	<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>

																<?php elseif ( 'order-status' === $column_id ) : ?>
																	<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>

																<?php elseif ( 'order-total' === $column_id ) : ?>
																	<?php
																	/* translators: 1: formatted order total 2: total order items */
																	printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count );
																	?>

																<?php elseif ( 'order-actions' === $column_id ) : ?>
																	<?php
																		$actions = array(
																			'pay'    => array(
																				'url'  => $order->get_checkout_payment_url(),
																				'name' => __( 'Pay', 'woocommerce' ),
																			),
																			'view'   => array(
																				'url'  => $order->get_view_order_url(),
																				'name' => __( 'View', 'woocommerce' ),
																			),
																			'cancel' => array(
																				'url'  => $order->get_cancel_order_url( wc_get_page_permalink( 'myaccount' ) ),
																				'name' => __( 'Cancel', 'woocommerce' ),
																			),
																		);

																		if ( ! $order->needs_payment() ) {
																			unset( $actions['pay'] );
																		}

																		if ( ! in_array( $order->get_status(), apply_filters( 'woocommerce_valid_order_statuses_for_cancel', array( 'pending', 'failed' ), $order ) ) ) {
																			unset( $actions['cancel'] );
																		}

																		if ( $actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order ) ) {
																			foreach ( $actions as $key => $action ) {
																				echo '<a href="' . get_the_permalink() . '?id=' . $_GET['id'] . '&order_id=' . $order->get_order_number() . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
																			}
																		}
																	?>
																<?php endif; ?>
															</td>
														<?php endforeach; ?>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>

										<?php if($_GET['order_id']){ ?>
										<div class="purchases-view-order">
											<?php get_template_part('woocommerce/myaccount/view-order'); ?>
											<div class="cancel-step-1">
												<h3 class="m-b-md">Cancel Purchase</h3>
												<div class="progress">
												  <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" style="width: 33%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">STEP 1 of 3</div>
												</div>
												<p><a href="<?php echo get_option('home'); ?>/cancel-step-1?id=<?php echo $_GET['id'] ?>&order_id=<?php echo $_GET['order_id'] ?>&order_type=purchase" class="btn btn-danger btn-lg">Start Cancellation Process</a></p>
												<p><strong>IMPORTANT:</strong> If you cancel your account, please note that your subdomain (mastermindmedia) will be made available for someone else; any funnels and pages you've created will be disabled; optins and leads will not be collected; and videos will not play.</p>
											</div>
											<a href="#" id="back-to-purchases" class="btn btn-default">Back to Purchases</a>
										</div>
										<?php } ?>

									<?php }else{ ?>
										<p class="hide-on-cancel">No purchases found.</p>
									<?php } ?>
									<div id="view-purchase-details">
										<div class="purchase-details-info"></div>
										<div class="panel panel-default">
											<div class="clearfix">
												<div class="col-md-12">
													<h3 class="m-b-md">Cancel Purchase</h3>
													<div class="progress">
													  <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 33%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">STEP 1 of 3</div>
													</div>
													<p><a href="<?php echo get_option('home'); ?>/cancel-step-1" class="btn btn-danger btn-lg">Start Cancellation Process</a></p>
													<p><strong>IMPORTANT:</strong> If you cancel your account, please note that your subdomain (mastermindmedia) will be made available for someone else; any funnels and pages you've created will be disabled; optins and leads will not be collected; and videos will not play.</p>
												</div>
											</div>
										</div>
										<a href="#" id="close-purchase-details" class="btn btn-default m-t-md">Back to List of Purchases</a>
									</div>
								</div>
								<div class="tab-pane fade" id="d">
									<div class="user-cancellation">
										<div class="progress">
										  <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" style="width: 80%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">STEP 3 of 3</div>
										</div>
										<h2 class="text-center;">WAIT! Final Step BEFORE Your Account Is Deleted!</h2>
										<p>This is a special one time offer! You may not see this offer available again if you close this page.</p>
										<p>You don't currently qualify for any downgraded plan option other then "Paused". </p>
										<div class="row">
											<div class="col-md-6">
												<h3>Pause Account - $9.99 Month</h3>
											</div>
											<div class="col-md-6">
												<a href="#" class="btn btn-danger btn-block btn-lg btn-pause" data-subscription-id="<?php echo isset( $_GET['subs_id'] ) ? $_GET['subs_id'] : 0;?>">Pause My Account - $9.99 / Month</a>
											</div>
										</div>
										<p>(If you pause, your pages will not display live, you won't be able to use the ClickFunnels App... but we'll keep your subdomain reserved and all your pages and funnels waiting so you can resume your account anytime.)</p>
										<div class="row">
											<div class="col-md-6">
												<h3>Or...Finalize Account Cancellation:</h3>
											</div>
											<div class="col-md-6">
												<button type="button" data-toggle="modal" data-target="#cancellation-modal" class="btn btn-danger btn-block btn-lg">Finalize Cancellation</button>
											</div>
										</div>
										<p><strong>IMPORTANT:</strong> If you cancel your account, please note that your username (USER_NAME) will be made available for someone else; any progress and access to pages you've created will be disabled; optins and leads will not be collected; and videos will not display if you added your own.</p>
									</div>

									<p class="text-bold hide-on-cancel">Memberships Section</p>
									<?php 
										//update subscription data based on user id param
										$subscriptions = wcs_get_users_subscriptions( $_GET['id'] );
									?>

									<div class="woocommerce_account_subscriptions hide-on-cancel">

										<?php if ( WC_Subscriptions::is_woocommerce_pre( '2.6' ) ) : ?>
										<h2><?php esc_html_e( 'My Subscriptions', 'woocommerce-subscriptions' ); ?></h2>
										<?php endif; ?>

										<?php if ( ! empty( $subscriptions ) ) : ?>
										<table class="shop_table shop_table_responsive my_account_subscriptions my_account_orders">

										<thead>
											<tr>
												<th class="subscription-id order-number"><span class="nobr"><?php esc_html_e( 'Subscription', 'woocommerce-subscriptions' ); ?></span></th>
												<th class="subscription-status order-status"><span class="nobr"><?php esc_html_e( 'Status', 'woocommerce-subscriptions' ); ?></span></th>
												<th class="subscription-next-payment order-date"><span class="nobr"><?php echo esc_html_x( 'Next Payment', 'table heading', 'woocommerce-subscriptions' ); ?></span></th>
												<th class="subscription-total order-total"><span class="nobr"><?php echo esc_html_x( 'Total', 'table heading', 'woocommerce-subscriptions' ); ?></span></th>
												<th class="subscription-actions order-actions">&nbsp;</th>
											</tr>
										</thead>

										<tbody>
										<?php foreach ( $subscriptions as $subscription_id => $subscription ) : ?>
											<tr class="order">
												<td class="subscription-id order-number" data-title="<?php esc_attr_e( 'ID', 'woocommerce-subscriptions' ); ?>">
													<?php echo esc_html( sprintf( _x( '#%s', 'hash before order number', 'woocommerce-subscriptions' ), $subscription->get_order_number() ) ); ?>
													<?php do_action( 'woocommerce_my_subscriptions_after_subscription_id', $subscription ); ?>
												</td>
												<td class="subscription-status order-status" data-title="<?php esc_attr_e( 'Status', 'woocommerce-subscriptions' ); ?>">
													<?php echo esc_attr( wcs_get_subscription_status_name( $subscription->get_status() ) ); ?>
												</td>
												<td class="subscription-next-payment order-date" data-title="<?php echo esc_attr_x( 'Next Payment', 'table heading', 'woocommerce-subscriptions' ); ?>">
													<?php echo esc_attr( $subscription->get_date_to_display( 'next_payment' ) ); ?>
													<?php if ( ! $subscription->is_manual() && $subscription->has_status( 'active' ) && $subscription->get_time( 'next_payment' ) > 0 ) : ?>
														<?php
														// translators: placeholder is the display name of a payment gateway a subscription was paid by
														$payment_method_to_display = sprintf( __( 'Via %s', 'woocommerce-subscriptions' ), $subscription->get_payment_method_to_display() );
														$payment_method_to_display = apply_filters( 'woocommerce_my_subscriptions_payment_method', $payment_method_to_display, $subscription );
														?>
													<br/><small><?php echo esc_attr( $payment_method_to_display ); ?></small>
													<?php endif; ?>
												</td>
												<td class="subscription-total order-total" data-title="<?php echo esc_attr_x( 'Total', 'Used in data attribute. Escaped', 'woocommerce-subscriptions' ); ?>">
													<?php echo wp_kses_post( $subscription->get_formatted_order_total() ); ?>
												</td>
												<td class="subscription-actions order-actions">
													<a href="<?php echo get_the_permalink() . '?id=' . $_GET['id'] . '&subs_id=' . $subscription->get_order_number() ?>" class="button view"><?php echo esc_html_x( 'View', 'view a subscription', 'woocommerce-subscriptions' ); ?></a>
													<?php do_action( 'woocommerce_my_subscriptions_actions', $subscription ); ?>
												</td>
											</tr>
										<?php endforeach; ?>
										</tbody>

										</table>
										<?php else : ?>

											<p class="no_subscriptions">
												<?php
												// translators: placeholders are opening and closing link tags to take to the shop page
												printf( esc_html__( 'You have no active subscriptions. Find your first subscription in the %sstore%s.', 'woocommerce-subscriptions' ), '<a href="' . esc_url( apply_filters( 'woocommerce_subscriptions_message_store_url', get_permalink( wc_get_page_id( 'shop' ) ) ) ) . '">', '</a>' );
												?>
											</p>

										<?php endif; ?>

									</div>

									<?php if($_GET['subs_id']){ ?>
									<div class="membership-view-subs hide-on-cancel">
										<?php get_template_part('woocommerce/myaccount/view-subscription'); ?>
										<div class="cancel-step-1">
											<h3 class="m-b-md">Cancel Membership</h3>
											<div class="progress">
											  <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" style="width: 33%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">STEP 1 of 3</div>
											</div>
											<p><a href="<?php echo get_option('home'); ?>/cancel-step-1?id=<?php echo $_GET['id'] ?>&subs_id=<?php echo $_GET['subs_id'] ?>&order_type=membership" class="btn btn-danger btn-lg">Start Cancellation Process</a></p>
											<p><strong>IMPORTANT:</strong> If you cancel your account, please note that your subdomain (mastermindmedia) will be made available for someone else; any funnels and pages you've created will be disabled; optins and leads will not be collected; and videos will not play.</p>
										</div>
										<a href="#" id="back-to-memberships" class="btn btn-default">Back to Memberships</a>
									</div>
									<?php } ?>
								</div>
								<div class="tab-pane fade" id="e">
									<p class="text-bold">Genealogy Section</p>
								</div>
								<div class="tab-pane fade" id="f">
									<table id="table-recent-activity" class="table table-bordered">
										<thead>
											<tr>
												<th>Page Name</th>
												<th>Page Url</th>
												<th>Time</th>
											</tr>
										</thead>
										<tbody>
											<?php  
											$counter = 1;
											$recent_activity = get_user_meta( get_current_user_id(), "track_user_history" )[0];

											$reverse = array_reverse($recent_activity, true);
											foreach($reverse as $act_data){
												if($counter <= 10){
													if($act_data['title']){
											?>
														<tr>
															<td><?php echo $act_data['title'] ?></td>
															<td><a href="<?php echo $act_data['link'] ?>"><?php echo $act_data['link'] ?></a></td>
															<td><?php echo random_checkout_time_elapsed($act_data['time']) ?></td>
														</tr>
											<?php
														$counter++;
													}
												}else{
													break;
												}
											}

											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php require_once('inc/templates/my-account/modal.php'); ?>

<?php get_footer(); ?>

<script type="text/javascript">
	$(document).ready(function(){
		$('.view-purchase-details').click(function(e){
			e.preventDefault();
			var html = $('#'+$(this).attr('data-target'))[0].outerHTML;
			$('#view-purchase-details .purchase-details-info').html('');
			$('#view-purchase-details .purchase-details-info').prepend(html);
			$('#table-purchases').hide();
			$('#view-purchase-details').fadeIn();
		});
		$('#close-purchase-details').click(function(e){
			e.preventDefault();
			$('#view-purchase-details').hide();
			$('#table-purchases').fadeIn();
		});

	});
</script>

<?php if( isset($_GET['cancel']) && $_GET['cancel'] == "yes" && $_GET['order_type'] == "purchase"){ ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.marketing-contacts a[href="#c"]').click();
		$('.tab-pane#c').addClass('tab-pane-cancellation');
	});
</script>
<?php } ?>

<?php if( isset($_GET['cancel']) && $_GET['cancel'] == "yes" && $_GET['order_type'] == "membership"){ ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.marketing-contacts a[href="#d"]').click();
		$('.tab-pane#d').addClass('tab-pane-cancellation');
	});
</script>
<?php } ?>

<?php if( isset($_GET['order_id']) ){ ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.marketing-contacts a[href="#c"]').click();
		$('.tab-pane#c .my_account_orders').hide();
		$('#back-to-purchases').click(function(e){
			e.preventDefault();
			$('.tab-pane#c .my_account_orders').fadeIn();
			$('.purchases-view-order').hide();
		});
	});
</script>
<?php } ?>

<?php if(isset($_GET['subs_id'])){ ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.marketing-contacts a[href="#d"]').click();
		$('.tab-pane#d .my_account_subscriptions').hide();
		$('#back-to-memberships').click(function(e){
			e.preventDefault();
			$('.tab-pane#d .my_account_subscriptions').fadeIn();
			$('.membership-view-subs').hide();
		});
	});
</script>
<?php } ?>
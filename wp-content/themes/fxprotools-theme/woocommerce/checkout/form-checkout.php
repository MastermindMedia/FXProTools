<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */
 
get_header();

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}
 
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields1' );
function custom_override_checkout_fields1( $fields ) {
	unset($fields['order']['order_comments']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_company']);
    return $fields;
}

/* WooCommerce: The Code Below Removes The Additional Information Tab */
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
	unset( $tabs['additional_information'] );
	return $tabs;
}

add_filter('woocommerce_product_additional_information_heading', 'isa_product_additional_information_heading');
function isa_product_additional_information_heading() {
    echo '';
}

add_filter("woocommerce_checkout_fields", "custom_override_checkout_fields2", 1);
function custom_override_checkout_fields2($fields) {
    $fields['billing']['billing_first_name']['priority'] = 1;
    $fields['billing']['billing_last_name']['priority'] = 2;
    $fields['billing']['billing_email']['priority'] = 3;
    $fields['billing']['billing_phone']['priority'] = 4;
    $fields['billing']['billing_state']['priority'] = 5;
    $fields['billing']['billing_address_1']['priority'] = 6;
    $fields['billing']['billing_address_2']['priority'] = 7;
    $fields['billing']['billing_city']['priority'] = 8;
    $fields['billing']['billing_postcode']['priority'] = 9;
    $fields['billing']['billing_company']['priority'] = 10;
    $fields['billing']['billing_country']['priority'] = 11;
    return $fields;
}

add_filter( 'woocommerce_default_address_fields', 'custom_override_default_locale_fields' );
function custom_override_default_locale_fields( $fields ) {
    $fields['email']['priority'] = 3;
    $fields['address_1']['priority'] = 6;
    $fields['address_2']['priority'] = 7;
    return $fields;
}

?>


<form name="checkout" method="post" class="checkout checkout_layout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-2">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

	<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	
	<div class="checkout-sidebar">
		<div class="checkout-sidebar-item">
			<img src="https://forcefactor.me/assets/images/product/aspire.png">
		</div>
		<div class="checkout-sidebar-item">
			<h3>What Our Members Are Saying...</h3>
		</div>
		<div class="checkout-sidebar-item">
			<img src="https://forcefactor.me/assets/images/testimonial/checkout.jpg">
		</div>
		<div class="checkout-sidebar-item">
			<h3>HERE'S WHAT YOU ARE GETTING...</h3>
			<ul class="check-lit">
				<li>Access to our private online membership site.</li>
				<li>Eye-opening video success training that provides simple, step by step rules for getting your online business up and running.</li>
				<li>Access to your own personal team of coaches who are ready to work one-on-one with you to help you achieve success.</li>
				<li>Exceptional support. We care about your results, so we have provided live chat and email support so you can get the answers you need when you need them.</li>
				<li>And more than a dozen other high-value online business resources that will provide the motivation, the tools and the know-how you need to get to the next level in your business.</li>
			</ul>
		</div>
		<div class="checkout-sidebar-item">
			<div class="checkout-icon-box checkout-icon-box-1">
				<h4>100% MONEY BACK GUARANTEE</h4>
				<p>If you decide that it's not for you, just let us know and you'll be issued a full and prompt refund, no questions asked.</p>
			</div>
		</div>
		<div class="checkout-sidebar-item">
			<div class="checkout-icon-box checkout-icon-box-2">
				<h4>YOUR INFORMATION IS SAFE</h4>
				<p>We will not sell, rent, or share your contact information for any reason.</p>
			</div>
		</div>
		<div class="checkout-sidebar-item">
			<div class="checkout-icon-box checkout-icon-box-3">
				<h4>YOUR INFORMATION IS SAFE</h4>
				<p>All information is encrypted and transmitted without risk using a SSL protocol.</p>
			</div>
		</div>
	</div>

	<div id="checkout-panel-3" class="panel panel-default panel-gray">
		<div class="panel-body">
			<h5>Order Summary <span>Price:</span></h5>
			<div class="term-wrap row">
				<div class="col-md-1 col-xs-1">
					<input type="checkbox" value="1">
				</div>
				<div class="col-md-11 col-xs-11 no-pad-left">
					<strong> <u>Yes, please don't let my access expire.</u></strong><br>
					<span class="term-wrap-text">
						After 30 days please keep my ASPIRE membership running (until I choose to cancel) for $37/month.
						<br><span class="highlight">Includes Personal Coach.</span>
					</span>
				</div>
				<br>
				<div class="col-md-1 col-xs-1">
					<input type="checkbox" value="1">
				</div>
				<div class="col-md-11 col-xs-11 no-pad-left">
					<span class="term-wrap-text">
						I agree with the
						<a href="#" onclick="window.open('#', 'newwindow', 'width=500, height=700'); return false">Purchase Agreement</a>,
						<a href="#" onclick="window.open('#', 'newwindow', 'width=500, height=700'); return false">Refund Policy</a>,
						<a href="#" onclick="window.open('#', 'newwindow', 'width=500, height=700'); return false">Terms of Service</a>,
						and <a href="#" onclick="window.open('#', 'newwindow', 'width=500, height=700'); return false">Privacy Policy</a>.
					</span>
				</div>
			</div>
			<div class="col-md-12 submit-btn-wrap">
				<div class="text-center">
					<button type="submit" id="submit-btn" class="btn btn-danger btn-lg m-b-md btn-lg-w-text">Finish My Order <span class="fa fa-angle-right"></span> </button>
				</div>
			</div>
	 	</div>
	 </div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<div class="modal fade" id="checkout-popoup" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <button type="button" id="hide-checkout-popup" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body">
      	<h2 class="text-center">WAIT!!</h2>
      	<h3 class="text-center">DON'T GO EMPTY HANDED...</h3>
        <p class="intro-note label-red text-center">GET STARTED TODAY FOR $1.00</p>
        <p class="text-center"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/dollar.jpg"></p>
        <p>....Because you took time to visit our website we are presenting you with this valuable, <strong>ONE TIME ONLY, $1 TRIAL OFFER...</strong></p>
        <p><strong>No Tricks or Gimmicks</strong>....click the red "GET STARTED FOR $1.00 TODAY" button below right now... <span class="label-red">you'll receive this product for 30 days! Only $1.00!</span></p>
      	<p>Remember... we show you exactly - step-by- step - how to start earning money in your spare time from home... while doing fun, simple work right from your computer, tablet or smart-phone.</p>
      	<p>So go ahead and <a href="#">take advantage of this no-risk</a>, $1 TRIAL OFFER right now because you will never see it again once you leave this page.</p>
      	<p><strong>LAST CHANCE!</strong> Just click the "<strong>GET STARTED FOR $1.00 TODAY</strong>" button below... so can learn how to start earning a full time income from home.</p>
      	<div class="text-center">
      		<a href="#" class="btn btn-success btn-lg m-b-md btn-lg-w-text">
				Get Your Access For $1.00 Trial Now!
				<span>Sign-up takes less than 60 seconds. Pick a plan to get started!</span>
			</a>
      	</div>
      	<p>P.S. Immediately after clicking the red button above, you will get <a href="#">instant access</a> to the Training Website.</p>
      </div>
    </div>
  </div>
</div>

<?php  
//sample customer data
$recent_orders=get_posts( array(
        'post_type' => 'shop_order', 
        'post_status' => 'wc-completed',
        'numberposts' => 7
) );
$customer_recent_orders = array();
$counter = 0;

foreach($recent_orders as $recent_order){
	$order = new WC_Order( $recent_order->ID );
	$items = $order->get_items();
    foreach( $items as $item ) {
		$customer_recent_orders[$counter]['image'] = "https://s3.amazonaws.com/da-my/proof/229/map_229448.png";
		$customer_recent_orders[$counter]['name'] = get_user_meta($order->user_id, 'first_name',true) . ' ' . get_user_meta($order->user_id, 'last_name',true) . ', ' . get_user_meta($order->user_id, 'billing_city',true) . ', ' . get_user_meta($order->user_id, 'billing_state',true);
		$customer_recent_orders[$counter]['activity'] = "Recently ordered " . $item['name'];
		$customer_recent_orders[$counter]['time'] = time_elapsed_string($recent_order->post_date);
		$counter++;
    }
}
?>

<script type="text/javascript">
	jQuery(document).ready(function(){
		var customer_notif = <?php echo json_encode($customer_recent_orders) ?>;
		var customer_size = customer_notif.length;
		var counter = 1;

		jQuery('[data-toggle="popover"]').popover(); 

		setInterval(function(){
			if(counter > customer_size){
				counter = 1;
			}
			var customer_index = counter - 1;
			new Noty({
				type: 'alert',
				layout: 'bottomLeft',
			    text: '<div class="customer-notif"><img src="'+ customer_notif[customer_index].image +'"><div class="customer-notif-main"><div class="customer-name">'+ customer_notif[customer_index].name +'</div><div class="customer-activity">'+ customer_notif[customer_index].activity +'</div><div class="customer-time">'+ customer_notif[customer_index].time +'</div></div></div>',
			    theme: 'relax',
			    progressBar: false,
			    timeout: 7000,
			    visibilityControl: false
			}).show();
			counter++;
		},10000);

		jQuery(document).mouseleave(function () {
			if( ! $.cookie('checkout_popup_cookie') ){
				jQuery('#checkout-popoup').modal('show');
			}
		});

		jQuery('#hide-checkout-popup').click(function(){
			jQuery('#checkout-popoup').modal('hide');
			$.cookie('checkout_popup_cookie', 'active', { expires: .5 });
		});
	});
</script>



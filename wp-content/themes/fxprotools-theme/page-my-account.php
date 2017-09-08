<?php get_header(); ?>

<?php  

//update user meta
foreach($_POST as $user_key => $user_value){
	update_usermeta( get_current_user_id(), $user_key,  $user_value );
}

?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="fx-header-title">
				<h1>Your Account</h1>
				<p>Check Below for your available contact</p>
			</div>
			<div class="panel panel-default fx-contact-panel">
				<div class="panel-body">
					<div class="media">
						<div class="media-left">
							<img src="http://via.placeholder.com/100x100?text=Image" class="media-object">
						</div>
						<div class="media-body">
							<div class="info">
								<h4 class="media-heading text-normal">John Benedict Doe</h4>
								<ul class="info-list">
									<li><i class="fa fa-envelope-o"></i> user-email@gmail.com</li>
									<li><i class="fa fa-mobile"></i> (123) 456-7890</li>
									<li><i class="fa fa-home"></i> City, State</li>
								</ul>
								<p>IP Address: 192.168.8.1</p>
							</div>
							<div class="action">
								<div>
									<i class="fa fa-inbox block"></i>
									<a href="<?php bloginfo('url'); ?>/my-account/inbox/">Inbox</a>
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
							<li class="active"><a href="#a" data-toggle="tab">Your Information</a></li>
							<li><a href="#b" data-toggle="tab">Edit Contact</a></li>
							<li><a href="#c" data-toggle="tab">Purchases</a></li>
							<li><a href="#d" data-toggle="tab">Memberships</a></li>
							<li><a href="#e" data-toggle="tab">Your Sponsor</a></li>
							<li><a href="#f" data-toggle="tab">Recent Activity</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade in active" id="a">
								<form action="<?php echo get_the_permalink(); ?>" method="POST" class="<?php echo ($_GET['action'] == 'edit' ? 'form-edit' : ''); ?>">
									<div class="row">
										<div class="col-md-6 m-b-lg">
											<p class="text-bold text-center">General Information</p>
											<ul class="list-info list-info-fields">
												<li><span>Birthday:</span> <?php echo ($_GET['action'] == 'edit' ? '<input type="date" name="c_bday" id="c_bday" value="'. get_the_author_meta('c_bday', get_current_user_id()) .'" />' : ' ' . get_the_author_meta('c_bday', get_current_user_id()) ); ?></li>
												<li><span>Age:</span> <?php echo ($_GET['action'] == 'edit' ? '<input type="text" disabled="disabled" name="billing_postcode" id="billing_postcode" value="'. date_diff(date_create(get_the_author_meta('c_bday', get_current_user_id())), date_create('today'))->y .'" />' : ' ' . date_diff(date_create(get_the_author_meta('c_bday', get_current_user_id())), date_create('today'))->y ); ?></li>
												<li><span>Gender:</span> 
													<?php if($_GET['action'] == 'edit'){ ?>
													<select name="c_gender" id="c_gender">
														<option value="Male" <?php if(get_the_author_meta( 'c_gender', get_current_user_id() ) == "Male"){echo 'selected';} ?>>Male</option>
														<option value="Female" <?php if(get_the_author_meta( 'c_gender', get_current_user_id() ) == "Female"){echo 'selected';} ?>>Female</option>
													</select>
													<?php 
													}else{ 
														echo get_the_author_meta('c_gender', get_current_user_id());
													}
													?>
												</li>
											</ul>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-6">
											<p class="text-bold text-center">Billing Information</p>
											<ul class="list-info list-info-fields">
												<li><span>Business Name:</span> <?php echo ($_GET['action'] == 'edit' ? '<input type="text" name="bill_business_name" id="bill_business_name" value="'. get_the_author_meta('bill_business_name', get_current_user_id()) .'" />' : ' ' . get_the_author_meta('bill_business_name', get_current_user_id()) ); ?></li>
												<li><span>House # & Street Name:</span> <?php echo ($_GET['action'] == 'edit' ? '<input type="text" name="billing_address_1" id="billing_address_1" value="'. get_the_author_meta('billing_address_1', get_current_user_id()) .'" />' : ' ' . get_the_author_meta('billing_address_1', get_current_user_id()) ); ?></li>
												<li><span>Apt.,suite,unit,etc.:</span> <?php echo ($_GET['action'] == 'edit' ? '<input type="text" name="billing_address_2" id="billing_address_2" value="'. get_the_author_meta('billing_address_2', get_current_user_id()) .'" />' : ' ' . get_the_author_meta('billing_address_2', get_current_user_id()) ); ?></li>
												<li><span>City:</span> <?php echo ($_GET['action'] == 'edit' ? '<input type="text" name="billing_city" id="billing_city" value="'. get_the_author_meta('billing_city', get_current_user_id()) .'" />' : ' ' . get_the_author_meta('billing_city', get_current_user_id()) ); ?></li>
												<li><span>State:</span> <?php echo ($_GET['action'] == 'edit' ? '<input type="text" name="billing_state" id="billing_state" value="'. get_the_author_meta('billing_state', get_current_user_id()) .'" />' : ' ' . get_the_author_meta('billing_state', get_current_user_id()) ); ?></li>
												<li><span>Zip Code:</span> <?php echo ($_GET['action'] == 'edit' ? '<input type="text" name="billing_postcode" id="billing_postcode" value="'. get_the_author_meta('billing_postcode', get_current_user_id()) .'" />' : ' ' . get_the_author_meta('billing_postcode', get_current_user_id()) ); ?></li>
											</ul>
										</div>
										<div class="col-md-6">
											<p class="text-bold text-center">Shipping Information</p>
											<ul class="list-info list-info-fields">
												<li><span>Business Name:</span> <?php echo ($_GET['action'] == 'edit' ? '<input type="text" name="ship_business_name" id="ship_business_name" value="'. get_the_author_meta('ship_business_name', get_current_user_id()) .'" />' : ' ' . get_the_author_meta('ship_business_name', get_current_user_id()) ); ?></li>
												<li><span>House # & Street Name:</span> <?php echo ($_GET['action'] == 'edit' ? '<input type="text" name="shipping_address_1" id="shipping_address_1" value="'. get_the_author_meta('shipping_address_1', get_current_user_id()) .'" />' : ' ' . get_the_author_meta('shipping_address_1', get_current_user_id()) ); ?></li>
												<li><span>Apt.,suite,unit,etc.:</span> <?php echo ($_GET['action'] == 'edit' ? '<input type="text" name="shipping_address_2" id="shipping_address_2" value="'. get_the_author_meta('shipping_address_2', get_current_user_id()) .'" />' : ' ' . get_the_author_meta('shipping_address_2', get_current_user_id()) ); ?></li>
												<li><span>City:</span> <?php echo ($_GET['action'] == 'edit' ? '<input type="text" name="shipping_city" id="shipping_city" value="'. get_the_author_meta('shipping_city', get_current_user_id()) .'" />' : ' ' . get_the_author_meta('shipping_city', get_current_user_id()) ); ?></li>
												<li><span>State:</span> <?php echo ($_GET['action'] == 'edit' ? '<input type="text" name="shipping_state" id="shipping_state" value="'. get_the_author_meta('shipping_state', get_current_user_id()) .'" />' : ' ' . get_the_author_meta('shipping_state', get_current_user_id()) ); ?></li>
												<li><span>Zip Code:</span> <?php echo ($_GET['action'] == 'edit' ? '<input type="text" name="shipping_postcode" id="shipping_postcode" value="'. get_the_author_meta('shipping_postcode', get_current_user_id()) .'" />' : ' ' . get_the_author_meta('shipping_postcode', get_current_user_id()) ); ?></li>
											</ul>
										</div>
									</div>
									<div class="btn-holder btn-right m-t-lg">
										<?php if($_GET['action'] == 'edit'){ ?>
											<a href="<?php echo get_the_permalink(); ?>" class="btn btn-default">Cancel</a>
											<button type="submit" class="btn btn-default">Save</button>
										<?php }else{ ?>
											<a href="<?php echo get_the_permalink(); ?>/?action=edit" class="btn btn-default">Edit</a>
										<?php } ?>
									</div>
								</form>
							</div>
							<div class="tab-pane fade" id="b">
								<p class="text-bold">Edit Contact Section</p>
							</div>
							<div class="tab-pane fade" id="c">
								<table id="table-purchases" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Time</th>
											<th>Product</th>
											<th>Amount</th>
											<th>Status</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>15 Hours Ago</td>
											<td>Trial</td>
											<td>$1.00</td>
											<td>Paid</td>
											<td class="text-center"><a href="#" class="btn btn-default view-purchase-details">Details</a></td>
										</tr>
										<tr>
											<td>15 Hours Ago</td>
											<td>Basic Package</td>
											<td>$1.00</td>
											<td>Paid</td>
											<td class="text-center"><a href="#" class="btn btn-default view-purchase-details">Details</a></td>
										</tr>
										<tr>
											<td>15 Hours Ago</td>
											<td>Basic Package</td>
											<td>$1.00</td>
											<td>Paid</td>
											<td class="text-center"><a href="#" class="btn btn-default view-purchase-details">Details</a></td>
										</tr>
										<tr>
											<td>15 Hours Ago</td>
											<td>Trial</td>
											<td>$1.00</td>
											<td>Paid</td>
											<td class="text-center"><a href="#" class="btn btn-default view-purchase-details">Details</a></td>
										</tr>
									</tbody>
								</table>
								<div id="view-purchase-details">
									<div class="row">
										<div class="col-md-12">
											<p class="text-bold">Purchase Date</p>
											<ul class="list-info">
												<li><span>Created:</span> 2017-07-16 2:00PM</li>
												
											</ul>
										</div>
										<div class="col-md-12">
											<div class="fx-separator"></div>
										</div>
										<div class="col-md-12">
											<p class="text-bold">Purchase Details</p>
											<ul class="list-info">
												<li><span>Name:</span> Basic Product</li>
												<li><span>Unit Price:</span> $140</li>
											</ul>
										</div>
										<div class="col-md-12">
											<div class="fx-separator"></div>
										</div>
										<div class="col-md-12">
											<p class="text-bold">Comission</p>
											<ul class="list-info">
												<li>You Earned: <strong>$10.00</strong> for this product purchase</li>
											</ul>
										</div>
									</div>
									<a href="#" id="close-purchase-details" class="btn btn-default m-t-md">Back to List of Purchases</a>
								</div>
							</div>
							<div class="tab-pane fade" id="d">
								<p class="text-bold">Memberships Section</p>
							</div>
							<div class="tab-pane fade" id="e">
								<p class="text-bold">Sponsor Section</p>
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
										<tr>
											<td>Page Title Goes Here</td>
											<td>http://urlgoeshere.com?ref=username</td>
											<td>1 Day Ago</td>
										</tr>
										<tr>
											<td>Page Title Goes Here</td>
											<td>http://urlgoeshere.com?ref=username</td>
											<td>2 Days Ago</td>
										</tr>
										<tr>
											<td>Page Title Goes Here</td>
											<td>http://urlgoeshere.com?ref=username</td>
											<td>15 Day Ago</td>
										</tr>
										<tr>
											<td>Page Title Goes Here</td>
											<td>http://urlgoeshere.com?ref=username</td>
											<td>1 Month Ago</td>
										</tr>
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

<div aria-hidden="true" aria-labelledby="modalComposeLabel" role="dialog" tabindex="-1" id="modalCompose" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title">Compose</h4>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal">
					<div class="form-group">
						<label class="col-md-2 control-label">To</label>
						<div class="col-md-10">
							<input type="text" placeholder="" id="inputEmail1" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label">Cc / Bcc</label>
						<div class="col-md-10">
						<input type="text" placeholder="" id="cc" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label">Subject</label>
						<div class="col-md-10">
						<input type="text" placeholder="" id="inputPassword1" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label">Message</label>
						<div class="col-md-10">
						<textarea rows="10" cols="30" class="form-control" id="" name=""></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12 text-right">
							<button class="btn btn-send" type="submit">Send</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
<?php
$product_id = 48; //business package
$product = wc_get_product( $product_id );
get_user_active_referrals();
?>
<?php get_header(); ?>

	<?php get_template_part('inc/templates/nav-marketing'); ?>

	<?php if ( is_user_fx_distributor() || current_user_can('administrator')  ): ?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="fx-header-title">
						<h1>Contacts</h1>
					</div>
					<div class="text-right m-b-md">
						<a href="#" class="btn btn-default"><i class="fa fa-download"></i> Export Contacts</a>
					</div>
					<div class="clearfix"></div>
					<div class="fx-search-contact">
						<div class="panel panel-default">
							<div class="panel-body">
								<form action="" method="GET">
									<div class="input-group">
										<div class="input-group-addon"><i class="fa fa-search"></i></div>
										<input type="text" class="form-control" name="search" placeholder="Search by name or e-mail">
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>

					<ul class="fx-list-contacts">
						<?php  
							$query_offset_multi = 10;
							$query_offset = 0;
							$contacts = array();
							$page_counter = 1;
							$page_num = 1;
							if(isset($_GET['i'])){
								$page_num = $_GET['i'];
								$query_offset = $page_num * $query_offset_multi;
							}

							$user = wp_get_current_user();
							if ( in_array( 'administrator', (array) $user->roles ) ) {
								$referrals = $wpdb->get_results( "SELECT * FROM wp_affiliate_wp_referrals LIMIT 10 OFFSET " . $query_offset );
								$ref_count = $wpdb->get_var("SELECT COUNT(*) FROM wp_affiliate_wp_referrals");
							}else{
								$referrals = $wpdb->get_results( "SELECT * FROM wp_affiliate_wp_referrals WHERE affiliate_id = '". affwp_get_affiliate_id(get_current_user_id()) ."' LIMIT 10 OFFSET " . $query_offset );
								$ref_count = $wpdb->get_var("SELECT COUNT(*) FROM wp_affiliate_wp_referrals WHERE affiliate_id = '" . affwp_get_affiliate_id(get_current_user_id()) . "'" );
							}
							$total_pages = ceil($ref_count / $query_offset_multi);

							foreach($referrals as $referral){
								$order = wc_get_order( $referral->reference );
								$contacts[$ref_count]['id'] = $order->get_user_id();
								$contacts[$ref_count]['username'] = get_the_author_meta('user_login', $order->get_user_id());
								$contacts[$ref_count]['fname'] = get_the_author_meta('first_name', $order->get_user_id());
								$contacts[$ref_count]['lname'] = get_the_author_meta('last_name', $order->get_user_id());
								$contacts[$ref_count]['email'] = get_the_author_meta('email', $order->get_user_id());
								$contacts[$ref_count]['date'] = random_checkout_time_elapsed($order->get_date_paid());
								$contacts[$ref_count]['avatar'] = get_avatar($order->get_user_id());
								$ref_count++;
							}

							foreach($contacts as $contact){
						?>
								<li>
									<div class="media">
										<div class="media-left">
											<?php echo $contact['avatar']; ?>
										</div>
										<div class="media-body">
											<div class="info">
												<h5 class="media-heading text-bold">
													<?php  
														if($contact['fname']){
															echo $contact['fname'] . ' ' . $contact['lname'];
														}else{
															echo $contact['username'];
														}
													?>
												</h5>
												<p><?php echo $contact['email']; ?></p>
											</div>
											<div class="actions">
												<span class="small"><?php echo $contact['date']; ?></span>
												<a href="<?php bloginfo('url');?>/marketing/contacts/user?id=<?php echo $contact['id'] ?>" class="btn btn-default btn-sm m-l-sm">View</a>
											</div>
										</div>
									</div>
								</li>
						<?php 
							} 
						?>
					</ul>
					<form class="contact-pagination" method="GET" action="<?php echo get_the_permalink(); ?>?search=<?php echo $_GET['search'] ?>">
						<ul class="pagination">
							<?php  
								if($total_pages > 0){
									if($total_pages < 5){
										while($page_counter <= $total_pages){
							?>
											<li class="<?php if($_GET['i'] == $page_counter){ echo "active"; } ?>"><a href="<?php echo get_the_permalink(); ?>?i=<?php echo $page_counter; ?><?php if($_GET['search']){ echo "&search=" . $_GET['search']; } ?>"><?php echo $page_counter ?></a></li>
							<?php
											$page_counter++;
										}
									}else{
							?>
										<li class="<?php if($_GET['i'] == 1){ echo "active"; } ?>"><a href="<?php echo get_the_permalink(); ?>?i=1<?php if($_GET['search']){ echo "&search=" . $_GET['search']; } ?>">1</a></li>
										<?php if($page_num < $total_pages && $page_num < ($total_pages - 1)){ ?>
											<li class="<?php if($_GET['i'] == ($page_num + 1)){ echo "active"; } ?>"><a href="<?php echo get_the_permalink(); ?>?i=<?php echo ($page_num + 1); ?><?php if($_GET['search']){ echo "&search=" . $_GET['search']; } ?>"><?php echo ($page_num + 1); ?></a></li>
										<?php } ?>
										<input type="number" name="i" class="form-control" placeholder="page #"></input>
										<?php if($page_num < $total_pages){ ?>
											<li class="<?php if($_GET['i'] == ($total_pages - 1)){ echo "active"; } ?>"><a href="<?php echo get_the_permalink(); ?>?i=<?php echo ($total_pages - 1); ?><?php if($_GET['search']){ echo "&search=" . $_GET['search']; } ?>"><?php echo ($total_pages - 1); ?></a></li>
										<?php } ?>
										<li class="<?php if($_GET['i'] == $total_pages){ echo "active"; } ?>"><a href="<?php echo get_the_permalink(); ?>?i=<?php echo $total_pages; ?><?php if($_GET['search']){ echo "&search=" . $_GET['search']; } ?>"><?php echo $total_pages; ?></a></li>
							<?php
									}
								}
							?>
						</ul>
					</form>
				</div>
			</div>
		</div>
	<?php else: ?>
		<?php get_template_part('inc/templates/no-access'); ?>
	<?php endif; ?>
<?php get_footer(); ?>
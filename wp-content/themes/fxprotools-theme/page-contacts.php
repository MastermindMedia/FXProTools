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
					<div class="row">
						<div class="col-md-8">
							<?php  
								if(isset($_GET['i'])){
									echo '<div><strong>Page #'. $_GET['i'] .'</strong></div>';
								}
								if(isset($_GET['search'])){
									echo '<div><strong>Search results for: '. $_GET['search'] .'</strong></div>';
								}
							?>
						</div>
						<div class="col-md-4">
							<div class="text-right m-b-md">
								<a href="#" class="btn btn-default"><i class="fa fa-download"></i> Export Contacts</a>
							</div>
						</div>
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
							$query_offset = 1;
							$contacts = array();
							$results = array();		
 							$search_results = array();
							$page_counter = 1;
							$page_num = 1;
							$ref_count = 0;
							$ref_count_search = 0;
							if(isset($_GET['i'])){
								$page_num = $_GET['i'];
							}
							$query_offset = $page_num * $query_offset_multi;
							$affiliate_ids = array();

							$user = wp_get_current_user();
							if ( in_array( 'administrator', (array) $user->roles ) ) {
								if(isset($_GET['search'])){
									$search_string = trim($_GET['search']);
									$all_refs = $wpdb->get_results( "SELECT * FROM wp_users WHERE user_login LIKE '%{$search_string}%' OR user_email LIKE '%{$search_string}%' OR user_nicename LIKE '%{$search_string}%' LIMIT 10 OFFSET " . ($query_offset - 10) );
									foreach($all_refs as $affiliate){
										$affiliate_ids[] = $affiliate->ID;
									}
									$ref_count_search = $wpdb->get_var("SELECT COUNT(*) FROM wp_users WHERE user_login LIKE '%{$search_string}%' OR user_email LIKE '%{$search_string}%' OR user_nicename LIKE '%{$search_string}%'");
								}else{
									$all_refs = $wpdb->get_results( "SELECT * FROM wp_users LIMIT 10 OFFSET " . $query_offset );
									foreach($all_refs as $affiliate){
										$affiliate_ids[] = $affiliate->ID;
									}
									$ref_count = $wpdb->get_var("SELECT COUNT(*) FROM wp_users");
								}
							}else{
								if(isset($_GET['search'])){
									$affiliate_id = affwp_get_affiliate_id( get_current_user_id() );
									$referrals = affiliate_wp()->referrals->get_referrals( array(
										'number'       => -1,
										'affiliate_id' => $affiliate_id
									) );
								}else{
									$referrals = $wpdb->get_results( "SELECT * FROM wp_affiliate_wp_referrals WHERE affiliate_id = '". affwp_get_affiliate_id(get_current_user_id()) ."' LIMIT 10 OFFSET " . ($query_offset - 10) );
									$ref_count = $wpdb->get_var("SELECT COUNT(*) FROM wp_affiliate_wp_referrals WHERE affiliate_id = '" . affwp_get_affiliate_id(get_current_user_id()) . "'" );
								}
							}

							if ( in_array( 'administrator', (array) $user->roles ) ){
								$contacts = get_admin_contacts($affiliate_ids);
							}else{
								$contacts = get_user_contacts($referrals);
							}

							if( isset( $_GET['search'] ) && !in_array( 'administrator', (array) $user->roles ) ){		
								foreach ($contacts as $index => $index_item) {		
							       	foreach($index_item as $item){		
							       		if(stripos($item,$_GET['search']) !== false){		
							       			if(!in_array($index, $results,TRUE)){		
							       				array_push($results, $index);
							       				$ref_count_search++;
							       			}		
							       		}		
							       	}		
							    }		
							    foreach($results as $result){		
							    	array_push($search_results,$contacts[$result]);		
							    }		
							    $contacts = $search_results;		
							}
							if( !isset( $_GET['search'] ) ){
								//dd($contacts);
								$total_pages = ceil($ref_count / $query_offset_multi);
								if(!empty($contacts)){
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
									}//contacts loop
								}else{
									echo '<strong>no contacts found.</strong>';
								}
							}//if search not set
							else{
								$total_pages = ceil($ref_count_search / $query_offset_multi);
								$search_counter = 0;
								if(!empty($contacts)){
									foreach($contacts as $contact){
										if(isset($query_offset) && $search_counter <= (($query_offset - 9) + 9) && $search_counter >= ($query_offset - 9) || in_array( 'administrator', (array) $user->roles )){
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
										$search_counter++;
									}// foreach
								}else{
									echo '<strong>no contacts found.</strong>';
								}//if empty
							}
						?>
					</ul>
					<form class="contact-pagination" method="GET" action="<?php echo get_the_permalink(); ?>">
						<ul class="pagination">
							<?php  
								if($total_pages > 0){
									if($total_pages < 5){
										while($page_counter <= $total_pages){
							?>
											<li class="<?php if($page_num == $page_counter){ echo "active"; } ?>"><a href="<?php echo get_the_permalink(); ?>?i=<?php echo $page_counter; ?><?php if(isset($_GET['search'])){ echo "&search=" . $_GET['search']; } ?>"><?php echo $page_counter ?></a></li>
							<?php
											$page_counter++;
										}
									}else{

							?>				
										<?php if($page_num >= 2){ ?>
											<li><a href="<?php echo get_the_permalink(); ?>?i=<?php echo ($page_num - 1) ?><?php if(isset($_GET['search'])){ echo "&search=" . $_GET['search']; } ?>"><</a></li>
										<?php } ?>
										<li class="<?php if($page_num == 1){ echo "active"; } ?>"><a href="<?php echo get_the_permalink(); ?>?i=1<?php if(isset($_GET['search'])){ echo "&search=" . $_GET['search']; } ?>">1</a></li>
										<?php if($page_num < $total_pages && $page_num < ($total_pages - 1)){ ?>
											<li class="<?php if($page_num == ($page_num + 1)){ echo "active"; } ?>"><a href="<?php echo get_the_permalink(); ?>?i=<?php echo ($page_num + 1); ?><?php if(isset($_GET['search'])){ echo "&search=" . $_GET['search']; } ?>"><?php echo ($page_num + 1); ?></a></li>
										<?php } ?>
										<input type="number" name="i" class="form-control" placeholder="page #"></input>
										<?php if(isset($_GET['search'])){ ?>
											<input type="hidden" name="search" value="<?php echo $_GET['search'] ?>">
										<?php } ?>
										<?php if($page_num < $total_pages){ ?>
											<li class="<?php if($page_num == ($total_pages - 1)){ echo "active"; } ?>"><a href="<?php echo get_the_permalink(); ?>?i=<?php echo ($total_pages - 1); ?><?php if(isset($_GET['search'])){ echo "&search=" . $_GET['search']; } ?>"><?php echo ($total_pages - 1); ?></a></li>
										<?php } ?>
										<li class="<?php if($page_num == $total_pages){ echo "active"; } ?>"><a href="<?php echo get_the_permalink(); ?>?i=<?php echo $total_pages; ?><?php if(isset($_GET['search'])){ echo "&search=" . $_GET['search']; } ?>"><?php echo $total_pages; ?></a></li>
										<?php if($page_num < $total_pages){ ?>
											<li><a href="<?php echo get_the_permalink(); ?>?i=<?php echo ($page_num + 1) ?><?php if(isset($_GET['search'])){ echo "&search=" . $_GET['search']; } ?>">></a></li>
										<?php } ?>
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
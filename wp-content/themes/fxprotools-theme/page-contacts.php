<?php get_header(); ?>

	<?php get_template_part('inc/templates/nav-marketing'); ?>

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
						$referrals = get_user_referrals();
						$ref_count = 0;
						$contacts = array();
						$results = array();
						$search_results = array();

						foreach($referrals as $referral){
							$order = wc_get_order( $referral->reference );
							$contacts[$ref_count]['id'] = $order->get_user_id();
							$contacts[$ref_count]['username'] = get_the_author_meta('user_login', $order->get_user_id());
							$contacts[$ref_count]['fname'] = get_the_author_meta('first_name', $order->get_user_id());
							$contacts[$ref_count]['lname'] = get_the_author_meta('last_name', $order->get_user_id());
							$contacts[$ref_count]['email'] = get_the_author_meta('email', $order->get_user_id());
							$contacts[$ref_count]['date'] = time_elapsed_string($order->order_date);
							$contacts[$ref_count]['avatar'] = get_avatar($order->get_user_id());
							$ref_count++;
						}

						if($_GET['search']){
							foreach ($contacts as $index => $index_item) {
						       	foreach($index_item as $item){
						       		if(stripos($item,$_GET['search']) !== false){
						       			if(!in_array($index, $results,TRUE)){
						       				array_push($results, $index);
						       			}
						       		}
						       	}
						    }
						    foreach($results as $result){
						    	array_push($search_results,$contacts[$result]);
						    }
						    $contacts = $search_results;
						}

						$per_page = 1;
						$total_rows = count($contacts);
						$pages = ceil($total_rows / $per_page);
						$current_page = isset($_GET['i']) ? $_GET['i'] : 1;
						$current_page = ($total_rows > 0) ? min($pages, $current_page) : 1;
						$start = $current_page * $per_page - $per_page;
						$slice = array_slice($contacts, $start, $per_page);

						foreach($slice as $k => $v){
					?>

						<li>
							<div class="media">
								<div class="media-left">
									<?php echo $v['avatar']; ?>
								</div>
								<div class="media-body">
									<div class="info">
										<h5 class="media-heading text-bold">
											<?php  
												if($v['fname']){
													echo $v['fname'] . ' ' . $v['lname'];
												}else{
													echo $v['username'];
												}
											?>
										</h5>
										<p><?php echo $v['email']; ?></p>
									</div>
									<div class="actions">
										<span class="small"><?php echo $v['date']; ?></span>
										<a href="<?php bloginfo('url');?>/marketing/contacts/user" class="btn btn-default btn-sm m-l-sm">View</a>
									</div>
								</div>
							</div>
						</li>
				</ul>
				<div class="text-center">
					<ul class="pagination">
						<?php
							}

							if ($pages > 0) {
							    $counter = 1;
							    while($counter <= $pages){
						?>
							    	<li class="<?php if($current_page == $counter){ echo "active"; } ?>"><a href="<?php echo get_the_permalink(); ?>?i=<?php echo $counter; ?><?php if($_GET['search']){ echo "&search=" . $_GET['search']; } ?>"><?php echo $counter ?></a></li>
						<?php
									$counter++;
							    }
							}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
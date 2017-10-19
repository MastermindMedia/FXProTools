<?php get_header(); ?>
<script>
	var EMAIL_TYPE = <?php
	if ($_GET['inbox_type'] == 'sent') {
		echo json_encode('sent');
	} else if ($_GET['inbox_type'] == 'trash') {
		echo json_encode('trash');
	} else {
		echo json_encode('inbox');
	}
	?>;
</script>
<?php
if (current_user_can('administrator')) {
?>
<script>
	var ALL_USERS = <?php
		$users = array();
		
		foreach (get_users() as $user) {
			$users[$user->ID] = $user->display_name;
		}
		
		echo json_encode($users);
		?>;
	
	var ALL_PRODUCTS = <?php
		$products = array();
		
		foreach (get_posts(array('posts_per_page' => -1, 'post_type' => 'product')) as $product) {
			$products[$product->ID] = $product->post_title;
		}
		
		echo json_encode($products);
	?>;
</script>
<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalCompose">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left">Compose New Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form name="compose-email" class="compose-email clearfix" method="post">
			<div class="form-group">
			   <label for="email_recipient_type">Recipient Type</label>
			   <select id="email_recipient_type" name="email_recipient_type" class="form-control">
			      <option value="all">All Users</option>
			      <option value="group">Group</option>
			      <option value="product">Product</option>
			      <option value="individual">Individual</option>
			   </select>
			</div>
			<div class="form-group">
			   <label for="recipient_group">Group Type</label>
			   <select id="recipient_group" name="recipient_group" class="form-control">
			      <option value="customer">Customers</option>
			      <option value="distributor">Distributors</option>
			      <option value="both">Both</option>
			   </select>
			</div>
			<div class="form-group">
			   <label for="recipient_product">Product</label>
			   <div style="width: 100%;">
				   <select id="recipient_product" name="recipient_product" style="width: 100%;">
				   </select>
			   </div>
			</div>
			<div class="form-group">
			   <label for="recipient_individual_type">Individual Type</label>
			   <select id="recipient_individual_type" name="recipient_individual_type" class="form-control">
			      <option value="email">Specified Email</option>
			      <option value="user">User</option>
			   </select>
			</div>
			<div class="form-group">
			   <label for="recipient_individual_name">Individual Name</label>
			   <input id="recipient_individual_name" name="recipient_individual_name" class="form-control" />
			</div>
			<div class="form-group">
			   <label for="recipient_individual_email">Individual Email</label>
			   <input id="recipient_individual_email" name="recipient_individual_email" class="form-control" />
			</div>
			<div class="form-group">
			   <label for="recipient_individual_user">Individual User</label>
			   <div style="width: 100%;">
				   <select id="recipient_individual_user" name="recipient_individual_user" style="width: 100%;">
				   </select>
			   </div>
			</div>
			<div class="form-group">
				<label for="subject">Subject</label>
				<input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
			</div>
			<div class="form-group">
				<label for="lastName">Body</label>
				<textarea type="text" class="form-control" name="body" id="body"></textarea>
			</div>
			<button type="button" class="btn btn-default pull-right">Send</button>
		</form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
<?php
}
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="fx-header-title">
				<h1>Your Contact</h1>
				<p>Check Below for your available contact</p>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">
									<?php
									if (current_user_can('administrator')) {
									?>
									<a href="#modalCompose" data-toggle="modal" title="Compose" class="btn btn-danger block ">Compose Mail</a>
									<?php
									}
									?>
									<ul class="fx-inbox-nav">
										<li <?php if (!isset($_GET['inbox_type']) || $_GET['inbox_type'] == 'inbox') { ?> class="active" <?php } ?>><a href="<?php bloginfo('url'); ?>/my-account/inbox"><i class="fa fa-inbox"></i> Inbox <span class="label label-danger pull-right" id="unreadCount">0</span></a></li>
										<?php
										if (current_user_can('administrator')) {
										?>
										<li <?php if (!isset($_GET['inbox_type']) || $_GET['inbox_type'] == 'sent') { ?> class="active" <?php } ?>><a href="<?php bloginfo('url'); ?>/my-account/inbox?inbox_type=sent"><i class="fa fa-envelope-o"></i> Sent</a></li>
										<?php
										}
										?>
										<li <?php if (!isset($_GET['inbox_type']) || $_GET['inbox_type'] == 'trash') { ?> class="active" <?php } ?>><a href="<?php bloginfo('url'); ?>/my-account/inbox?inbox_type=trash"><i class=" fa fa-trash-o"></i> Trash</a></li>
									</ul>
								</div>
								<div class="col-md-9">
									<div class="row">
										<div class="col-md-3">
											<div class="dropdown">
												<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Actions <i class="fa fa-caret-down"></i></button>
												<ul class="dropdown-menu">
													<li><a href="#">Mark as Read</a></li>
													<li><a href="#">Delete</a></li>
												</ul>
											</div>
										</div>
										<div class="col-md-4 col-md-offset-5">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Search e-mail">
												<div class="input-group-addon"><i class="fa fa-search"></i></div>
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
									<table class="table table-bordered table-hover fx-table-inbox with-padding no-border-l-r m-t-sm">
										<thead>
											<th class="text-center"><input type="checkbox"></th>
											<th class="small" style="width: 75%;">Subject</th>
											<th class="small text-center">Date</th>
										</thead>
										<tbody id="mailContainer">
											<tr>
												<td colspan="3">Loading...</td>
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
</div>

<?php get_footer(); ?>
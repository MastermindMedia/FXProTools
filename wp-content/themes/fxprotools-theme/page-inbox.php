<?php get_header(); ?>
<script>var EMAIL_TYPE = <?php
if ($_GET['inbox_type'] == 'sent') {
	echo json_encode('sent');
} else if ($_GET['inbox_type'] == 'trash') {
	echo json_encode('trash');
} else {
	echo json_encode('inbox');
}
?>;</script>
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
									<a href="<?php echo admin_url('post-new.php?post_type=fx_email'); ?>" title="Compose" class="btn btn-danger block ">Compose Mail</a>
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
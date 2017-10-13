<?php get_header(); ?>

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
									<a href="#modalCompose" data-toggle="modal" title="Compose" class="btn btn-danger block ">Compose Mail</a>
									<ul class="fx-inbox-nav">
										<li class="active"><a href="#"><i class="fa fa-inbox"></i> Inbox <span class="label label-danger pull-right">2</span></a></li>
										<li><a href="#"><i class="fa fa-envelope-o"></i> Sent</a></li>
										<li><a href="#"><i class=" fa fa-trash-o"></i> Trash</a></li>
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
											<th class="small">Subject</th>
											<th class="small">Participants</th>
											<th class="small text-center">Date</th>
										</thead>
										<tbody>
											<tr class="unread">
												<td class="text-center">
													<input type="checkbox">
												</td>
												<td>Subject 1</td>
												<td>Participant 1, Participant 2, Participant 3</td>
												<td class="text-center">9:27 AM</td>
											</tr>
											<tr class="unread">
												<td class="text-center">
													<input type="checkbox">
												</td>
												<td>Subject 2</td>
												<td>Participant 1, Participant 2, Participant 3</td>
												<td class="text-center">9:27 AM</td>
											</tr>
											<tr>
												<td class="text-center">
													<input type="checkbox">
												</td>
												<td>Subject 3</td>
												<td>Participant 1, Participant 2, Participant 3</td>
												<td class="text-center">9:27 AM</td>
											</tr>
											<tr>
												<td class="text-center">
													<input type="checkbox">
												</td>
												<td>Subject 4</td>
												<td>Participant 1, Participant 2, Participant 3</td>
												<td class="text-center">9:27 AM</td>
											</tr>
											<tr>
												<td class="text-center">
													<input type="checkbox">
												</td>
												<td>Subject 5</td>
												<td>Participant 1, Participant 2, Participant 3</td>
												<td class="text-center">9:27 AM</td>
											</tr>
											<tr>
												<td class="text-center">
													<input type="checkbox">
												</td>
												<td>Subject 6</td>
												<td>Participant 1, Participant 2, Participant 3</td>
												<td class="text-center">9:27 AM</td>
											</tr>
											<tr>
												<td class="text-center">
													<input type="checkbox">
												</td>
												<td>Subject 7</td>
												<td>Participant 1, Participant 2, Participant 3</td>
												<td class="text-center">9:27 AM</td>
											</tr>
											<tr>
												<td class="text-center">
													<input type="checkbox">
												</td>
												<td>Subject 8</td>
												<td>Participant 1, Participant 2, Participant 3</td>
												<td class="text-center">9:27 AM</td>
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
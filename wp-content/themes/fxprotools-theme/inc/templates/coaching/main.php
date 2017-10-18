<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="fx-header-title">
					<h1><?php echo $title;?></h1>
					<p><?php echo $sub_heading;?></p>
				</div>
			</div>
			<div class="col-md-12">
			<div class="fx-coaching-tab">
				<a href="<?php bloginfo('url');?>/coaching" class="btn btn-danger no-border-radius pull-right">Schedule Coaching</a>
				<div role="tabpanel">
					<ul class="nav nav-tabs" id="coachingTabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#upcoming" aria-controls="upcoming" role="tab" data-toggle="tab">Upcoming Sessions</a>
						</li>
						<li role="presentation">
							<a href="#past" aria-controls="past" role="tab" data-toggle="tab">Past Sessions</a>
						</li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane padding-md active" id="upcoming">
							<?php $obj_view->view_theme($view_template . 'coaching/upcoming-webinar.php', array()); ?>
						</div>
						<div role="tabpanel" class="tab-pane padding-md" id="past">
							<?php $obj_view->view_theme($view_template . 'coaching/past-webinar.php', array()); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
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
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#one" aria-controls="one" role="tab" data-toggle="tab">Upcoming Sessions</a>
						</li>
						<li role="presentation">
							<a href="#two" aria-controls="two" role="tab" data-toggle="tab">Past Sessions</a>
						</li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane padding-md active" id="one">
							<div class="webinar-list">
							<?php
							$args = array(
								'post_type'  => 'fx_webinar',
								'meta_query' => array(
									'relation' => 'OR',
									array(
										'key'       => 'webinar_start_date',
										'value'     => date('Y-m-d',strtotime("today")),
										'compare'   => '>=',
										'type'      => 'DATE'
									),
									array(
										'key'       => 'webinar_start_date',
										'value'     => 'true',
										'compare'   => '='
									)
								)
							);
							 
							$the_query = new WP_Query( $args );
							 
							if ( $the_query->have_posts() ) {
							while ( $the_query->have_posts() ) {
							$the_query->the_post();
							?>

							<div class="row">
								<div class="col-md-2 col-xs-6 webinar-sched webinar-date">
									<?php echo rwmb_meta('webinar_start_date'); ?>
								</div>
								<div class="col-md-2 col-xs-6 webinar-sched webinar-time">
									<?php echo date('h:i A', strtotime(rwmb_meta('webinar_start_time'))); ?>
								</div>
								<div class="col-md-6">
									<?php echo rwmb_meta('webinar_topic'); ?>
								</div>
								<div class="col-md-2 text-right webinar-link">
									<a class="btn btn-success" href="<?php echo rwmb_meta('webinar_meeting_link'); ?>">Meeting Link</a>
								</div>
							</div>
							 
							<?php
							}
							} else {
								echo '<h4>No Sessions Scheduled</h4>';
							}
							/* Restore original Post Data */
							wp_reset_postdata();

							?>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane padding-md" id="two">
							<div class="webinar-list">
							<?php
							$args = array(
								'post_type'  => 'fx_webinar',
								'meta_query' => array(
									'relation' => 'OR',
									array(
										'key'       => 'webinar_start_date',
										'value'     => date('Y-m-d',strtotime("today")),
										'compare'   => '<',
										'type'      => 'DATE'
									),
									array(
										'key'       => 'webinar_start_date',
										'value'     => 'true',
										'compare'   => '='
									)
								)
							);
							 
							$the_query = new WP_Query( $args );
							 
							if ( $the_query->have_posts() ) {
							while ( $the_query->have_posts() ) {
							$the_query->the_post();
							?>

							<div class="row">
								<div class="col-md-2 col-xs-6 webinar-sched webinar-date">
									<?php echo rwmb_meta('webinar_start_date'); ?>
								</div>
								<div class="col-md-2 col-xs-6 webinar-sched webinar-time">
									<?php echo date('h:i A', strtotime(rwmb_meta('webinar_start_time'))); ?>
								</div>
								<div class="col-md-6">
									<?php echo rwmb_meta('webinar_topic'); ?>
								</div>
								<div class="col-md-2 text-right webinar-link">
									<a class="btn btn-success" href="<?php echo rwmb_meta('webinar_meeting_link'); ?>">Meeting Link</a>
								</div>
							</div>
							 
							<?php
							}
							} else {
								echo '<h4>No Sessions Scheduled</h4>';
							}
							/* Restore original Post Data */
							wp_reset_postdata();

							?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
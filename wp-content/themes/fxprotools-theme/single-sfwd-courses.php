<?php
$course_id = get_the_ID();
$course = get_post( $course_id ); 
$lessons = get_lessons_by_course_id( $course_id );
$course_progress = get_user_progress();
?>

<?php get_header(); ?>

	<?php get_template_part('inc/templates/nav-products'); ?>

	<?php if( !sfwd_lms_has_access_fn($course_id) ): ?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="fx-header-title">
						<h1><?php the_title();?></h1>
						<p><?php echo rwmb_meta('subtitle');?></p>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="fx-video-container"></div>
					<br/>

					<?php if( !sfwd_lms_has_access_fn($course_id) ): ?>
					<div class="learndash_join_button">
						<form method="post">
							<input type="hidden" value="<?php echo $course_id;?>" name="course_id" />
							<input type="hidden" name="course_join" value="<?php echo wp_create_nonce( 'course_join_'. get_current_user_id() .'_'. $course_id  );?>" />
							<input type="submit" value="Start This Course" class="btn btn-success block" style="width:100%;" />
						</form></div>
					<?php endif; ?>


					<br/>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-default fx-course-outline">
						<div class="panel-body">
							<h3>Course Description</h3>
							
							<div class="content">
								<?php echo $course->post_content; ?>
							</div>
							<hr/>
							<h5 class="text-bold">Course Progress</h5>

							<?php get_template_part('inc/templates/course/progressbar'); ?>

							<hr/>
							<h5 class="text-bold">Course Lessons</h5>
							<table class="table table-bordered fx-table-lessons">
								<thead>
									<tr>
										<th style="width: 100px;">Lessons</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
								
								<?php if( $lessons ) : ?>
									<?php $count = 0;  foreach($lessons as $post): setup_postdata($post); $count++; ?>
										<?php $is_complete = get_course_lesson_progress($course_id, get_the_ID());?>
										<tr>
											<td class="text-center number"><?php echo $count; ?></td>
											<td>
												<a href="<?php the_permalink();?>"><?php the_title();?></a>
												<div class="status pull-right">
													<i class="fa <?php echo  $is_complete ?  'fa-check text-success' : '';?>"></i>
												</div>
											</td>
										</tr>
									<?php endforeach; wp_reset_query();?>
								<?php endif;?>

								</tbody>
							</table>
						</div>
					</div>
				</div>	
			</div>
		</div>
	<?php else: ?>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="panel panel-default">
						<div class="panel-body">
							<h5 class="text-bold">Course Progress</h5>
							<?php get_template_part('inc/templates/course/progressbar'); ?>
						</div>
					</div>
					<div class="panel panel-default fx-course-navigation">
						<div class="panel-body">
							<h5 class="text-bold">Course Navigation</h5>

							<?php if( $lessons ) : ?>
								<ul>
								<?php $count = 0;  foreach($lessons as $post): setup_postdata($post); $count++; ?>
									<?php $is_complete = get_course_lesson_progress($course_id, get_the_ID());?>
									<li class="<?php echo  $is_complete ?  'completed' : '';?>"><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
								<?php endforeach;  wp_reset_query(); ?>
								</ul>
							<?php endif;?>
							
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-12">
							<div class="fx-header-title">
								<h1><?php the_title();?></h1>
								<p><?php echo rwmb_meta('subtitle');?></p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="fx-video-container"></div>
							<br/>
						</div>
						<div class="clearfix"></div>
						<div class="col-md-12">
							<div class="panel panel-default fx-course-outline">
								<div class="panel-body">
									<h3>Course Description</h3>
									<div class="content">
										<?php echo $course->post_content; ?>
									</div>
								</div>
							</div>
							<a href="#" class="btn btn-danger block">Upgrade For Access - $197</a>
							<br/>
							<div class="panel panel-default fx-course-outline">
								<div class="panel-body">
									<h5 class="text-bold">Course Lessons</h5>
									<table class="table table-bordered fx-table-lessons">
										<thead>
											<tr>
												<th style="width: 100px;">Lessons</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php if( $lessons ) : ?>
												<?php $count = 0;  foreach($lessons as $post): setup_postdata($post); $count++; ?>
													<?php $is_complete = get_course_lesson_progress($course_id, get_the_ID());?>
													<tr>
														<td class="text-center number"><?php echo $count; ?></td>
														<td>
															<a href="<?php the_permalink();?>"><?php the_title();?></a>
															<div class="status pull-right">
																<i class="fa <?php echo  $is_complete ?  'fa-check text-success' : '';?>"></i>
															</div>
														</td>
													</tr>
												<?php endforeach; wp_reset_query();?>
											<?php endif;?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
	<?php endif; ?>


<?php get_footer(); ?>
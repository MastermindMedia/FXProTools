<?php
$product_id = 48; //business package
$wp_query->query_vars['_prod_id'] = $product_id;
$_product = wc_get_product( $product_id );
$wp_query->query_vars['_prod_data'] = $_product;
$category_slug = 'funnels';
$category = get_term_by('slug', $category_slug, 'ld_course_category' );
$courses = get_courses_by_category_id($category->term_id);
$funnels = get_funnels();
$referral = "/?ref=" . affwp_get_affiliate_id( get_current_user_id() );
?>
<?php get_header(); ?>
	<?php if ( is_user_fx_distributor() || current_user_can('administrator') ): ?>
		<?php get_template_part('inc/templates/nav-marketing'); ?>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="fx-list-courses">
						<?php if( $courses ) : ?>
							<?php $count = 0; foreach($courses as $post): setup_postdata($post); $count++; ?>
								<?php get_template_part('inc/templates/product/list-course'); ?>
							<?php endforeach;?>
							<?php wp_reset_query(); ?>
						<?php endif;?>
					</ul>
					<br/>
					<div class="fx-header-title">
						<h1>Your Sales Funnels</h1>
						<p>Let us do most of the work for you</p>
					</div>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<?php if($funnels): ?>
							<?php $count = 0; foreach($funnels as $post): setup_postdata($post); $count++; $stats = get_funnel_stats( get_the_ID() ); ?>
							<div class="accordion-group panel-default">
								<div class="panel-heading" role="tab" id="heading-<?php echo $count;?>">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $count;?>" aria-expanded="true" aria-controls="collapse-<?php echo $count;?>">
										Funnel #<?php echo $count;?>: <?php the_title();?>
										</a>
									</h4>
								</div>
								<div id="collapse-<?php echo $count;?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="heading-<?php echo $count;?>">
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
												<div class="fx-tabs-vertical marketing-funnels">
													<ul class="nav nav-tabs">
														<li class="active">
															<a href="#a-<?php echo $count;?>" data-toggle="tab">
																<span class="block">Step 1</span>
																<span class="block">Capture</span>
																<small>Lead Gen</small>
															</a>
														</li>
														<li>
															<a href="#b-<?php echo $count;?>" data-toggle="tab">
																<span class="block">Step 2</span>
																<span class="block">Landing</span>
																<small>Information</small>
															</a>
														</li>
													</ul>
													<div class="tab-content">
														<div class="tab-pane tab-profile active" id="a-<?php echo $count;?>">
															<?php 
															$thumbnail = reset(rwmb_meta('capture_page_thumbnail'));
															$title = rwmb_meta('capture_page_title');
															$page_url = rwmb_meta('capture_page_url') . $referral;
															?>
															<div class="row">
																<div class="col-md-9">
																	<div class="row">
																		<div class="col-md-3">
																			<?php $thumbnail = reset(rwmb_meta('capture_page_thumbnail'));?>
																			<img src="<?php echo $thumbnail['url'];?>" class="img-responsive">
																		</div>
																		<div class="col-md-9">
																			<div class="heading">
																				<h3 class="title">Capture Page</h3>
																				<p><?php echo $title;?></p>
																			</div>
																			<ul class="social-media">
																				<li><a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode($page_url);?>" class="btn btn-default block text-center" target="_blank">Facebook</a></li>
																				<li><a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($page_url);?>" class="btn btn-default block text-center" target="_blank">Twitter</a></li>
																				<li><a href="https://www.linkedin.com/shareArticle?url=<?php echo urlencode($page_url);?>" class="btn btn-default block text-center" target="_blank">Linkedin</a></li>
																				<li><a href="https://plus.google.com/share?url=<?php echo urlencode($page_url);?>" class="btn btn-default block text-center" target="_blank">Google+</a></li>
																			</ul>
																			<div class="clearfix"></div>
																		</div>
																		<div class="clearfix"></div>
																		<div class="col-md-12">
																			<hr/>
																			<div class="form-group url-group two">
																				<label>Share This URL:</label>
																				<div class="clearfix"></div>
																				<input type="text" class="form-control" id="cp-url-<?php echo $count;?>" value="<?php echo $page_url;?>">
																				<button class="btn btn-default btn-copy" data-clipboard-target="#cp-url-<?php echo $count;?>">Copy</button>
																				<a href="#" class="btn btn-default">Preview</a>
																				<div class="clearfix"></div>
																			</div>
																			<div class="form-group url-group two">
																				<label>Custom Video Embed:</label>
																				<div class="clearfix"></div>
																				<textarea class="form-control"></textarea>
																				<a href="#" class="btn btn-default">Save</a>
																				<div class="clearfix"></div>
																			</div>
																			<div class="form-group url-group two">
																				<label>Custom Background Image:</label>
																				<input type="text" class="form-control" value="">
																				<a href="#" class="btn btn-default">Upload</a>
																				<a href="#" class="btn btn-default">Preview</a>
																				<div class="clearfix"></div>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-md-3">
																	<div class="panel panel-default">
																		<div class="panel-body">
																			<label>Page Settings</label>
																			<hr class="m-xs"/>
																			<table>
																				<tr>
																					<td>Custom Video</td>
																					<td class="toggle-action">
																						<input class="fx-slide-toggle" id="capture-custom-video-<?php echo $count;?>" type="checkbox">
																						<label class="fx-slide-toggle-btn" for="capture-custom-video-<?php echo $count;?>"></label>
																					</td>
																				</tr>
																				<tr>
																					<td>Background</td>
																					<td class="toggle-action">
																						<input class="fx-slide-toggle" id="capture-custom-bg-<?php echo $count;?>" type="checkbox" type="checkbox">
																						<label class="fx-slide-toggle-btn" for="capture-custom-bg-<?php echo $count;?>"></label>
																					</td>
																				</tr>
																			</table>
																		</div>
																	</div>
																	<br/>
																	<div class="panel panel-default">
																		<div class="panel-body">
																			<label>Page Views</label>
																			<table class="table table-bordered">
																				<tbody>
																					<tr>
																						<td>All</td>
																						<td><?php echo $stats['capture']['page_views']['all'];?></td>
																					</tr>
																					<tr>
																						<td>Uniques</td>
																						<td><?php echo $stats['capture']['page_views']['unique'];?></td>
																					</tr>
																				</tbody>
																			</table>
																			<a href="<?php bloginfo('url');?>/marketing/stats" class="btn btn-default block text-center">View Stats</a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="tab-pane tab-profile" id="b-<?php echo $count;?>">
															<?php 
															$thumbnail = reset(rwmb_meta('landing_page_thumbnail'));
															$title = rwmb_meta('landing_page_title');
															$page_url = rwmb_meta('landing_page_url') . $referral;
															?>
															<div class="row">
																<div class="col-md-9">
																	<div class="row">
																		<div class="col-md-3">
																			
																			<img src="<?php echo $thumbnail['url'];?>" class="img-responsive">
																		</div>
																		<div class="col-md-9">
																			<div class="heading">
																				<h3 class="title">Landing Page</h3>
																				<p><?php echo $title;?></p>
																			</div>
																			<ul class="social-media">
																				<li><a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode($page_url);?>" class="btn btn-default block text-center" target="_blank">Facebook</a></li>
																				<li><a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($page_url);?>" class="btn btn-default block text-center" target="_blank">Twitter</a></li>
																				<li><a href="https://www.linkedin.com/shareArticle?url=<?php echo urlencode($page_url);?>" class="btn btn-default block text-center" target="_blank">Linkedin</a></li>
																				<li><a href="https://plus.google.com/share?url=<?php echo urlencode($page_url);?>" class="btn btn-default block text-center" target="_blank">Google+</a></li>
																			</ul>
																			<div class="clearfix"></div>
																		</div>
																		<div class="clearfix"></div>
																		<div class="col-md-12">
																			<hr/>
																			<div class="form-group url-group two">
																				<label>Share This URL:</label>
																				<div class="clearfix"></div>
																				<input type="text" class="form-control" id="lp-url-<?php echo $count;?>" value="<?php echo $page_url;?>">
																				<button href="#" class="btn btn-default btn-copy" data-clipboard-target="#lp-url-<?php echo $count;?>">Copy</button>
																				<a href="#" class="btn btn-default">Preview</a>
																				<div class="clearfix"></div>
																			</div>
																			<div class="form-group url-group one">
																				<label>Custom Video Embed:</label>
																				<div class="clearfix"></div>
																				<textarea class="form-control"></textarea>
																				<a href="#" class="btn btn-default">Save</a>
																				<div class="clearfix"></div>
																			</div>
																			<div class="form-group url-group two">
																				<label>Custom Background Image:</label>
																				<input type="text" class="form-control" value="">
																				<a href="#" class="btn btn-default">Upload</a>
																				<a href="#" class="btn btn-default">Preview</a>
																				<div class="clearfix"></div>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-md-3">
																	<div class="panel panel-default">
																		<div class="panel-body">
																			<label>Page Settings</label>
																			<hr class="m-xs"/>
																			<table>
																				<tr>
																					<td>Custom Video</td>
																					<td class="toggle-action">
																						<input class="fx-slide-toggle" id="landing-custom-video-<?php echo $count;?>" type="checkbox">
																						<label class="fx-slide-toggle-btn" for="landing-custom-video-<?php echo $count;?>"></label>
																					</td>
																				</tr>
																				<tr>
																					<td>Background</td>
																					<td class="toggle-action">
																						<input class="fx-slide-toggle" id="landing-custom-bg-<?php echo $count;?>" type="checkbox" type="checkbox">
																						<label class="fx-slide-toggle-btn" for="landing-custom-bg-<?php echo $count;?>"></label>
																					</td>
																				</tr>
																			</table>
																		</div>
																	</div>
																	<br/>
																	<div class="panel panel-default">
																		<div class="panel-body">
																			<label>Page Views</label>
																			<table class="table table-bordered">
																				<tbody>
																					<tr>
																						<td>All</td>
																						<td><?php echo $stats['landing']['page_views']['all'];?></td>
																					</tr>
																					<tr>
																						<td>Uniques</td>
																						<td><?php echo $stats['landing']['page_views']['unique'];?></td>
																					</tr>
																				</tbody>
																			</table>
																			<a href="<?php bloginfo('url');?>/marketing/stats" class="btn btn-default block text-center">View Stats</a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php endforeach; ?>
							<?php wp_reset_query(); ?>
						<?php endif;?>
						
						
					</div>
				</div>
			</div>
		</div>
		<script>
		    var clipboard = new Clipboard('.btn-copy');
		</script>
	<?php else: ?>
		<?php get_template_part('inc/templates/no-access'); ?>
	<?php endif; ?>

<?php get_footer(); ?>
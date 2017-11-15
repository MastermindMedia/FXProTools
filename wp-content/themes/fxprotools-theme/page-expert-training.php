<?php
$category_slug = 'advanced-training';
$category = get_term_by('slug', $category_slug, 'ld_course_category' );
$courses = get_courses_by_category_id($category->term_id);
?>


<?php get_header(); ?>
	<?php get_template_part('inc/templates/nav-products'); ?>

	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="fx-header-title">
					<h1><?php the_title();?></h1>
					<p><?php echo rwmb_meta('subtitle');?></p>
				</div>
				<br/>
				<ul class="fx-list-courses">
					<?php if( $courses ) : ?>
						<?php $count = 0; foreach($courses as $post): setup_postdata($post); $count++; ?>
							<?php get_template_part('inc/templates/product/list-course'); ?>
						<?php endforeach;?>
						<?php wp_reset_query(); ?>
					<?php endif;?>
				</ul>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
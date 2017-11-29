<?php get_header(); ?>
	
	<?php if( is_user_logged_in() ) : ?>	
		<?php get_template_part('inc/templates/nav-import-user'); ?>
	<?php endif;?>
	<div class="container">

		<?php if( is_user_logged_in() ) : ?>	
			<div class="heading m-t-n-md text-center">	
				<h1>Almost There! Add Your Billing Information</h1>
	        	<h4><span class="label-red">Step 1:</span> Since this is the first time accessing your account you need to add your billing information...</h4>
	        	<br>
			</div>
			<style>
				.woocommerce-message{display:none!important;}
			</style>
		<?php endif;?>
		

		<?php while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
	</div>
<?php get_footer(); ?>
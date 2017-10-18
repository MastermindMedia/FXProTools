<?php get_header(); ?>

<div class="fx-red-note">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p>CopyProfitShare is the map that teaches you specialized market knowledge!</p>
            </div>
        </div>
    </div>
</div>
<div class="fx-landing log-out-notice">
    <div class="section-w-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel fx-package-item">
                        <div class="panel-body ">
                            <div class="text-center heading">
                                <img class="img-responsive" src="/wp-content/uploads/2017/10/log-out-image.png"/>
                                <h1>You Have Logged Out<br/>Of Your Account</h1>
                                <span class="label-red">Thank you for using our <?= get_bloginfo( 'name' ); ?></span>
                                <p class="m-t-md">Please <a href="<?= wp_login_url(); ?>">click here</a> to login back to our site</p>
                            </div>

                            <div class="quick-message m-t-lg">
								<?php
								if ( have_posts() ) {
									while ( have_posts() ) {
									    the_post();
										the_content();
									}
								}
								?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
<?php get_header(); ?>
<nav class="navbar fx-navbar-sub">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="fx-nav-options">
                    <li class="dashboard">
                        <a class="icon icon-share" href="/dashboard">&nbsp</a>
                    </li>
                    <li class="active">
                        <a href="/dashboard">
                            <span class="number">1</span>
                            <span class="text">User Orientation</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<div class="fx-landing fx-renewal m-t-n-md">
    <div class="section-w-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel fx-package-item">
                        <div class="panel-body ">
                            <div class="text-center heading m-t-n-md">
								<?php
								$name = wp_get_current_user()->user_firstname;
								if ( empty( $name ) ) {
									$name = wp_get_current_user()->display_name;
								}
								?>
                                <h1>Welcome <?= $name; ?></h1>
                                <input type="hidden" id="username" value="<?= $name; ?>"/>
                                <h3>This is your first time signing into <?= get_bloginfo( 'name' ); ?></h3>
                            </div>
                            <div class="text-center heading">
                                <div class="row">
                                    <div class="text-bold m-t-lg">
                                        <span class="label-red">Important:</span> <span>&nbsp;&nbsp;Update Your Password</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="m-t-lg col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                                        <form method="post">
                                            <div class="form-group m-t-sm has-feedback">
                                                <input type="password" class="form-control no-border-radius col-6 text-2x p-xs p-w-md" id="pwd" name="pwd" required placeholder="Enter Your Password..." autocomplete="off">
                                                <span id="pwd-icon" class="glyphicon form-control-feedback text-2x" aria-hidden="true"></span>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <input type="password" class="form-control no-border-radius col-6 text-2x p-xs p-w-md " id="pwd-verify" name="pwd-verify"  required placeholder="Verify Your Password..." autocomplete="off">
                                                <span id="pwd-icon-verify" class="glyphicon form-control-feedback text-2x" aria-hidden="true"></span>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 m-t-lg m-b-lg">
                                                    <button class="btn btn-default btn-lg btn-block p-sm text-2x" type="submit" disabled readonly>Save Password</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="overlay">
                                            <div class="spinner">
                                                <div class="rect1"></div>
                                                <div class="rect2"></div>
                                                <div class="rect3"></div>
                                                <div class="rect4"></div>
                                                <div class="rect5"></div>
                                            </div>
                                        </div>
                                        <div class="ajax-response"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 m-t-lg m-b-lg">
                                    <p>This is your first time signing into <?= get_bloginfo( 'name' ); ?>. Your password was automatically generated for you when your account was created and is not easy to remember.</p>
                                    <p>We recommend you change this to something you will remember. You can always change this in "My Account" section if you need to.</p>
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

<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h1 class="cover-heading">Log Out Notice</h1>
            <p>
                You are attempting to logout of FX Pro Tools.
            </p>
            <p>
                Do you really want to <a href="<?= wp_logout_url(); ?>">logout</a>?
            </p>
        </div>
    </div>
</div>

<?php get_footer(); ?>

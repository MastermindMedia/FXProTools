<?php
/**
 * Afl dashboard
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'eps_afl_before_account_navigation' );
?>

<div class="dashboard-menu-content col-md-6">
</div>



<div class="row">
	<div class="side-menu">
  	<?php echo render_dropdown_menu(eps_get_account_menu_items()); ?> 
	</div>

</div>
<?php do_action( 'eps_afl_after_account_navigation' ); ?>

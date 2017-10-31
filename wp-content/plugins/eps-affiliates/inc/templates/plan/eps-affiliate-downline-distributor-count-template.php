	
<?php
$uid = get_uid();
?>

	<?php if($plan == 'matrix'): ?>
	<div class="row">
	<div class="col">
		<div class="panel panel-default text-center">
		  <div class="panel-heading"><?= __('Distributors'); ?></div>
		  <div class="panel-body"><?= apply_filters('afl_my_downline_distributors_count',$uid); ?></div>
		</div>
	</div>
</div>
<?php elseif($plan == 'unilevel'): ?>
<?php
 $result = apply_filters('afl_my_downline_distributors_count',$uid, $plan); 
 ?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default text-center">
		  <div class="panel-heading"><?= __('Distributors'); ?></div>
		  <div class="panel-body"><?= $result['distributors']; ?></div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default text-center">
		  <div class="panel-heading"><?= __('Customers'); ?></div>
		  <div class="panel-body"><?= $result['customers']; ?></div>
		</div>
	</div>
</div>


<?php endif; ?>
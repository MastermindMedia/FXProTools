<div class="ajax-webinar-lists">
	<?php if( isset($webinars['status']) && $webinars['status'] == 403){ ?>
			<p class="no-webinars"><?php echo $webinars['msg'];?></p>
	<?php }else{ ?>
		<?php foreach($webinars as $k => $v){ ?>
			<p id="<?php echo $v['parse']['key'];?>"><input name="webinars[]" type="checkbox" class="form-check-input" value="<?php echo $v['parse']['key'];?>">
			<?php echo $v['parse']['startTime'];?></p>
		<?php } ?>
		<button class="btn btn-primary webinar-register-now">Register Now</button>
	<?php } ?>
</div>
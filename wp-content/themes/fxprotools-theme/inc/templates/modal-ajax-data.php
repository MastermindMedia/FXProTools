<?php if( isset($webinars['status']) && $webinars['status'] == 403){ ?>
		<p class="no-webinars"><?php echo $webinars['msg'];?></p>
<?php }else{ ?>
	<?php foreach($webinars as $k => $v){ ?>
		<p><input name="webinars[]" type="checkbox" class="form-check-input" value="<?php echo $v['parse']['key'];?>">
		<?php echo $v['parse']['startTime'];?></p>
	<?php } ?>
	<button type="submit" class="btn btn-primary webinar-register-now">Register Now</button>
<?php } ?>
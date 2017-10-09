<?php if( $webinars ){ ?>
	<?php foreach($webinars as $k => $v){ ?>
		<p><input name="webinars[]" type="checkbox" class="form-check-input" value="<?php echo $v['parse']['key'];?>">
		<?php echo $v['parse']['startTime'];?></p>
	<?php } ?>
<?php } ?>
<div>
	<p>Morning</p>
	<ul>
	<?php if(isset($date_range['am']) ){ ?>
			<?php foreach($date_range['am'] as $k => $v){ ?>
					<li><a href="#" class="webinar_time" data-time="<?php echo $v;?>"><?php echo $v;?></a></li>
			<?php } ?>
	<?php } ?>
	</ul>
</div>
<div>
	<p>Afternoon / Evening</p>
	<ul>
	<?php if(isset($date_range['pm']) ){ ?>
			<?php foreach($date_range['pm'] as $k => $v){ ?>
					<li><a href="#" class="webinar_time" data-time="<?php echo $v;?>"><?php echo $v;?></a></li>
			<?php } ?>
	<?php } ?>
	</ul>
</div>
<div>
	<p>Morning</p>
	<ul>
	<?php if(isset($date_range['am']) ){ ?>
			<?php foreach($date_range['am'] as $k => $v){ ?>
					<li><?php echo $v;?></li>
			<?php } ?>
	<?php } ?>
	</ul>
</div>
<div>
	<p>Afternoon</p>
	<ul>
	<?php if(isset($date_range['pm']) ){ ?>
			<?php foreach($date_range['pm'] as $k => $v){ ?>
					<li><?php echo $v;?></li>
			<?php } ?>
	<?php } ?>
	</ul>
</div>
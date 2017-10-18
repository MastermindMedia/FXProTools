<table class="table table-striped">
	<thead>
		<tr>
			<td>Date</td>
			<td>Time</td>
			<td>Title</td>
			<td>Join Link</td>
		</tr>
	</thead>
	<tbody>
		<?php if($webinars){ ?>
				<?php foreach($webinars as $k => $v){ ?>
						<tr>
							<td><?php echo $v['raw']->times[0]->startTime;?></td>
							<td><?php echo $v['raw']->times[0]->startTime;?> - <?php echo $v['raw']->times[0]->endTime;?></td>
							<td><?php echo $v['raw']->subject;?></td>
							<td><?php echo $v['raw']->inSession ? 'Join Meeting':'';?> - <?php echo $v['raw']->registrationUrl;?></td>
						</tr>
				<?php } ?>
		<?php } ?>
	</tbody>
</table>
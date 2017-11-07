<table class="table table-striped">
	<thead>
		<tr>
			<td><?php echo $table_heading_date;?></td>
			<td><?php echo $table_heading_time;?></td>
			<td><?php echo $table_heading_title;?></td>
			<td><?php echo $table_heading_join;?></td>
		</tr>
	</thead>
	<tbody>
		<?php if($webinars){ ?>
				<?php foreach($webinars as $k => $v){ ?>
						<tr>
							<td><?php echo date("D, M j, Y", strtotime($v['data']->times[0]->startTime));?></td>
							<td><?php echo date("g:i A", strtotime($v['data']->times[0]->startTime));?> - <?php echo date("g:i A T", strtotime($v['data']->times[0]->endTime));?></td>
							<td><?php echo $v['data']->subject;?> <span class="label label-info">Order # <?php echo $v['order_id'];?></span></td>
							<td>
								<?php if($v['data']->inSession){ ?>
										<a href="<?php echo $v['data']->registrationUrl;?>"><?php echo $insession_join_meeting;?> </a>
								<?php }else{ ?>
										<a href="<?php echo $v['data']->registrationUrl;?>"><?php echo $register_join_meeting;?> </a>
								<?php } ?>
							</td>
						</tr>
				<?php } ?>
		<?php } ?>
	</tbody>
</table>
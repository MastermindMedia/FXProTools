<div class="table-responsive">


<?php echo do_shortcode('[afl_eps_matrix_genealogy_tree]'); ?>


	<table id="table-matrix-section" class="table table-bordered">
		<thead>
			<tr>
				<th>Page Name</th>
				<th>Page Url</th>
				<th>Time</th>
			</tr>
		</thead>
		<tbody>
							<tr>
								<td>Title</td>
								<td>Link</td>
								<td>Time</td>
							</tr>




						<?php $counter++;
						}
						$prev_url = $act_data['link'];
					}else{
						break;
					}
				}
			}
			?>
		</tbody>
	</table>
</div>

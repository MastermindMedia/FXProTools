<?php
function email_content() {
	global $emails;
	
	// Filter emails.
	if (isset($_POST['search'])) {
		$emails = array_filter($emails, function ($val) {
			$search = $_POST['search'];
			
			return strpos(strtolower($val->post_title), strtolower($search)) !== FALSE;
		});
	}
	
	?>
	<table class="table table-bordered table-hover fx-table-inbox with-padding no-border-l-r m-t-sm">
		<thead>
			<th class="text-center"><input type="checkbox" id="selectAll"></th>
			<th class="small" style="width: 75%;">Subject</th>
			<th class="small text-center">Date</th>
		</thead>
		<tbody id="mailContainer">
			<?php
			if (count($emails) > 0) {
				foreach ($emails as $email) {
			?>
			<tr>
				<td class="text-center"><input type="checkbox" class="email-select" data-id="<?php echo $email->ID; ?>" /></td>
				<td><a href="<?php bloginfo('url'); ?>/my-account/inbox/read/?id=<?php echo $email->ID; ?>"><?php echo $email->post_title; ?></a></td>
				<td class="text-center"><?php echo date_i18n( 'm/d/Y', strtotime($email->post_date) ); ?></td>
			</tr>
			<?php }
			} else { ?>
			<tr>
				<td colspan="3">No emails found.</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
	<?php
}

include('email.php');
?>
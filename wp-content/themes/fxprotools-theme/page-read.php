<?php
function email_content() {
	$email = get_post($_GET['id']);
	
	if (!get_post_meta($email->ID, '_user_' . get_current_user_id() . '_state')) {
		die();
	}
	
	$sendgrid = new FX_Sendgrid_Api();
	$stats = array();
	
	if (get_post_meta($email->ID, '_user_' . get_current_user_id() . '_state') == 'unread') {
		update_post_meta($email->ID, '_user_' . get_current_user_id() . '_state', 'read');
	}
	
	if (current_user_can('administrator')) {
		$statsResponse = json_decode($sendgrid->get_stats_for_category('wpemail-id-' . $email->ID, date('Y-m-d', strtotime($email->post_date_gmt))), true);
		
		foreach ($statsResponse as $statResponse) {
			foreach ($statResponse['stats'] as $stat) {
				foreach ($stat['metrics'] as $key => $value) {
					if (!isset($stats[$key])) {
						$stats[$key] = 0;
					}
					
					$stats[$key] += $value;
				}
			}
		}
	}
	?>
	<h4><?php echo $email->post_title; ?></h3>
	<hr />
	<?php echo get_post_meta( $email->ID, 'email_content' )[0]; ?>
	<?php
	if (current_user_can('administrator')) {
	?>
		<div style="height: 20px;"></div>
		<div class="container-fluid stats">
			<div class="col-md-4">
				<div class="clearfix">
					<label>Sent</label><br />
					<h3><?php echo number_format($stats['delivered'], 0); ?></h3>
				</div>
			</div>
			<div class="col-md-4">
				<div class="clearfix">
					<label>Opened</label><br />
					<h3><?php echo number_format($stats['opens'], 0); ?></h3>
				</div>
			</div>
			<div class="col-md-4">
				<div class="clearfix">
					<label>Clicked</label><br />
					<h3><?php echo number_format($stats['clicks'], 0); ?></h3>
				</div>
			</div>
			<div class="col-md-4">
				<div class="clearfix">
					<label>Bounced</label><br />
					<h3><?php echo number_format($stats['bounces'], 0); ?></h3>
				</div>
			</div>
			<div class="col-md-4">
				<div class="clearfix">
					<label>Unsubscribed</label><br />
					<h3><?php echo number_format($stats['unsubscribes'], 0); ?></h3>
				</div>
			</div>
			<div class="col-md-4">
				<div class="clearfix">
					<label>Complaints</label><br />
					<h3><?php echo number_format($stats['spam_reports'], 0); ?></h3>
				</div>
			</div>
		</div>
	<?php
	}
}

include(__DIR__ . '/inc/templates/email.php');
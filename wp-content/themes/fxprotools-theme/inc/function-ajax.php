<?php
/**
 * -----------------------
 * Fxprotools - AJAX Calls
 * -----------------------
 * All hooks for ajax calls
 */

add_action("wp_ajax_check_username", "check_username");
add_action("wp_ajax_nopriv_check_username", "check_username");
function check_username()
{
	$new_username = $_REQUEST['new_username'];
	if (validate_username($new_username) && !username_exists($new_username))
	{
		echo "1";
	}
	else{
		echo "0";
	}

	wp_die();
}

add_action("wp_ajax_email_inbox", "email_inbox");
add_action("wp_ajax_email_inbox_count", "email_inbox_count");
add_action("wp_ajax_email_trash", "email_trash");
add_action("wp_ajax_email_read", "email_read");
add_action("wp_ajax_email_delete", "email_delete");
add_action("wp_ajax_email_sent", "email_sent");

function email_from_status($status)
{
	$response = get_emails_for_user($status);
	header("Content-Type: application/json");
	$mails = array();
	
	foreach ($response as $mail) {
		$mails[] = array(
			'id' => $mail->ID,
			'status' => get_post_meta($mail->ID, '_user_' . get_current_user_id() . '_state')[0],
			'content' => get_post_meta($mail->ID, 'email_content')[0],
			'modified' => date('c', strtotime($mail->post_modified_gmt)),
			'subject' => $mail->post_title
		);
	}
	
	echo json_encode($mails);
	
	wp_die();
}

function email_inbox()
{
	email_from_status(array('unread', 'read'));
}

function email_inbox_count()
{
	header("Content-Type: application/json");
	echo count(get_emails_for_user($status));
	wp_die();
}

function email_trash()
{
	email_from_status(array('trashed'));
}

function email_read()
{
	update_post_meta($_POST['id'], '_user_' . get_current_user_id() . '_state', 'read');
}

function email_delete()
{
	update_post_meta($_POST['id'], '_user_' . get_current_user_id() . '_state', 'trashed');
}

function email_sent()
{
	$response = get_posts(array(
		'posts_per_page'	=> -1,
		'orderby'			=> 'modified',
		'order'				=> 'DESC',
		'post_type'			=> 'fx_email',
		'post_status'		=> 'publish'
	));
	
	header("Content-Type: application/json");
	$mails = array();
	
	foreach ($response as $mail) {
		$mails[] = array(
			'id' => $mail->ID,
			'status' => get_post_meta($mail->ID, '_user_' . get_current_user_id() . '_state')[0],
			'content' => get_post_meta($mail->ID, 'email_content')[0],
			'modified' => $mail->post_modified_gmt . ' GMT+0',
			'subject' => $mail->post_title
		);
	}
	
	echo json_encode($mails);
	
	wp_die();
}
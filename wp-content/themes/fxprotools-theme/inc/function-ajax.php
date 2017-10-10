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

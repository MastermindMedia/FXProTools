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


add_action('wp_ajax_nopriv_lms_lesson_complete', 'lms_lesson_complete');
add_action('wp_ajax_lms_lesson_complete', 'lms_lesson_complete');
function lms_lesson_complete()
{
	$user_id = get_current_user_id();
	$lesson_id = isset( $_POST['lesson_id'] ) ? $_POST['lesson_id'] : 0;

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) { 
		echo learndash_is_lesson_complete( $user_id , $lesson_id );
	}
	wp_die();
}

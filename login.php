<?php  
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
echo $_SESSION['sec_password'];
if($_SESSION['sec_password'] == "^%fxpro%$#@56&"){
	$user_id = $_SESSION["sec_user_id"];
	wp_set_current_user($user_id);
	wp_set_auth_cookie($user_id);
	unset($_SESSION["sec_password"]);
	unset($_SESSION["sec_user_id"]);
	wp_redirect( home_url() . "/my-account" );
	exit;
}else{
	wp_redirect( home_url() );;
}
?>
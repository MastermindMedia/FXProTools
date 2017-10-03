<?php include_once( "../../../../../wp-load.php" ); ?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="<?php echo WP_SMS_PRO_DIR_PLUGIN; ?>assets/css/default.css" type='text/css'
          media='all'/>
    <link rel="stylesheet" href="<?php echo WP_SMS_PRO_DIR_PLUGIN; ?>assets/css/login.css" type='text/css' media='all'/>
	<?php if ( is_rtl() ) { ?>
        <link rel="stylesheet" href="<?php echo WP_SMS_PRO_DIR_PLUGIN; ?>assets/css/rtl.css" type='text/css'
              media='all'/>
	<?php } ?>
    <title><?php _e( 'Login with mobile', 'wp-sms-pro' ); ?></title>
    <script type="text/javascript">
        function refreshParent() {
            window.opener.location.assign("<?php echo admin_url(); ?>");
            window.close();
        }
    </script>

</head>
<body>
<div class="container">
    <div id="wps-login-sms">
		<?php
		if ( session_status() == PHP_SESSION_NONE ) {
			session_start();
		}

		$success      = '';
		$error        = '';
		$first_form   = true;
		$secound_form = false;

		if ( ! empty( $_POST['submit-username'] ) ) {
			$user = get_user_by( 'slug', $_POST['username'] );
			if ( $user ) {

				$user_meta = get_user_meta( $user->ID );
				if ( $user_meta['mobile'][0] ) {

					$first_form            = false;
					$secound_form          = true;
					$_SESSION['user_code'] = rand( 1, 999999 );
					$_SESSION['user_id']   = $user->ID;

					// Send SMS
					global $sms;
					$sms->to  = array( $user_meta['mobile'][0] );
					$sms->msg = $_SESSION['user_code'];
					$sms->SendSMS();

					$success = __( 'Security code have beed send in your mobile. please enter the code for login to wordpress.', 'wp-sms-pro' );

				} else {
					$error = __( 'Mobile number not found!', 'wp-sms-pro' );
				}

			} else {
				$error = __( 'User does not exist', 'wp-sms-pro' );
			}
		}

		if ( ! empty( $_POST['submit-code'] ) ) {
			if ( $_POST['code'] == $_SESSION['user_code'] ) {

				session_destroy();
				wp_set_auth_cookie( $_SESSION['user_id'] );
				echo '<script type="text/javascript">refreshParent();</script>';

			} else {

				$first_form   = false;
				$secound_form = true;
				$error        = __( 'Security code is wrong', 'wp-sms-pro' );

			}
		}
		?>

		<?php if ( $success ) {
			echo '<div class="alert-box success">' . $success . '</div>';
		} ?>
		<?php if ( $error ) {
			echo '<div class="alert-box error"><span>' . __( 'Error', 'wp-sms-pro' ) . ' </span>' . $error . '</div>';
		} ?>

		<?php if ( $first_form ) { ?>
            <form method="post" action="">
                <p><?php _e( 'Username', 'wp-sms-pro' ); ?>:</p>
                <input type="text" name="username" class="input" placeholder="<?php _e( 'Username', 'wp-sms-pro' ); ?>"/>
                <input type="submit" name="submit-username" class="button"
                       value="<?php _e( 'Submit', 'wp-sms-pro' ); ?>"/>
            </form>
		<?php } ?>

		<?php if ( $secound_form ) { ?>
            <form method="post" action="">
                <input type="text" name="code" class="input" placeholder="<?php _e( 'Code', 'wp-sms-pro' ); ?>"/>
                <input type="submit" name="submit-code" class="button"
                       value="<?php _e( 'Submit code', 'wp-sms-pro' ); ?>"/>
            </form>
		<?php } ?>

        <div id="powerby"><?php echo sprintf( 'Powerby: <a href="%s" target="_blank">WP-SMS Pro pack</a>', WP_SMS_SITE ); ?></div>
    </div>
</div>
</body>
</html>
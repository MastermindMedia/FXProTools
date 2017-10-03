<h3><?php _e( 'Verify status', 'wp-sms-pro' ); ?></h3>
<table class="form-table">
    <tr>
        <th>
            <label for="company"><?php _e( 'Verified', 'wp-sms-pro' ); ?></label>
        </th>
        <td>
            <label for="wpsms-verified">
                <input name="wpsms_verified" type="checkbox" id="wpsms-verified"
                       value="1" <?php checked( $verify, '1' ); ?>>
				<?php _e( 'Yes', 'wp-sms-pro' ); ?>
            </label>
        </td>
    </tr>
</table>
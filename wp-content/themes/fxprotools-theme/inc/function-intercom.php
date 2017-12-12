<?php

/**
 * @param $user
 *
 * @return false|null|string
 */
function get_user_intercom_HMAC($user) {
	if ($user) {
		return hash_hmac(
			'sha256', // hash function
			$user->ID, // user's id
			'dummy_secret_key'
		);
	}
	return null;
}

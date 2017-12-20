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
			$user->user_email,
			'l_-sHsUYbgK3VTBs9AoKgG7kBc1fMAT7fnEgIt1A'
		);
	}
	return null;
}

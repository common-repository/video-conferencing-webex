<?php

namespace Codemanas\Webex\Core\Helpers;

class Helper {

	/**
	 * Check if current user has admin priviledges
	 * @return bool
	 */
	public static function checkAdminPriviledge(): bool {
		return current_user_can( 'manage_options' );
	}
}
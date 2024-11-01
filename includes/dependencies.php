<?php

if ( ! function_exists( '_is_vcw_installed' ) ) {

	function _is_vcw_installed() {
		$file_path = 'video-conferencing-webex/video-conferencing-webex.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}
}
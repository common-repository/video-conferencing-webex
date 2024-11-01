<?php

namespace Codemanas\Webex\Core\Helpers;

/**
 * Class TemplateRouter
 *
 * @package Codemanas\Webex\Core\Helpers
 * @since 1.0
 * @author Deepen
 */
class TemplateRouter {

	private static $_template_folder = VCW_SLUG;

	private static $_template_dir = VCW_DIR_PATH . 'templates/';

	public static function get_template( $file = '', $load = false, array $args = [], bool $require_once = false ) {
		$locate_template    = locate_template( self::$_template_folder . '/' . $file );
		$template_file_name = apply_filters( 'vcw_get_template', $locate_template, $file, $args );

		if ( $load ) {
			return $template_file_name ? $template_file_name : self::$_template_dir . $file;
		}

		if ( $template_file_name ) {
			load_template( $template_file_name, $require_once, $args );
		} else {
			$file_path = self::$_template_dir . $file;
			if ( file_exists( $file_path ) ) {
				load_template( $file_path, $require_once, $args );
			}
		}
	}

	/**
	 * Include or require file
	 *
	 * Calling this method does not pass down the variables down to the document
	 *
	 * @param $_template_file_path
	 * @param bool $require_once
	 */
	public static function include_file( $_template_file_path, $require_once = false ) {
		if ( $require_once ) {
			require_once $_template_file_path;
		} else {
			require $_template_file_path;
		}
	}

}
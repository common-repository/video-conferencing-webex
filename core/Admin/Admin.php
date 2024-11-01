<?php

namespace Codemanas\Webex\Core\Admin;

use Codemanas\Webex\Core\Admin\Events\EventDetails;
use Codemanas\Webex\Core\Admin\Importer\Importer;
use Codemanas\Webex\Core\Admin\Menu\Menu;
use Codemanas\Webex\Core\Admin\Recordings\Recordings;
use Codemanas\Webex\Core\Admin\Settings\Settings;

/**
 * Class Admin
 * @package Codemanas\Webex\Core\Admin
 *
 * @since 1.0.0
 * @author Codemanas (Deepen)
 */
class Admin {

	/**
	 * PostType constructor.
	 */
	public function __construct() {
		$this->init();
	}

	public function init() {
//		Users::get_instance();
		Recordings::get_instance();
		EventDetails::get_instance();
		Menu::get_instance();
		Importer::get_instance();
		Settings::get_instance();
	}

	private static $_instance = null;

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

}
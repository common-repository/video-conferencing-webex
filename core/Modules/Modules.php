<?php

namespace Codemanas\Webex\Core\Modules;

use Codemanas\Webex\Core\Modules\Events\Ajax;
use Codemanas\Webex\Core\Modules\Events\Events;

class Modules {

	public function __construct() {
		$this->init();
	}

	public function init() {
		//Events
		Events::get_instance();
		Ajax::get_instance();
	}

	private static $_instance = null;

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

}
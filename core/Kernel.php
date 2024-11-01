<?php

namespace Codemanas\Webex\Core;

use Codemanas\Webex\Core\Admin\Admin;
use Codemanas\Webex\Core\Admin\Events\PostType;
use Codemanas\Webex\Core\Helpers\TemplateRouter;
use Codemanas\Webex\Core\Modules\Modules;
use Codemanas\Webex\Core\Shortcodes\Shortcodes;

/**
 * Class Kernel
 *
 * @package Codemanas\Webex\Core
 * @since 1.0.0
 * @author Codemanas (Deepen)
 */
class Kernel {

	/**
	 * Kernel constructor.
	 */
	public function __construct() {
		$this->bootstrappers();

		if ( is_admin() ) {
			$this->backend_bootstrappers();
		}

		$this->includes();
	}

	/**
	 * Bootstrap frontend classes
	 *
	 * @since 1.0.0
	 * @author Codemanas (Deepen)
	 */
	protected function bootstrappers() {
		Plugin::get_instance();
		Modules::get_instance();
		PostType::get_instance();
		Shortcodes::get_instance();
	}

	/**
	 * Bootstrap backend classes
	 *
	 * @since 1.0.0
	 * @author Codemanas (Deepen)
	 */
	protected function backend_bootstrappers() {
		Admin::get_instance();
	}

	/**
	 * Trigger when the plugin is activated
	 */
	public static function activate() {
		//Register the post type first
		PostType::get_instance()->register_custom_post_type();

		//Flush Permalinks
		flush_rewrite_rules();
	}

	/**
	 * Trigger when the plugin is deactivated
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

	/**
	 * Helper function files
	 *
	 * @since 1.0.0
	 * @author Codemanas (Deepen)
	 */
	protected function includes() {
		TemplateRouter::include_file( VCW_DIR_INCLUDES . 'functions.php' );
		TemplateRouter::include_file( VCW_DIR_INCLUDES . 'hooks.php' );
		TemplateRouter::include_file( VCW_DIR_INCLUDES . 'template-functions.php' );
	}

	/**
	 * Instance property
	 *
	 * @since 1.0.0
	 * @author Codemanas (Deepen)
	 *
	 * @var null
	 */
	private static $_instance = null;

	/**
	 * Create only one instance so that it may not Repeat
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}

Kernel::get_instance();

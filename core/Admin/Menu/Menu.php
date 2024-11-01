<?php

namespace Codemanas\Webex\Core\Admin\Menu;

use Codemanas\Webex\Core\Admin\Importer\Importer;
use Codemanas\Webex\Core\Admin\Recordings\Recordings;
use Codemanas\Webex\Core\Admin\Settings\Settings;
use Codemanas\Webex\Core\Data\Config;
use Codemanas\Webex\Core\Helpers\Constants;

/**
 * Class Base
 * @package Codemanas\Webex\Core\Admin\Menu
 * @since 1.0.0
 * @author Deepen
 */
class Menu {

	public $config;

	/**
	 * PostType constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_menu' ] );

		$this->config = Config::get_instance();
	}

	public function register_menu() {
		global $submenu;

		if ( ! empty( $this->config->accessTokenData ) && ! empty( $this->config->accessTokenData->access_token ) && ! empty( $this->config->currentUserInfo ) ) {
			/*add_submenu_page(
				'edit.php?post_type=' . Constants::POST_TYPE,
				__( 'Webex Users', 'video-conferencing-webex' ),
				__( 'Users', 'video-conferencing-webex' ),
				'manage_options',
				Constants::POST_TYPE . '-users',
				[ Users::get_instance(), 'render' ]
			);*/

			add_submenu_page(
				'edit.php?post_type=' . Constants::POST_TYPE,
				__( 'Recordings', 'video-conferencing-webex' ),
				__( 'Recordings', 'video-conferencing-webex' ),
				apply_filters( 'vcw_adminMenuPriviledges', 'edit_published_posts' ),
				Constants::POST_TYPE . '-recordings',
				[ Recordings::get_instance(), 'render' ]
			);

			add_submenu_page(
				'edit.php?post_type=' . Constants::POST_TYPE,
				__( 'Import', 'video-conferencing-webex' ),
				__( 'Import', 'video-conferencing-webex' ),
				apply_filters( 'vcw_adminMenuPriviledges', 'edit_published_posts' ),
				Constants::POST_TYPE . '-importer',
				[ Importer::get_instance(), 'render' ]
			);
		} else {
			unset( $submenu['edit.php?post_type=webex-events'][5] );
			unset( $submenu['edit.php?post_type=webex-events'][10] );
			unset( $submenu['edit.php?post_type=webex-events'][15] );
		}

		add_submenu_page(
			'edit.php?post_type=' . Constants::POST_TYPE,
			__( 'Webex Configurations', 'video-conferencing-webex' ),
			__( 'Settings', 'video-conferencing-webex' ),
			apply_filters( 'vcw_adminMenuPriviledges', 'edit_published_posts' ),
			Constants::POST_TYPE . '-settings',
			[ Settings::get_instance(), 'render_settings' ]
		);
	}

	private static $_instance = null;

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

}
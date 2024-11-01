<?php

namespace Codemanas\Webex\Core\Data;

use Codemanas\Webex\Core\Helpers\Fields;

/**
 * Contains global options set
 *
 * @package Codemanas\Webex\Core\Data
 */
class Config {

	public $useMasterAccount;
	public $accessTokenData;
	public $currentUserInfo;
	public $currentWpUser;

	public function __construct() {
		add_action( 'init', [ $this, 'setParams' ] );
	}

	/**
	 * Set the parameters to be accessible
	 *
	 * @since 1.0.0
	 * @author Codemanas (Deepen)
	 */
	public function setParams() {
		$this->currentWpUser    = get_current_user_id();
		$this->useMasterAccount = ! empty( Fields::get_option( 'settings' ) ) && ! empty( Fields::get_option( 'settings' )['useMasterAccount'] ) ? true : false;
		if ( $this->useMasterAccount ) {
			$this->accessTokenData = Fields::get_option( 'connected_access_token' );
			$this->currentUserInfo = Fields::get_option( 'currentUserInfo' );
		} else {
			$this->accessTokenData = Fields::get_user_meta( $this->currentWpUser, 'connected_access_token' );
			$this->currentUserInfo = Fields::get_user_meta( $this->currentWpUser, 'currentUserInfo' );
		}
	}

	private static $_instance = null;

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}
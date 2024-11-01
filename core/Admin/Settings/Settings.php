<?php

namespace Codemanas\Webex\Core\Admin\Settings;

use Codemanas\Webex\Core\Api\Client;
use Codemanas\Webex\Core\Helpers\Constants;
use Codemanas\Webex\Core\Helpers\Fields;
use Codemanas\Webex\Core\Helpers\Helper;
use Codemanas\Webex\Core\Helpers\Logger;
use Codemanas\Webex\Core\Helpers\TemplateRouter;

/**
 * Class Settings
 *
 * @package Codemanas\Webex\Core\Admin\Settings
 *
 * @since 1.0.0
 * @author Deepen
 */
class Settings {

	public static $message = '';

	public $api;

	public function __construct() {
		add_action( 'admin_init', [ $this, 'requestOrRevokeToken' ] );
		add_action( 'wp_ajax_vcw_save_connection_settings', [ $this, 'saveConnectionSettings' ] );
	}

	/**
	 * Save Connection fields
	 */
	public function saveConnectionSettings() {
		$nonce = wp_unslash( filter_input( INPUT_POST, 'verify_vcw_connect_nonce' ) );
		if ( ! current_user_can( 'edit_published_posts' ) ) {
			wp_send_json_error( __( "Permission access denied!", "video-conferencing-webex" ) );
		} elseif ( ! wp_verify_nonce( $nonce, 'verify_vcw_connect' ) ) {
			wp_send_json_error( __( "Invalid nonce!", "video-conferencing-webex" ) );
		}

		$useAsMasterAccount      = filter_input( INPUT_POST, 'useAsMasterAccount' );
		$useManualAuthentication = filter_input( INPUT_POST, 'useManualAuthentication' );
		$client_id               = sanitize_text_field( filter_input( INPUT_POST, 'client_id' ) );
		$client_secret           = sanitize_text_field( filter_input( INPUT_POST, 'client_secret' ) );
		$settings                = [
			'useMasterAccount'        => $useAsMasterAccount,
			'useManualAuthentication' => $useManualAuthentication
		];

		Fields::set_option( 'settings', $settings );

		if ( ! empty( $useManualAuthentication ) ) {
			$api_keys = [
				'client_id'     => $client_id,
				'client_secret' => $client_secret
			];

			if ( ! empty( $useAsMasterAccount ) ) {
				Fields::set_option( 'api_keys', $api_keys );
			} else {
				Fields::set_user_meta( get_current_user_id(), 'api_keys', $api_keys );
			}

			if ( ! empty( $client_id ) && ! empty( $client_secret ) ) {
				wp_send_json_success( $this->api->getAuthenticationUri( $client_id ) );
			} else {
				wp_send_json_error( __( 'Client ID or Client Secret cannot be empty.', 'video-conferencing-webex' ) );
			}
		} else {
			//Re-Intialize the class for changing the API key values.
			$this->api = new Client();
			wp_send_json_success( $this->api->getAuthenticationUri() );
		}

		wp_die();
	}

	/**
	 * Request or revoke access token
	 *
	 * @since 1.0.0
	 * @added_by Deepen
	 */
	public function requestOrRevokeToken() {
		$this->api = new Client();

		global $pagenow;

		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		if ( $pagenow == 'edit.php' && filter_input( INPUT_GET, 'post_type' ) == Constants::POST_TYPE && filter_input( INPUT_GET, 'page' ) == 'webex-events-settings' ) {
			//Get Access tokens
			$this->api->getAccessToken();
			$this->api->revokeAccessToken();
		}

		$this->save();
	}

	/**
	 * Save the connect form submission
	 *
	 * @since 1.0.0
	 * @added_by Deepen
	 */
	public function save() {
		if ( isset( $_POST['save_vcw_general'] ) ) {
			$this->save_general_settings();
		}
	}

	/**
	 * Saving general settings
	 *
	 * @since 1.0.0
	 * @added_by Deepen
	 */
	public function save_general_settings() {
		$nonce = filter_input( INPUT_POST, 'verify_vcw_general_nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		} elseif ( ! wp_verify_nonce( $nonce, 'verify_vcw_general' ) ) {
			return;
		}

		$keepWebexMeetings = filter_input( INPUT_POST, 'keepWebexMeetings' );

		$settings = [
			'keepWebexMeetings' => $keepWebexMeetings
		];
		Fields::set_option( 'general_settings', $settings );

		self::set_message( 'updated', __( 'Settings updated !', 'video-conferencing-webex' ) );
	}

	/**
	 * Show tabs in the settings page
	 *
	 * @param string $current
	 *
	 * @since 1.0.0
	 * @added_by Deepen
	 */
	public function tabs( $current = 'connect' ) {
		if ( ! Helper::checkAdminPriviledge() ) {
			$tabs = array(
				'connect' => __( 'Connect', 'video-conferencing-webex' ),
			);
		} else {
			$tabs = array(
				'connect'    => __( 'Connect', 'video-conferencing-webex' ),
				'general'    => __( 'General', 'video-conferencing-webex' ),
				'logs'       => __( 'Logs', 'video-conferencing-webex' ),
				'extensions' => __( 'Extensions', 'video-conferencing-webex' )
			);
		}

		$tabs = apply_filters( 'vcw_settingsTabsData', $tabs );

		echo '<div id="icon-themes" class="icon32"><br></div>';
		echo '<h2 class="nav-tab-wrapper">';
		foreach ( $tabs as $tab => $name ) {
			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
			?>
            <a class="nav-tab<?php echo $class; ?>"
               href="<?php echo admin_url( "edit.php?post_type=webex-events&page=webex-events-settings&tab=" . $tab ); ?>"><?php echo $name; ?></a>
			<?php
		}
		echo '</h2>';
	}

	/**
	 * Render all the settings wrapper elements like tabs and sorts
	 *
	 * @since 1.0.0
	 * @added_by Deepen
	 */
	public function render_settings() {
		unset( $GLOBALS['vcw'] );

		$settings           = new \stdClass();
		$settings->api      = $this->api;
		$settings->settings = Fields::get_option( 'settings' );

		$GLOBALS['vcw'] = $settings;
		?>
        <div class="wrap">
            <h2><?php echo get_admin_page_title(); ?></h2>
            <div class="vcw-notifications"></div>
			<?php
			$get_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : false;
			if ( $get_tab ) {
				$this->tabs( $get_tab );
				$tab = $get_tab;
			} else if ( $get_tab == "general" ) {
				$this->tabs( 'general' );
				$tab = 'general';
			} else {
				$this->tabs( 'connect' );
				$tab = 'connect';
			}

			switch ( $tab ) {
				case 'connect':
					TemplateRouter::include_file( plugin_dir_path( __FILE__ ) . '/ui/connect.php' );
					break;
				case 'general':
					TemplateRouter::include_file( plugin_dir_path( __FILE__ ) . '/ui/general.php' );
					break;
				case 'logs':
					$logs = Logger::get_log_files();

					$logs_admin_uri = admin_url( 'edit.php?post_type=webex-events&page=webex-events-settings&tab=logs' );

					if ( ! empty( $_REQUEST['log_file'] ) && isset( $logs[ sanitize_title( wp_unslash( $_REQUEST['log_file'] ) ) ] ) ) {
						$viewed_log = $logs[ sanitize_title( wp_unslash( $_REQUEST['log_file'] ) ) ];
					} elseif ( ! empty( $logs ) ) {
						$viewed_log = current( $logs );
					}

					if ( ! empty( $_REQUEST['handle'] ) ) { // WPCS: input var ok, CSRF ok.
						if ( empty( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( wp_unslash( $_REQUEST['_wpnonce'] ), 'remove_log' ) ) { // WPCS: input var ok, sanitization ok.
							wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'video-conferencing-webex' ) );
						}

						if ( ! empty( $_REQUEST['handle'] ) ) {  // WPCS: input var ok.
							Logger::remove( wp_unslash( $_REQUEST['handle'] ) ); // WPCS: input var ok, sanitization ok.
						}

						wp_redirect( esc_url_raw( $logs_admin_uri ) );
						exit();
					}

					require plugin_dir_path( __FILE__ ) . '/ui/logs.php';
					break;
				case'extensions':
					TemplateRouter::include_file( plugin_dir_path( __FILE__ ) . '/ui/extensions.php' );
					break;
			}
			do_action( 'vcw_admin_tab_content', $tab );
			?>
        </div>
		<?php
	}

	static function get_message() {
		return self::$message;
	}

	static function set_message( $class, $message ) {
		self::$message = '<div class=' . $class . '><p>' . $message . '</p></div>';
	}

	private static $_instance = null;

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

}
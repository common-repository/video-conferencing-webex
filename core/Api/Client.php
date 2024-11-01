<?php

namespace Codemanas\Webex\Core\Api;

use Codemanas\Webex\Core\Helpers\Fields;
use Codemanas\Webex\Core\Helpers\Logger;

/**
 * Class Api
 *
 * @package Codemanas\Webex\Core\Api
 *
 * @since 1.0.0
 * @author Deepen
 */
class Client {
	const REDIRECT_URI = 'https://webex.codemanas.com/webex';
	const AUTHORIZE_URI = 'https://webexapis.com/v1/authorize';
	const ACCESS_TOKEN_URI = 'https://webexapis.com/v1/access_token';
	const REVOKE_URI = '';

	public $api_uri = 'https://webexapis.com/v1/';
	protected $_client_id = 'C168924203d82016199634a7420df53a10f844d6d947a72bf645e56735b52d3e7';
	protected $_client_secret = 'd833a5d1e2a27c14c26dbb777e8a04f650435d59759291893235540209709bbb';

	public $accessTokenData;
	public $errors;
	public $currentUserInfo;
	public $verified_uri;
	private $_scope;
	public $useMasterAccount = false;
	public $current_wp_user;

	public function getClient() {
		return $this->_client_id;
	}

	public function getSecret() {
		return $this->_client_secret;
	}

	public function __construct() {
		$this->_setParams();
	}

	/**
	 * Set necessary parameters for the call.
	 */
	private function _setParams() {
		$this->current_wp_user   = get_current_user_id();
		$this->useMasterAccount  = ! empty( Fields::get_option( 'settings' ) ) && ! empty( Fields::get_option( 'settings' )['useMasterAccount'] );
		$useManaulAuthentication = ! empty( Fields::get_option( 'settings' ) ) && ! empty( Fields::get_option( 'settings' )['useManualAuthentication'] );
		$this->verified_uri      = admin_url( 'edit.php?post_type=webex-events&page=webex-events-settings' );
		if ( $this->useMasterAccount ) {
			$this->accessTokenData = Fields::get_option( 'connected_access_token' );
			$this->currentUserInfo = Fields::get_option( 'currentUserInfo' );
			$this->errors          = Fields::get_option( 'connected_access_token_error' );

			if ( ! empty( $useManaulAuthentication ) ) {
				$this->_client_id     = ! empty( Fields::get_option( 'api_keys' ) ) && ! empty( Fields::get_option( 'api_keys' )['client_id'] ) ? Fields::get_option( 'api_keys' )['client_id'] : false;
				$this->_client_secret = ! empty( Fields::get_option( 'api_keys' ) ) && ! empty( Fields::get_option( 'api_keys' )['client_secret'] ) ? Fields::get_option( 'api_keys' )['client_secret'] : false;
			}
		} else {
			$this->accessTokenData = Fields::get_user_meta( $this->current_wp_user, 'connected_access_token' );
			$this->currentUserInfo = Fields::get_user_meta( $this->current_wp_user, 'currentUserInfo' );
			$this->errors          = Fields::get_user_meta( $this->current_wp_user, 'connected_access_token_error' );

			if ( ! empty( $useManaulAuthentication ) ) {
				$this->_client_id     = ! empty( Fields::get_user_meta( $this->current_wp_user, 'api_keys' ) ) && ! empty( Fields::get_user_meta( $this->current_wp_user, 'api_keys' )['client_id'] ) ? Fields::get_user_meta( $this->current_wp_user, 'api_keys' )['client_id'] : false;
				$this->_client_secret = ! empty( Fields::get_user_meta( $this->current_wp_user, 'api_keys' ) ) && ! empty( Fields::get_user_meta( $this->current_wp_user, 'api_keys' )['client_secret'] ) ? Fields::get_user_meta( $this->current_wp_user, 'api_keys' )['client_secret'] : false;
			}
		}

		$this->_scope = [
			'meeting:schedules_read',
			'meeting:schedules_write',
			'meeting:recordings_read',
			'meeting:recordings_write',
			'meeting:preferences_read',
			'meeting:preferences_write',
			'meeting:controls_read',
			'meeting:controls_write',
			'meeting:participants_read',
			'meeting:participants_write',
			'meeting:admin_schedule_read',
			'meeting:admin_recordings_read',
			'meeting:admin_recordings_write',
			'meeting:admin_schedule_write',
			'spark:people_read',
			'spark-admin:people_read',
			'spark-admin:people_write'
		];
	}

	public function getAccessToken() {
		$code = filter_input( INPUT_GET, 'code' );
		if ( empty( $code ) ) {
			return;
		}

		$request_access_token_url = add_query_arg(
			[
				'grant_type'    => 'authorization_code',
				'client_id'     => $this->_client_id,
				'client_secret' => $this->_client_secret,
				'code'          => $code,
				'redirect_uri'  => self::REDIRECT_URI,
			],
			self::ACCESS_TOKEN_URI
		);

		$post_response = wp_remote_post( $request_access_token_url );
		$response_body = json_decode( wp_remote_retrieve_body( $post_response ) );

		/*$result['date']     = date( 'Y-m-d H:i:s' );
		$result['response'] = var_export( $response_body, true );
		file_put_contents( VCW_DIR_PATH . 'responseBody.txt', $result, FILE_APPEND );*/

		if ( ! empty( $response_body->errors ) ) {
			$this->errors = $response_body;

			return $this->errors;
//			Fields::set_option( 'connected_access_token_error', $response_body );
			//log error in logger
		} else {
			$this->_saveAccessToken( $response_body );
			wp_redirect( $this->verified_uri );
			exit;
		}
	}

	public function getMyInfo() {
		return $this->sendRequest( 'people/me' );
	}

	/**
	 * Saving access token here.
	 *
	 * @param $response
	 */
	private function _saveAccessToken( $response ) {
		$this->accessTokenData = $response;
		//Set userdata
		$this->currentUserInfo = $this->getMyInfo();

		if ( $this->useMasterAccount ) {
			Fields::set_option( 'connected_access_token', $response );
			Fields::set_option( 'connected_access_token_error', '' );
			Fields::set_option( 'currentUserInfo', $this->currentUserInfo );
		} else {
			Fields::set_user_meta( $this->current_wp_user, 'connected_access_token', $response );
			Fields::set_user_meta( $this->current_wp_user, 'connected_access_token_error', '' );
			Fields::set_user_meta( $this->current_wp_user, 'currentUserInfo', $this->currentUserInfo );
		}
	}

	public function revokeAccessToken() {
		$revoke = filter_input( INPUT_GET, 'revoke' );
		if ( $revoke ) {
			Fields::set_option( 'connected_access_token', '' );
			Fields::set_option( 'connected_access_token_error', '' );
			Fields::set_option( 'currentUserInfo', '' );

			Fields::set_user_meta( $this->current_wp_user, 'connected_access_token', '' );
			Fields::set_user_meta( $this->current_wp_user, 'connected_access_token_error', '' );
			Fields::set_user_meta( $this->current_wp_user, 'currentUserInfo', '' );

			wp_redirect( $this->verified_uri );
		}
	}

	/**
	 * Get Authentication URI
	 *
	 * @param bool $client_id
	 *
	 * @return string
	 */
	public function getAuthenticationUri( $client_id = false ) {
		$accessTokenUri = add_query_arg(
			[
				'response_type' => 'code',
				'client_id'     => ! empty( $client_id ) ? $client_id : $this->_client_id,
				'redirect_uri'  => self::REDIRECT_URI,
				'state'         => $this->verified_uri,
				'scope'         => implode( ' ', $this->_scope )
			],
			self::AUTHORIZE_URI
		);

		return $accessTokenUri;
	}

	public function getRefreshToken( $endpoint, $data, $request ) {
		if ( empty( $this->accessTokenData->refresh_token ) ) {
			return false;
		}

		$requestRefreshTokenUrl = add_query_arg(
			[
				'grant_type'    => 'refresh_token',
				'client_id'     => $this->_client_id,
				'client_secret' => $this->_client_secret,
				'refresh_token' => $this->accessTokenData->refresh_token,
			],
			self::ACCESS_TOKEN_URI
		);

		$refreshTokenRequest = wp_remote_post( $requestRefreshTokenUrl );
		$response_body       = json_decode( wp_remote_retrieve_body( $refreshTokenRequest ) );

		if ( $response_body->errors ) {
			$this->errors = $response_body;

			return $this->errors;
//			Fields::set_option( 'connected_access_token_error', $response_body );
			//log error in logger
		} else {
			$this->_saveAccessToken( $response_body );
		}

		return $this->sendRequest( $endpoint, $data, $request );
	}

	public function sendRequest( $endpoint, $method = 'GET', $data = [] ) {
		if ( empty( $this->accessTokenData->access_token ) ) {
			return false;
		}

		$args = [
			'method'  => $method,
			'headers' => [
				'Authorization' => 'Bearer ' . $this->accessTokenData->access_token,
				'Content-Type'  => 'application/json'
			],
			'timeout' => 30
		];

		$callApi      = $this->api_uri . $endpoint;
		$args['body'] = ! empty( $data ) ? ( $method == "GET" ? $data : json_encode( $data ) ) : [];
		$request      = wp_remote_request( $callApi, $args );

		/*$test = var_export( $request, true );
		file_put_contents( VCW_DIR_PATH . 'responseBody.txt', $test );*/

		if ( is_wp_error( $request ) ) {
			return $request; // Bail early
		}

		$responseCode = wp_remote_retrieve_response_code( $request );
		$responseBody = wp_remote_retrieve_body( $request );
		$response     = json_decode( $responseBody );

		$goodCodes = [ 200, 201, 202, 204 ];
		if ( ! in_array( $responseCode, $goodCodes ) ) {
			$this->_logMessage( $responseBody, $responseCode, $request );
		}

		//Allow 3rd parties to alter the $args
		$response = apply_filters( 'vcw_sendRequest', $response, $responseCode, $endpoint, $data, $request );

		if ( $responseCode === 401 ) {
			$response = $this->getRefreshToken( $endpoint, $data, $request );
		}

		return $response;
	}

	private function _logMessage( $responseBody, $responseCode, $request ) {
		$message = $responseCode . ' ::: ';
		$message .= wp_remote_retrieve_response_message( $request );

		if ( ! empty( $responseBody ) ) {

			//Response body validation
			if ( vcwIsValidXML( $responseBody ) ) {
				$responseBody = simplexml_load_string( $responseBody );
			} else if ( vcwIsJson( $responseBody ) ) {
				$responseBody = json_decode( $responseBody );
			}

			if ( ! empty( $responseBody ) && ! empty( $responseBody->message ) ) {
				$message .= ' ::: MESSAGE => ' . $responseBody->message;
			} else if ( ! empty( $responseBody ) && is_string( $responseBody ) ) {
				$message .= ' ::: MESSAGE => ' . $responseBody;
			}

			if ( ! empty( $responseBody ) && ! empty( $responseBody->errors ) && is_object( $responseBody->errors ) && ! empty( $responseBody->errors->message ) ) {
				$message .= ' ::: ERRORS => ' . $responseBody->errors->message;
			}
		}

		$logger = new Logger();
		$logger->error( $message );
	}

}

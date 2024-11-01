<?php

namespace Codemanas\Webex\Core\Api;

class Endpoints extends Client {

	//Meetings
	public function getMeetings( $postData = [] ) {
		return $this->sendRequest( 'meetings', 'GET', $postData );
	}

	public function getMeetingByID( $id ) {
		return $this->sendRequest( 'meetings/' . $id, 'GET' );
	}

	public function createMeeting( array $postData ) {
		return $this->sendRequest( 'meetings', 'POST', $postData );
	}

	public function updateMeeting( $id, array $postData ) {
		return $this->sendRequest( 'meetings/' . $id, 'PUT', $postData );
	}

	public function deleteMeeting( $id ) {
		return $this->sendRequest( 'meetings/' . $id, 'DELETE' );
	}

	public function getPeople( $person_id = false ) {
		if ( $person_id ) {
			return $this->sendRequest( 'people/' . $person_id );
		} else {
			return $this->sendRequest( 'people' );
		}
	}

	public function getRecordingsList( array $data = [] ) {
		return $this->sendRequest( 'recordings', 'GET', $data );
	}

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Instance property
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
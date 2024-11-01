<?php

namespace Codemanas\Webex\Core\Data;

use Codemanas\Webex\Core\Api\Endpoints;
use Codemanas\Webex\Core\Helpers\Constants;
use Codemanas\Webex\Core\Helpers\Fields;

class Meetings {

	protected static $post_type = Constants::POST_TYPE;

	/**
	 * Check if certain POST meta ID exists that belongs to webex Meeting
	 *
	 * @param $meetingID
	 *
	 * @return array|object|void|null
	 *
	 * @since 1.0.0
	 * @author Deepen
	 */
	static function getEventByMeetingID( $meetingID ) {
		global $wpdb;

		$result = $wpdb->get_row( $wpdb->prepare( "SELECT * from $wpdb->postmeta WHERE meta_key='_vcw_meetingID' AND meta_value=%s", $meetingID ) );

		return $result;
	}

	/**
	 * Get events by post type
	 *
	 * @param $args
	 * @param bool $wp_query
	 *
	 * @return int[]|\WP_Post[]|\WP_Query
	 */
	static function getAllPostTypeEvents( $args, $wp_query = true ) {
		$defaults = array(
			'post_type'      => self::$post_type,
			'posts_per_page' => 10,
			'post_status'    => 'publish',
			'order'          => 'DESC',
		);

		$args  = wp_parse_args( $args, $defaults );
		$query = apply_filters( 'vcw_getAllPostTypeEventsArgs', $args );
		if ( $wp_query ) {
			$result = new \WP_Query( $query );
		} else {
			$result = get_posts( $query );
		}

		return $result;
	}

	/**
	 * Get single event post type data
	 *
	 * @param $post_id
	 *
	 * @return \WP_Query
	 */
	static function getSinglePostTypeEvent( $post_id ) {
		$query = new \WP_Query( array(
			'post_type' => self::$post_type,
			'p'         => $post_id
		) );

		return $query;
	}

	/**
	 * This is used for getting posted fields when creating or updating a webex meeting.
	 *
	 * @return array
	 */
	static function getPostedFormData(): array {
		return apply_filters( 'vcw_getPostedFormData', [
			'title'                       => sanitize_text_field( filter_input( INPUT_POST, 'post_title' ) ),
			'start'                       => sanitize_text_field( filter_input( INPUT_POST, 'eventStartDate' ) ),
			'password'                    => sanitize_text_field( filter_input( INPUT_POST, 'eventPassword' ) ),
			'hour'                        => sanitize_text_field( filter_input( INPUT_POST, 'eventHour' ) ),
			'minute'                      => sanitize_text_field( filter_input( INPUT_POST, 'eventMinute' ) ),
			'timezone'                    => sanitize_text_field( filter_input( INPUT_POST, 'eventTimezone' ) ),
			'enabledAutoRecordMeeting'    => filter_input( INPUT_POST, 'enabledAutoRecordMeeting' ),
			'enabledJoinBeforeHost'       => filter_input( INPUT_POST, 'enabledJoinBeforeHost' ),
			'enabledBreakoutSessions'     => filter_input( INPUT_POST, 'enabledBreakoutSessions' ),
			'enableAutomaticLock'         => filter_input( INPUT_POST, 'enableAutomaticLock' ),
			'automaticLockMinutes'        => filter_input( INPUT_POST, 'automaticLockMinutes' ),
			'unlockedMeetingJoinSecurity' => filter_input( INPUT_POST, 'unlockedMeetingJoinSecurity' ),
//			'reminderTime'                => filter_input( INPUT_POST, 'reminderTime' ),
		] );
	}

	/**
	 * Filter posted data before returning to API call
	 *
	 * @param $postData
	 *
	 * @return array|bool|void
	 */
	static function getPostData( $postData ) {
		if ( ! isset( $postData['title'] ) || ! isset( $postData['start'] ) ) {
			return false;
		}

		if ( isset( $postData['hour'] ) || isset( $postData['minute'] ) ) {
			$hourToMinutes = $postData['hour'] != 0 ? $postData['hour'] * 60 : 0;
			$minute        = $postData['minute'] != 0 ? $postData['minute'] : 0;

			$total_minutes = $hourToMinutes + $minute;
			$end_time      = gmdate( "Y-m-d\TH:i:s", strtotime( $postData['start'] . ' +' . $total_minutes . ' minutes' ) );
		}

		if ( ! isset( $end_time ) ) {
			return;
		}

		$data = [
			'title'                       => $postData['title'],
			'agenda'                      => Fields::isset( $postData['agenda'] ),
			'password'                    => Fields::isset( $postData['password'] ),
			'start'                       => Fields::isset( gmdate( "Y-m-d\TH:i:s", strtotime( $postData['start'] ) ) ),
			'end'                         => Fields::isset( $end_time ),
			'timezone'                    => Fields::isset( $postData['timezone'] ),
			'enabledAutoRecordMeeting'    => Fields::isset( (bool) $postData['enabledAutoRecordMeeting'], 0 ),
			'enabledJoinBeforeHost'       => Fields::isset( (bool) $postData['enabledJoinBeforeHost'], 0 ),
			'joinBeforeHostMinutes'       => Fields::isset( $postData['joinBeforeHostMinutes'], 0 ),
			'enabledBreakoutSessions'     => Fields::isset( (bool) $postData['enabledBreakoutSessions'], 0 ),
			'enableAutomaticLock'         => Fields::isset( (bool) $postData['enableAutomaticLock'], 0 ),
			'unlockedMeetingJoinSecurity' => Fields::isset( $postData['unlockedMeetingJoinSecurity'], 'allowJoinWithLobby' ),
//			'reminderTime'                => Fields::isset( (int) $postData['reminderTime'], 10 ),
		];

		if ( $data['enableAutomaticLock'] ) {
			$data['automaticLockMinutes'] = Fields::isset( (int) $postData['automaticLockMinutes'], 0 );
		}

		return $data;
	}

	/**
	 * Update the meeting using API.
	 *
	 * @param $id
	 * @param $postData
	 *
	 * @return array|bool|mixed|void|\WP_Error
	 */
	static function updateMeeting( $id, $postData ) {
		if ( ! isset( $id ) ) {
			return false;
		}

		$data = self::getPostData( $postData );

		$response = Endpoints::get_instance()->updateMeeting( $id, $data );

		return $response;
	}

	/**
	 * Create Meeting using API
	 *
	 * @param $postData
	 *
	 * @return array|bool|mixed|void|\WP_Error
	 */
	static function createMeeting( $postData ) {
		$data = self::getPostData( $postData );

		$response = Endpoints::get_instance()->createMeeting( $data );

		return $response;
	}

}
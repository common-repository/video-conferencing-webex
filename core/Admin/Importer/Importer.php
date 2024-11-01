<?php


namespace Codemanas\Webex\Core\Admin\Importer;

use Codemanas\Webex\Core\Api\Endpoints;
use Codemanas\Webex\Core\Data\Meetings;
use Codemanas\Webex\Core\Helpers\DateParser;
use Codemanas\Webex\Core\Helpers\Fields;
use Codemanas\Webex\Core\Helpers\TemplateRouter;

class Importer {

	public $config;

	/**
	 * PostType constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_fetch_all_meetings', [ $this, 'getAllMeetings' ] );

		//Import Meeting
		add_action( 'wp_ajax_vcw_import', [ $this, 'import' ] );
	}

	/**
	 * Fetch all meetings for importing
	 *
	 * @author Deepen
	 * @since 1.0.0
	 */
	public function getAllMeetings() {
		$from = sanitize_text_field( filter_input( INPUT_GET, 'from' ) );
		$to   = sanitize_text_field( filter_input( INPUT_GET, 'to' ) );

		$postedData = [
			'meetingType'   => 'scheduledMeeting',
			'scheduledType' => 'meeting',
			'max'           => 100,
			'from'          => ! empty( $from ) ? DateParser::getDateObject( $from )->format( 'c' ) : DateParser::getDateObject( 'now' )->format( 'c' ),
			'to'            => ! empty( $from ) ? DateParser::getDateObject( $to )->format( 'c' ) : DateParser::getDateObject( '+1 month' )->format( 'c' ),
		];

		$response = Endpoints::get_instance()->getMeetings( $postedData );
		if ( ! empty( $response->errors ) ) {
			wp_send_json( [ 'data' => false, 'success' => true, 'error' => $response->get_error_message() ] );
		}

		if ( ! empty( $response ) && ! empty( $response->items ) ) {
			$meetings = [];
			foreach ( $response->items as $item ) {
				$meetings[] = [
					'meetingID' => esc_html( $item->id ),
					'topic'     => esc_html( $item->title ),
					'start'     => esc_html( DateParser::getCustomFormattedDate( $item->start ) ) . '(' . esc_html( $item->timezone ) . ')',
				];
			}

			wp_send_json( [ 'data' => $meetings, 'success' => true, 'from' => $postedData['from'], 'to' => $postedData['to'] ] );
		} else {
			wp_send_json( [ 'data' => false, 'success' => true ] );
		}

		wp_die();
	}

	/**
	 * Import webex meetings finally
	 *
	 * @since 1.0.0
	 * @author Deepen
	 */
	public function import() {
		$meetingID = sanitize_key( filter_input( INPUT_POST, 'meetingID' ) );

		if ( is_null( $meetingID ) ) {
			wp_send_json_error( sprintf( __( 'Meeting with ID %s does not exists. Please check your webex account if the meeting ID provided really exists.', 'video-conferencing-webex' ), $meetingID ) );
		}

		$exists = Meetings::getEventByMeetingID( $meetingID );
		if ( $exists ) {
			wp_send_json_error( sprintf( __( 'Meeting with ID %s has already been imported or already exists.', 'video-conferencing-webex' ), $meetingID ) );
		}

		$meeting = Endpoints::get_instance()->getMeetingByID( $meetingID );

		if ( ! empty( $meeting ) && ! empty( $meeting->message ) ) {
			wp_send_json_error( $meeting->message );
		}

		$hour    = DateParser::getHourMinuteDiff( $meeting->start, $meeting->end, 'h' );
		$seconds = DateParser::getHourMinuteDiff( $meeting->start, $meeting->end, 's' );
		if ( ! empty( $meeting ) ) {
			$postData = [
				'title'                       => esc_html( $meeting->title ),
				'start'                       => date( "Y-m-d H:i", strtotime( esc_html( $meeting->start ) ) ),
				'password'                    => esc_html( $meeting->password ),
				'hour'                        => ! empty( $hour ) ? esc_html( $hour ) : 0,
				'minute'                      => ! empty( $seconds ) ? esc_html( $seconds ) : 0,
				'timezone'                    => esc_html( $meeting->timezone ),
				'enabledAutoRecordMeeting'    => esc_html( $meeting->enabledAutoRecordMeeting ),
				'enabledJoinBeforeHost'       => esc_html( $meeting->enabledJoinBeforeHost ),
				'enabledBreakoutSessions'     => esc_html( $meeting->enabledBreakoutSessions ),
				'enableAutomaticLock'         => esc_html( $meeting->enableAutomaticLock ),
				'automaticLockMinutes'        => esc_html( $meeting->automaticLockMinutes ),
				'unlockedMeetingJoinSecurity' => esc_html( $meeting->unlockedMeetingJoinSecurity ),
			];

			$post_arr = array(
				'post_title'   => esc_html( $meeting->title ),
				'post_content' => ! empty( $meeting->agenda ) ? esc_html( $meeting->agenda ) : '',
				'post_status'  => 'draft',
				'post_type'    => 'webex-events'
			);

			$post_id = wp_insert_post( $post_arr );
			if ( ! empty( $post_id ) ) {
				Fields::set_post_meta( $post_id, 'event_details', $postData );
				Fields::set_post_meta( $post_id, 'event_response', $meeting );
				Fields::set_post_meta( $post_id, 'meetingNumber', esc_html( $meeting->meetingNumber ) );
				Fields::set_post_meta( $post_id, 'meetingID', esc_html( $meeting->id ) );

				wp_send_json_success( sprintf( __( 'Successfully imported meeting: %s', 'video-conferencing-webex' ), esc_html( $meeting->id ) ) );
			}
		}

		wp_die();
	}

	/**
	 * Render the import view template
	 *
	 * @since 1.0.0
	 * @author Deepen
	 */
	public function render() {
		TemplateRouter::include_file( plugin_dir_path( __FILE__ ) . 'ui/import.php' );
	}

	private static $_instance = null;

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

}
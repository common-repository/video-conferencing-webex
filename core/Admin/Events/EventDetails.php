<?php

namespace Codemanas\Webex\Core\Admin\Events;

use Codemanas\Webex\Core\Api\Endpoints;
use Codemanas\Webex\Core\Data\Meetings;
use Codemanas\Webex\Core\Helpers\Constants;
use Codemanas\Webex\Core\Helpers\Fields;
use Codemanas\Webex\Core\Helpers\TemplateRouter;

class EventDetails {

	public $postType;

	private $_eventResponse = null;

	private $_eventErrors = null;

	public function __construct() {
		$this->postType       = Constants::POST_TYPE;
		$this->_eventResponse = isset( $_GET['post'] ) ? Fields::get_meta( $_GET['post'], 'event_response' ) : null;
		$this->_eventErrors   = isset( $_GET['post'] ) ? Fields::get_meta( $_GET['post'], 'event_responseErrors' ) : null;

		add_action( 'add_meta_boxes', [ $this, 'register' ] );
		add_action( 'save_post_' . $this->postType, [ $this, 'validateAndSave' ] );
		add_action( 'admin_notices', [ $this, 'showNotices' ] );
		add_action( 'before_delete_post', [ $this, 'delete' ] );
	}

	/**
	 * Delete the event in Webex also.
	 *
	 * @param $post_id
	 */
	public function delete( $post_id ) {
		$settings = Fields::get_option( 'general_settings' );
		if ( ! empty( $settings ) && ! empty( $settings['keepWebexMeetings'] ) ) {
			return;
		}

		if ( get_post_type( $post_id ) != $this->postType ) {
			return;
		}

		$eventDetails = Fields::get_meta( $post_id, 'event_response' );
		if ( ! empty( $eventDetails ) && isset( $eventDetails->id ) ) {
			do_action( 'vcw_beforeDeleteEvent', $eventDetails );

			Endpoints::get_instance()->deleteMeeting( $eventDetails->id );

			do_action( 'vcw_afterDeleteEvent' );
		}
	}

	private function _setResponse( $post_id ) {
		if ( empty( $this->_eventResponse ) ) {
			$this->_eventResponse = isset( $post_id ) ? Fields::get_meta( $post_id, 'event_response' ) : null;
			$this->_eventErrors   = isset( $post_id ) ? Fields::get_meta( $post_id, 'event_responseErrors' ) : null;
		}
	}

	public function showNotices() {
		$post_id = isset( $_GET['post'] ) ? sanitize_key( $_GET['post'] ) : '';
		if ( isset( $post_id ) ) {
			if ( ! empty( $this->_eventErrors ) && isset( $this->_eventErrors->errors ) ) { ?>
                <div class="error">
					<?php if ( ! empty( $this->_eventErrors->errors['http_request_failed'] ) ) {
						echo '<p>' . esc_html( $this->_eventErrors->errors['http_request_failed'][0] ) . '</p>';
					} else {
						foreach ( $this->_eventErrors->errors as $error ) {
							echo '<p>' . esc_html( $error->description ) . '</p>';
						}
					}
					?>
                    <p><?php _e( "Please re-update this event after correcting the error data provided above.", "video-conferencing-webex" ); ?></p>
                </div>
				<?php
			} else if ( isset( $this->_eventErrors->message ) ) {
				?>
                <div class="error">
                    <p><?php echo esc_html( $this->_eventErrors->message ); ?></p>
                    <p><?php _e( "Please re-update this event after correcting the error data provided above.", "video-conferencing-webex" ); ?></p>
                </div>
				<?php
			}
		}
	}

	public function validateAndSave( $post_id ) {
		$this->_setResponse( $post_id );

		// Check if our nonce is set.
		if ( ! isset( $_POST['vcw_meeting_fields_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['vcw_meeting_fields_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'vcw_meeting_fields' ) ) {
			return $post_id;
		}

		/*
		 * If this is an autosave, our form has not been submitted,
		 * so we don't want to do anything.
		 */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( Constants::POST_TYPE != $_POST['post_type'] ) {
			return $post_id;
		}

		$this->save( $post_id );
	}

	private function save( $post_id ) {
		$postData = Meetings::getPostedFormData();

		//Event Details
		Fields::set_post_meta( $post_id, 'event_details', $postData );

		if ( $post_id && ! empty( $this->_eventResponse ) && ! empty( $this->_eventResponse->id ) ) {
			$result = Meetings::updateMeeting( $this->_eventResponse->id, $postData );
		} else {
			$result = Meetings::createMeeting( $postData );
		}

		if ( ! empty( $result ) && $result->errors || ! empty( $result->message ) ) {
			Fields::set_post_meta( $post_id, 'event_responseErrors', $result );

			return;
		}

		//converted saved time from the timezone provided for meeting to UTC timezone so meetings can be better queried
		try {
			$savedDateTime     = new \DateTime( $result->start, new \DateTimeZone( $result->timezone ) );
			$startDateTimezone = $savedDateTime->setTimezone( new \DateTimeZone( 'UTC' ) );

			Fields::set_post_meta( $post_id, 'start_date_utc', $startDateTimezone->format( 'Y-m-d H:i:s' ) );
		} catch ( \Exception $e ) {
			Fields::set_post_meta( $post_id, 'start_date_utc', $e->getMessage() );
		}

		Fields::set_post_meta( $post_id, 'event_response', $result );
		Fields::set_post_meta( $post_id, 'meetingNumber', $result->meetingNumber );
		Fields::set_post_meta( $post_id, 'meetingID', $result->id );
		Fields::set_post_meta( $post_id, 'event_responseErrors', '' );
	}

	public function eventSettingsForm( $post ) {
		unset( $GLOBALS['vcw'] );

		$eventDetails = Fields::get_meta( $post->ID, 'event_details' );

		$obj                   = new \stdClass();
		$obj->defaultTimezones = vcw_getAllTimezone();
		$obj->eventSettings    = $eventDetails;
		$obj->api              = $this->_eventResponse;
		$obj->post_id          = $post->ID;
		$GLOBALS['vcw']        = $obj;

		echo "<div style='padding: 0 10px;'>";
		TemplateRouter::include_file( plugin_dir_path( __FILE__ ) . '/ui/event-settings.php' );
		echo '</div>';
	}

	public function register() {
		// Limit meta box to certain post types.
		add_meta_box(
			'vcw_event_fields',
			__( "Event Settings", "video-conferencing-webex" ),
			array( $this, 'eventSettingsForm' ),
			Constants::POST_TYPE,
			'advanced',
			'high'
		);

		add_meta_box(
			'vcw_event_details',
			__( "Event Details", "video-conferencing-webex" ),
			array( $this, 'eventDetailsForm' ),
			Constants::POST_TYPE,
			'side',
			'high'
		);
	}

	public function eventDetailsForm( $post ) {
		unset( $GLOBALS['vcw'] );

		$GLOBALS['vcw'] = $this->_eventResponse;
		if ( $this->_eventResponse ) {
			TemplateRouter::include_file( plugin_dir_path( __FILE__ ) . '/ui/event-details.php' );
		} else {
			echo "<p>" . __( "Please create your event first in order to view your meeting details here.", "video-conferencing-webex" ) . "</p>";
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
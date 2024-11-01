<?php

namespace Codemanas\Webex\Core\Modules\Events;

use Codemanas\Webex\Core\Helpers\Constants;
use Codemanas\Webex\Core\Helpers\DateParser;
use Codemanas\Webex\Core\Helpers\TemplateRouter;

class Ajax {

	private $post_type;

	public function __construct() {
		$this->post_type = Constants::POST_TYPE;

		add_action( 'wp_ajax_validateJoinLink', [ $this, 'validateJoinLink' ] );
		add_action( 'wp_ajax_nopriv_validateJoinLink', [ $this, 'validateJoinLink' ] );
	}

	public function validateJoinLink() {
		$userTimezone = filter_input( INPUT_POST, 'userTimezone' );
		$startTime    = filter_input( INPUT_POST, 'startTime' );
		$endTime      = filter_input( INPUT_POST, 'endTime' );
		$post_id      = filter_input( INPUT_POST, 'postId' );

		/**
		 * @todo
		 *
		 * If user decides to show the link 1 hour before the meeting then this converted would be helpul.
		 * Leaving it here for future purpose.
		 */
		$end_date     = DateParser::getDateObject( $endTime, $userTimezone );
		$current_time = DateParser::getDateObject( 'now', $userTimezone );

		if ( $end_date > $current_time ) {
			ob_start();

			Events::get_instance()->setGlobals( $post_id );

			$tpl = TemplateRouter::get_template( 'single-event/cta.php' );
			$tpl .= ob_get_clean();
			wp_send_json_success( $tpl );
		} else {
			wp_send_json_error( apply_filters( 'vcw_joinLinkNoLongerValid', __( "This event has completed and cannot be joined!", "video-conferencing-webex" ) ) );
		}
		wp_die();
	}

	private static $_instance = null;

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

}
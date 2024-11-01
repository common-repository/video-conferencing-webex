<?php

namespace Codemanas\Webex\Core\Shortcodes;

use Codemanas\Webex\Core\Api\Endpoints;
use Codemanas\Webex\Core\Data\Meetings;
use Codemanas\Webex\Core\Helpers\Constants;
use Codemanas\Webex\Core\Helpers\TemplateRouter;
use Codemanas\Webex\Core\Modules\Events\Events;

class Shortcodes {

	/**
	 * Shortcodes constructor.
	 */
	public function __construct() {
		add_shortcode( 'vcw_single_event', [ $this, 'singleEvent' ] );
	}

	/**
	 * Single event display shortcode
	 *
	 * @param $atts
	 *
	 * @return false|string
	 */
	public function singleEvent( $atts ) {
		wp_enqueue_script( 'vcw' );
		wp_enqueue_style( 'vcw' );

		$atts = shortcode_atts( [
			'id'            => false,
			'hide_password' => true,
			'post_type'     => false
		], $atts, 'vcw_single_event' );

		if ( empty( $atts['id'] ) ) {
			_e( "Event ID is required.", "video-conferencing-webex" );
		}

		unset( $GLOBALS['vcw'] );

		ob_start();
		if ( $atts['post_type'] ) {
			$meeting = Meetings::getSinglePostTypeEvent( $atts['id'] );

			//Checking if post type is valid
			if ( get_post_type( $atts['id'] ) != Constants::POST_TYPE ) {
				_e( "Invalid Meeting ID provided.", "video-conferencing-webex" );

				return false;
			}

			if ( $meeting->have_posts() ) {
				Events::get_instance()->setGlobals( $atts['id'] );

				while ( $meeting->have_posts() ) {
					$meeting->the_post();

					TemplateRouter::get_template( 'content-single-event.php' );
				}

				wp_reset_postdata();
			}
		} else {
			$vcw = Endpoints::get_instance()->getMeetingByID( $atts['id'] );
			if ( ! $vcw ) {
				_e( "Invalid Meeting ID provided.", "video-conferencing-webex" );

				return false;
			}

			if ( isset( $vcw->message ) ) {
				return $vcw->message;
			}

			$vcw->settings = [
				'hide_password' => $atts['hide_password']
			];

			$GLOBALS['vcw'] = $vcw;

			TemplateRouter::get_template( 'shortcodes/single-event/by-meeting-id.php' );
		}

		return ob_get_clean();
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
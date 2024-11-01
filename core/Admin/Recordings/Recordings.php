<?php

namespace Codemanas\Webex\Core\Admin\Recordings;

use Codemanas\Webex\Core\Api\Endpoints;
use Codemanas\Webex\Core\Helpers\DateParser;
use Codemanas\Webex\Core\Helpers\TemplateRouter;

/**
 * Class Recordings
 * @package Codemanas\Webex\Core\Admin\Recordings
 */
class Recordings {

	/**
	 * Recordings constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_vcw-get-recordings', [ $this, 'getRecordings' ] );
	}

	/**
	 * Fetch recordings
	 *
	 * @since 1.0.0
	 * @added Deepen
	 */
	public function getRecordings() {
		$from = filter_input( INPUT_GET, 'from' );
		$to   = filter_input( INPUT_GET, 'to' );

		$postedData = [
			'max'  => 100,
			'from' => ! empty( $from ) ? DateParser::getDateObject( $from )->format( 'c' ) : DateParser::getDateObject( '-1 month' )->format( 'c' ),
			'to'   => ! empty( $from ) ? DateParser::getDateObject( $to )->format( 'c' ) : DateParser::getDateObject( 'now' )->format( 'c' ),
		];

		$response = Endpoints::get_instance()->getRecordingsList( $postedData );
		$users    = [];
		if ( ! empty( $response ) && ! empty( $response->items ) ) {
			foreach ( $response->items as $item ) {
				$users[] = [
					'name'     => '<a href=' . $item->playbackUrl . ' target="_blank">' . esc_html( $item->topic ) . '</a>',
					'created'  => esc_html( DateParser::getCustomFormattedDate( $item->createTime ) ),
					'duration' => gmdate( 'H:i:s', esc_html( $item->durationSeconds ) ),
					'size'     => vcw_get_filesize( esc_html( $item->sizeBytes ) ),
					'format'   => esc_html( $item->format ),
					'download' => '<a href=' . esc_url( $item->downloadUrl ) . ' target="_blank"><span class="dashicons dashicons-download"></span></a>'
				];
			}

			wp_send_json( [ 'data' => $users, 'success' => true, 'from' => $postedData['from'], 'to' => $postedData['to'] ] );
		} else {
			wp_send_json_error( false );
		}
		wp_die();
	}

	/**
	 * Render recordings admin view
	 *
	 * @since 1.0.0
	 * @added Deepen
	 */
	public function render() {
		wp_enqueue_style( 'vcw-flatpickr' );
		wp_enqueue_script( 'vcw-flatpickr' );
		?>
        <div class="wrap">
            <h2><?php echo get_admin_page_title(); ?></h2>
			<?php TemplateRouter::include_file( plugin_dir_path( __FILE__ ) . '/ui/recordings.php' ); ?>
        </div>
		<?php
	}

	private static $_instance = null;

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

}
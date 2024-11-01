<?php

namespace Codemanas\Webex\Core\Admin\Users;

use Codemanas\Webex\Core\Api\Endpoints;
use Codemanas\Webex\Core\Helpers\DateParser;
use Codemanas\Webex\Core\Helpers\TemplateRouter;

class Users {

	public function __construct() {
		add_action( 'wp_ajax_vcw-get-users', [ $this, 'getUsers' ] );
	}

	public function getUsers() {
		$response = Endpoints::get_instance()->getPeople();
		$users    = [];
		if ( ! empty( $response ) && ! empty( $response->items ) ) {
			foreach ( $response->items as $item ) {
				$users[] = [
					'firstName' => esc_html( $item->firstName ),
					'lastName'  => esc_html( $item->lastName ),
					'email'     => esc_html( $item->emails[0] ),
					'createdOn' => esc_html( DateParser::getCustomFormattedDate( $item->created ) )
				];
			}

			wp_send_json_success( $users );
		} else {
			wp_send_json_error( false );
		}
		wp_die();
	}

	public function render() {
		?>
        <div class="wrap">
            <h2><?php echo get_admin_page_title(); ?></h2>
			<?php TemplateRouter::include_file( plugin_dir_path( __FILE__ ) . '/ui/users.php' ); ?>
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
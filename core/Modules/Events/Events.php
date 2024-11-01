<?php

namespace Codemanas\Webex\Core\Modules\Events;

use Codemanas\Webex\Core\Helpers\Constants;
use Codemanas\Webex\Core\Helpers\Fields;
use Codemanas\Webex\Core\Helpers\TemplateRouter;

class Events {

	private $post_type;

	public function __construct() {
		$this->post_type = Constants::POST_TYPE;
		$this->init();
	}

	public function init() {
		add_filter( 'single_template', [ $this, 'single' ] );
		add_filter( 'archive_template', [ $this, 'archive' ] );
	}

	public function setGlobals( $post_id ) {
		unset( $GLOBALS['vcw'] );

		$eventResponse = Fields::get_meta( $post_id, 'event_response' );

		$vcw = new \stdClass();
		if ( ! empty( $eventResponse ) ) {
			$vcw = $eventResponse;
		}

		$terms = get_the_terms( $post_id, Constants::TAXONOMY );
		if ( ! empty( $terms ) ) {
			$set_terms = array();
			foreach ( $terms as $term ) {
				$set_terms[] = $term->name;
			}
			$vcw->terms = $set_terms;
		}

		$vcw = apply_filters( 'vcw_setGlobals', $vcw, $post_id );

		$GLOBALS['vcw'] = $vcw;
	}

	public function single( $template ) {
		wp_enqueue_script( 'vcw' );

		global $post;

		if ( ! empty( $post ) && $post->post_type != $this->post_type ) {
			return $template;
		}

		$this->setGlobals( $post->ID );

		if ( isset( $_GET['join'] ) ) {
			$template = TemplateRouter::get_template( 'join-via-browser.php', true );
		} else {
			$template = TemplateRouter::get_template( 'single-event.php', true );
		}

		return $template;
	}

	public function archive( $template ) {
		global $post;

		if ( ! empty( $post ) && $post->post_type != $this->post_type ) {
			return $template;
		}

		$template = TemplateRouter::get_template( 'archive-event.php', true );

		return $template;
	}

	public function archiveGlobals() {
		$post_id = get_the_id();
		$this->setGlobals( $post_id );
	}

	private static $_instance = null;

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

}
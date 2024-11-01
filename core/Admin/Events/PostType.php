<?php

namespace Codemanas\Webex\Core\Admin\Events;

use Codemanas\Webex\Core\Helpers\Constants;
use Codemanas\Webex\Core\Helpers\DateParser;
use Codemanas\Webex\Core\Helpers\Fields;
use Codemanas\Webex\Core\Helpers\TemplateRouter;

/**
 * Class Base
 * @package Codemanas\Webex\Core\Admin\Menu
 * @since 1.0.0
 * @author Deepen
 */
class PostType {

	private $post_type;

	/**
	 * Init Post Type
	 */
	public function init() {
		$this->register_custom_post_type();
		$this->register_taxnomy();
	}

	/**
	 * Custom Post Type Arguements
	 *
	 * @return array
	 * @author Deepen
	 *
	 * @since 4.0.0
	 */
	public function postTypeArgs() {
		$labels = apply_filters( 'vcw_postTypeLabels', [
			'name'               => _x( 'Webex Events', 'Webex Events', 'video-conferencing-webex' ),
			'singular_name'      => _x( 'Webex Events', 'Webex Events', 'video-conferencing-webex' ),
			'menu_name'          => _x( 'Webex Events', 'Webex Events', 'video-conferencing-webex' ),
			'name_admin_bar'     => _x( 'Webex Events', 'Webex Events', 'video-conferencing-webex' ),
			'add_new'            => __( 'Add New', 'video-conferencing-webex' ),
			'add_new_item'       => __( 'Add New Event', 'video-conferencing-webex' ),
			'new_item'           => __( 'New Webex Event', 'video-conferencing-webex' ),
			'edit_item'          => __( 'Edit Webex Event', 'video-conferencing-webex' ),
			'view_item'          => __( 'View meetings', 'video-conferencing-webex' ),
			'all_items'          => __( 'All Events', 'video-conferencing-webex' ),
			'search_items'       => __( 'Search meetings', 'video-conferencing-webex' ),
			'parent_item_colon'  => __( 'Parent meetings:', 'video-conferencing-webex' ),
			'not_found'          => __( 'No Webex events found.', 'video-conferencing-webex' ),
			'not_found_in_trash' => __( 'No Webex events found in Trash.', 'video-conferencing-webex' )
		] );

		$args = [
			'labels'              => $labels,
			'public'              => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'query_var'           => true,
			'capability_type'     => 'post',
			'menu_icon'           => 'dashicons-video-alt2',
			'has_archive'         => apply_filters( 'vcw_cptHasArchive', true ),
			'hierarchical'        => apply_filters( 'vcw_cptHierarchical', false ),
			'map_meta_cap'        => apply_filters( 'vcw_cptMapMetaCap', null ),
			'show_in_rest'        => false,
			'rest_base'           => apply_filters( 'vcw_cptRewrite', 'webex_events' ),
			'menu_position'       => 5,
			'rewrite'             => apply_filters( 'vcw_cptRewrite', 'webex_events' )
		];

		$args['supports'] = array(
			'title',
			'editor',
			'author',
			'thumbnail',
		);

		return $args;
	}

	/**
	 * Finally Register the post type
	 *
	 * @since 4.0.0
	 * @author Deepen
	 */
	public function register_custom_post_type() {
		register_post_type( $this->post_type, $this->postTypeArgs() );
	}

	/**
	 * Register Taxonomy for the Post Type
	 */
	public function register_taxnomy() {
		$args = array(
			'hierarchical'      => true,
			'labels'            => [
				'name' => __( 'Category', 'video-conferencing-webex' )
			],
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rest_base'         => 'webex_meeting_taxonomy',
			'query_var'         => true,
		);

		register_taxonomy( Constants::TAXONOMY, array( $this->post_type ), $args );
	}

	/**
	 * Add New Start Link column
	 *
	 * @param $columns
	 *
	 * @return mixed
	 */
	public function add_columns( $columns ) {
		$columns['join_event'] = __( 'Join Event', 'video-conferencing-webex' );
		$columns['event_date'] = __( 'Event Date', 'video-conferencing-webex' );
		$columns['event_id']   = __( 'Meeting ID', 'video-conferencing-webex' );

		return $columns;
	}

	/**
	 * Render HTML
	 *
	 * @param $column
	 * @param $post_id
	 */
	public function column_data( $column, $post_id ) {
		$meeting = Fields::get_meta( $post_id, 'event_response' );
		switch ( $column ) {
			case 'join_event' :
				if ( ! empty( $meeting ) && ! empty( $meeting->webLink ) ) {
					echo '<a href="' . esc_url( $meeting->webLink ) . '" target="_blank">' . __( "Join Now", "video-conferencing-webex" ) . '</a>';
				} else {
					echo "N/A";
				}
				break;
			case 'event_date' :
				if ( ! empty( $meeting ) && $meeting->start ) {
					echo esc_html( DateParser::getCustomFormattedDate( $meeting->start ) ) . '<br>(' . esc_html( $meeting->timezone ) . ')';
				} else {
					echo "N/A";
				}
				break;
			case 'event_id' :
				if ( ! empty( $meeting ) && $meeting->id ) {
					echo esc_html( $meeting->id );
				} else {
					echo "N/A";
				}
				break;
		}
	}

	/**
	 * PostType constructor.
	 */
	public function __construct() {
		$this->post_type = Constants::POST_TYPE;

		add_filter( 'manage_' . $this->post_type . '_posts_columns', array( $this, 'add_columns' ) );
		add_action( 'manage_' . $this->post_type . '_posts_custom_column', array( $this, 'column_data' ), 20, 2 );
		add_action( 'init', [ $this, 'init' ] );
	}

	private static $_instance = null;

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

}
<?php
/**
 * This file contains necessary hooks for displaying elements on the frontend side.
 *
 * Functional Component.
 *
 * @since 1.0.0
 * @author Deepen
 */

//Left
add_action( 'vcw_single_event_content_left', 'vcw_event_description', 10 );

//Right
add_action( 'vcw_single_event_content_right', 'vcw_event_countdown_timer', 10 );
add_action( 'vcw_single_event_content_right', 'vcw_event_details', 20 );

//Archive Content
add_action( 'vcw_main_content_post_loop', [ \Codemanas\Webex\Core\Modules\Events\Events::get_instance(), 'archiveGlobals'], 10 );
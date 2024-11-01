<?php
/**
 * The Template for displaying single event wrappers
 *
 * This template can be overridden by copying it to yourtheme/video-conferencing-webex/single-event.php.
 *
 * @package    Video Conferencing via Webex/Templates
 * @version     1.0.0
 * @since       1.0.0
 */

use Codemanas\Webex\Core\Helpers\TemplateRouter;

defined( 'ABSPATH' ) || exit;

get_header();

/**
 * vcw_before_single_event hook.
 */
do_action( 'vcw_before_single_event' );

while ( have_posts() ) {
	the_post();

	TemplateRouter::get_template( 'content-single-event.php' );
}

/**
 * vcw_after_single_event hook.
 */
do_action( 'vcw_after_single_event' );

get_footer();
/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */

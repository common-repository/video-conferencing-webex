<?php
/**
 * The Template for displaying single event details
 *
 * This template can be overridden by copying it to yourtheme/video-conferencing-webex/content-single-event.php.
 *
 * @package    Video Conferencing via Webex/Templates
 * @version     1.0.0
 * @since       1.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'vcw_before_single_event_content' );
?>

    <div class="vcw-row vcw-single-event-container vcw-wrap-<?php echo get_the_id(); ?>" id="vcw-wrap-<?php echo get_the_id(); ?>">
        <div class="vcw-col-8 vcw-col">
			<?php
			/**
			 *  Hook: vcw_single_event_content_left
			 *
			 * @vcw_event_description - 10
			 */
			do_action( 'vcw_single_event_content_left' );
			?>
        </div>
        <div class="vcw-col-4 vcw-col">
            <div class="vcw-sidebar-wrapper">
				<?php
				/**
				 *  Hook: vcw_single_event_content_right
				 *
				 * @vcw_event_countdown_timer - 10
				 * @vcw_event_details - 20
				 * @vcw_event_cta - 30
				 *
				 */
				do_action( 'vcw_single_event_content_right' );
				?>
            </div>
        </div>
    </div>

<?php
do_action( 'vcw_after_single_event_content' );
?>
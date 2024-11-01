<?php
/**
 * The Template for displaying details for the event
 *
 * This template can be overridden by copying it to yourtheme/video-conferencing-webex/single-event/details.php
 *
 * @package    Video Conferencing via Webex/Templates
 * @version     1.0.0
 * @since       1.0.0
 */

global $vcw;
?>

<div class="vcw-details-section">
    <div class="vcw-details-section-title">
        <h3><?php _e( "Event Details", "video-conferencing-webex" ); ?></h3>
    </div>
    <div class="vcw-details-section-contents">
        <div class="vcw-details-section-contents-topic">
            <span><strong><?php _e( "Topic", "video-conferencing-webex" ); ?>:</strong></span> <span><?php the_title(); ?></span>
        </div>
        <div class="vcw-details-section-contents-hosted-by">
            <span><strong><?php _e( "Hosted By", "video-conferencing-webex" ); ?>:</strong></span>
            <span><?php echo esc_html( $vcw->hostDisplayName ); ?></span>
        </div>
		<?php if ( ! empty( $vcw->terms ) ) { ?>
            <div class="vcw-details-section-contents-terms">
                <span><strong><?php _e( 'Type', 'video-conferencing-webex' ); ?>:</strong></span>
                <span><?php echo esc_html( implode( ', ', $vcw->terms ) ); ?></span>
            </div>
		<?php } ?>
        <div class="vcw-details-section-contents-start">
            <span><strong><?php _e( "Start", "video-conferencing-webex" ); ?>:</strong></span>
            <span id="vcw-details-single-user-date"><?php echo esc_html( \Codemanas\Webex\Core\Helpers\DateParser::getCustomFormattedDate( $vcw->start ) ); ?></span>
        </div>
        <div class="vcw-details-section-contents-timezone">
            <span><strong><?php _e( "Current Timezone", "video-conferencing-webex" ); ?>:</strong></span>
            <span id="vcw-details-single-user-timezone"><?php echo esc_html( $vcw->timezone ); ?></span>
        </div>
    </div>
</div>

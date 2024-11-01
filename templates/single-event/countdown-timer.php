<?php
/**
 * The Template for displaying countdown timer for frontend
 *
 * This template can be overridden by copying it to yourtheme/video-conferencing-webex/single-event/countdown-timer.php
 *
 * @package    Video Conferencing via Webex/Templates
 * @version     1.0.0
 * @since       1.0.0
 */

global $vcw;
?>

<div class="vcw-countdown-container" data-start-date="<?php echo esc_attr( $vcw->start ); ?>" data-end-date="<?php echo esc_attr( $vcw->end ); ?>">
    <div class="vcw-countdown-timer-cell">
        <div id="vcw-countdown-day" class="vcw-countdown-counter">00</div>
        <div class="vcw-countdown-timer-cell-string"><?php _e( "days", "video-conferencing-webex" ); ?></div>
    </div>
    <div class="vcw-countdown-timer-cell">
        <div id="vcw-countdown-hour" class="vcw-countdown-counter">00</div>
        <div class="vcw-countdown-timer-cell-string"><?php _e( "hours", "video-conferencing-webex" ); ?></div>
    </div>
    <div class="vcw-countdown-timer-cell">
        <div id="vcw-countdown-min" class="vcw-countdown-counter">00</div>
        <div class="vcw-countdown-timer-cell-string"><?php _e( "minutes", "video-conferencing-webex" ); ?></div>
    </div>
    <div class="vcw-countdown-timer-cell">
        <div id="vcw-countdown-sec" class="vcw-countdown-counter">00</div>
        <div class="vcw-countdown-timer-cell-string"><?php _e( "seconds", "video-conferencing-webex" ); ?></div>
    </div>
</div>

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

<div class="vcw-cta-join-via-app">
    <a href="<?php echo esc_url( $vcw->webLink ); ?>" class="vcw-button vcw-join-btn" target="_blank"><?php _e( "Join Now", "video-conferencing-webex" ); ?></a>
</div>

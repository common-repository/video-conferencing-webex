<?php
/**
 * The Template for displaying single event post type details
 *
 * This template can be overridden by copying it to yourtheme/video-conferencing-webex/shortcode/single-event/event-post-type.php
 *
 * @package    Video Conferencing via Webex/Templates
 * @version     1.0.0
 * @since       1.0.0
 */

global $vcw;
?>

<table>
    <tr>
        <th><?php _e( "Meeting Number", "video-conferencing-webex" ); ?></th>
        <td><?php echo esc_html( $vcw->meetingNumber ); ?></td>
    </tr>
    <tr>
        <th><?php _e( "Topic", "video-conferencing-webex" ); ?></th>
        <td><?php echo esc_html( $vcw->title ); ?></td>
    </tr>
	<?php if ( ! $vcw->settings['hide_password'] ) { ?>
        <tr>
            <th><?php _e( "Password", "video-conferencing-webex" ); ?></th>
            <td><?php echo esc_html( $vcw->password ); ?></td>
        </tr>
	<?php } ?>
    <tr>
        <th><?php _e( "Start Time", "video-conferencing-webex" ); ?></th>
        <td id="vcw-details-single-user-date">
            <span class="vcw-countdown-container" data-countdown="0" data-start-date="<?php echo esc_attr( $vcw->start ); ?>" data-end-date="<?php echo esc_attr( $vcw->end ); ?>"><?php echo esc_html( $vcw->start ); ?></span>
        </td>
    </tr>
    <tr>
        <th><?php _e( "Current Timezone", "video-conferencing-webex" ); ?></th>
        <td><span id="vcw-details-single-user-timezone"><?php echo esc_html( $vcw->timezone ); ?></span></td>
    </tr>
    <tr>
        <th><?php _e( "Join", "video-conferencing-webex" ); ?></th>
        <td><a href="<?php echo esc_url( $vcw->webLink ); ?>" target="_blank"><?php _e( "Join Now", "video-conferencing-webex" ); ?></a></td>
    </tr>
</table>

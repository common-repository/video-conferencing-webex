<?php
global $vcw;
?>
<p><strong><?php _e( "Meeting ID", "video-conferencing-webex" ); ?>:</strong> <?php echo esc_html( $vcw->id ); ?></p>
<?php if ( ! empty( $vcw->password ) ) { ?>
    <p><strong><?php _e( "Password", "video-conferencing-webex" ); ?>:</strong> <?php echo esc_html( $vcw->password ); ?></p>
<?php } ?>
<p><a href="<?php echo esc_url( $vcw->webLink ); ?>" target="_blank"><?php _e( "Join Now", "video-conferencing-webex" ); ?></a></p>

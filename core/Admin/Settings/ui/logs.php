<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="vcw-card">
	<?php if ( ! empty( $viewed_log ) ) { ?>
        <div class="alignleft">
            <h2>
				<?php echo esc_html( $viewed_log ); ?>
				<?php if ( ! empty( $viewed_log ) ) : ?>
                    <a class="page-title-action" href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'handle' => sanitize_title( $viewed_log ) ), $logs_admin_uri ), 'remove_log' ) ); ?>" class="button"><?php esc_html_e( 'Delete log', 'video-conferencing-webex' ); ?></a>
				<?php endif; ?>
            </h2>
        </div>
	<?php } ?>
    <div class="alignright">
        <form action="<?php echo esc_url( $logs_admin_uri ); ?>" method="post">
			<?php
			$log_files = \Codemanas\Webex\Core\Helpers\Logger::get_log_files();
			if ( ! empty( $log_files ) ) {
				?>
                <select name="log_file">
					<?php
					foreach ( $log_files as $k => $log_file ) {
						$timestamp     = filemtime( VCW_LOG_DIR . $log_file );
						$log_file_date = wp_date( get_option( 'date_format' ), $timestamp );
						?>
                        <option value="<?php echo esc_html( $log_file ); ?>" <?php selected( sanitize_title( $viewed_log ), $k ); ?>><?php echo esc_html( $log_file_date ); ?></option>
					<?php } ?>
                </select>
                <button type="submit" class="button" value="<?php esc_attr_e( 'View', 'video-conferencing-webex' ); ?>"><?php esc_html_e( 'View', 'video-conferencing-webex' ); ?></button>
				<?php
			}
			?>
        </form>
    </div>
    <div class="clear"></div>
    <div id="log-viewer">
		<?php if ( ! empty( $viewed_log ) ) { ?>
            <pre><strong>===START OF LOG===</strong><br><?php echo esc_html( file_get_contents( VCW_LOG_DIR . $viewed_log ) ); ?><strong>===END OF LOG===</strong></pre>
		<?php } else {
			_e( 'No logs found.', 'video-conferencing-webex' );
		} ?>
    </div>
</div>

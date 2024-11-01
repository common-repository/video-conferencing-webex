<?php
/**
 * The template for displaying archive of webex events
 *
 * This template can be overridden by copying it to yourtheme/video-conferencing-webex/archive-event.php.
 *
 * @author Deepen
 * @since 1.0.0
 */

use Codemanas\Webex\Core\Helpers\TemplateRouter;

defined( 'ABSPATH' ) || exit;

get_header();

/**
 * Before the LOOP archive page
 */
do_action( 'vcw_before_main_archive_content' );
?>
    <div class="vcw-container">
        <div class="vcw-page-header">
            <h1 class="vcw-archive-page-title"><?php _e( 'Events', 'video-conferencing-webex' ); ?></h1>
        </div><!-- .page-header -->
		<?php
		/**
		 * BEFORE LOOP HOOK
		 */
		do_action( 'vcw_before_main_content_loop_html' );

		if ( have_posts() ) {
			?>
            <div class="vcw-row vcw-g-3 vcw-list-events">
				<?php
				// Start the Loop.
				while ( have_posts() ) {
					the_post();

					do_action( 'vcw_main_content_post_loop' );

					TemplateRouter::get_template( 'archive-loop.php' );
				}

				wp_reset_postdata();
				?>
            </div>
            <div class="vcw-pagination">
				<?php echo paginate_links(); ?>
            </div>
			<?php
		} else {
			echo "<p class='vcw-no-meeting-found'>" . __( 'No Meetings found.', 'video-conferencing-webex' ) . "</p>";
		}

		/**
		 * AFTER LOOP HOOK
		 */
		do_action( 'vcw_after_main_content_loop_html' );
		?>
    </div>
<?php
/**
 * After loop call
 */
do_action( 'vcw_after_main_archive_content' );

get_footer();

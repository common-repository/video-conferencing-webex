<?php
/**
 * The template for displaying loop contents of archive loop
 *
 * This template can be overridden by copying it to yourtheme/video-conferencing-webex/archive-loop.php.
 *
 * @author Deepen
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

global $vcw;
?>
<div class="vcw-list-item">
	<?php if ( has_post_thumbnail() ) { ?>
        <div class="vcw-list-item-image">
			<?php the_post_thumbnail(); ?>
        </div><!--Image End-->
	<?php } ?>
    <div class="vcw-list-item-details">
        <div class=vcw-list-item-details-start-time><?php echo esc_html( \Codemanas\Webex\Core\Helpers\DateParser::getCustomFormattedDate( $vcw->start ) ); ?> (<?php echo esc_html( $vcw->timezone ); ?>)</div>
        <a href="<?php echo esc_url( get_the_permalink() ) ?>" class="vcw-list-webex-title-link"><h3><?php the_title(); ?></h3></a>
        <div class="vcw-list-item-details-by">
			<?php _e( 'Event by', 'video-conferencing-webex' ); ?>: <?php echo esc_html( $vcw->hostDisplayName ); ?>
        </div>
		<?php if ( ! empty( $vcw->terms ) ) { ?>
            <div class="vcw-list-item-details-terms">
				<?php echo esc_html( implode( ',', $vcw->terms ) ); ?>
            </div>
		<?php } ?>
        <div class="vcw-list-item-details-excerpt">
			<?php echo get_the_excerpt(); ?>
        </div>
    </div>
</div><!--List item end-->
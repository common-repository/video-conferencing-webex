<?php
/**
 * The Template for displaying single event details
 *
 * This template can be overridden by copying it to yourtheme/video-conferencing-webex/single-event/content.php
 *
 * @package    Video Conferencing via Webex/Templates
 * @version     1.0.0
 * @since       1.0.0
 */
?>

<?php if ( has_post_thumbnail() ) { ?>
    <div class="vcw-single-featured-img">
		<?php the_post_thumbnail(); ?>
    </div>
<?php } ?>

<div class="vcw-single-description">
	<?php the_content(); ?>
</div>
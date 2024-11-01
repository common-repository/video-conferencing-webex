<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//wp_head();

/**
 * Trigger before the content
 */
do_action( 'vcw_before_joinViaBrowserHtml' );
?>
    <a href="javascript:void(0);" id="authenticate">Authenticate to Meeting</a>
    <div style="display: flex">
        <video style="width:50%" id="self-view" muted autoplay></video>
        <div style="width:50%">
            <audio id="remote-view-audio" autoplay></audio>
            <video id="remote-view-video" autoplay></video>
        </div>
    </div>

    <button id="hangup" title="hangup" type="button">cancel/hangup</button>

<?php
/**
 * Trigger before the content
 */
do_action( 'vcw_after_joinViaBrowserHtml' );

//wp_footer();
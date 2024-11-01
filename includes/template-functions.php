<?php
/**
 * This file contains functions that is necessary for loading components in the frontend side.
 *
 * Functional Component.
 *
 * @since 1.0.0
 * @author Deepen
 */

use Codemanas\Webex\Core\Helpers\TemplateRouter;

function vcw_event_description() {
	TemplateRouter::get_template('single-event/content.php');
}

function vcw_event_countdown_timer() {
	TemplateRouter::get_template('single-event/countdown-timer.php');
}

function vcw_event_details() {
	TemplateRouter::get_template('single-event/details.php');
}
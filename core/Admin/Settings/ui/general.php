<?php

use Codemanas\Webex\Core\Helpers\FormHelper;

echo \Codemanas\Webex\Core\Admin\Settings\Settings::get_message();

$settings = \Codemanas\Webex\Core\Helpers\Fields::get_option( 'general_settings' );
?>

<div class="vcw-card">
    <form method="post">
		<?php wp_nonce_field( 'verify_vcw_general', 'verify_vcw_general_nonce' ); ?>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label for="deleteWebexMeetings"><?php _e( "Keep Webex Meetings?", "video-conferencing-webex" ); ?></label></th>
                <td>
					<?php
					FormHelper::fields(
						'keepWebexMeetings',
						[
							'type' => 'checkbox'
						],
						! empty( $settings['keepWebexMeetings'] ) ? 1 : ''
					);
					?>
                    <span><?php _e( "Enabling this option will not delete your meetings on your webex account. System will only delete it on this site.", "video-conferencing-webex" ); ?></span>
                </td>
            </tr>
            </tbody>
        </table>
        <p class="submit"><input type="submit" name="save_vcw_general" id="submit" class="button button-primary" value="Save Changes"></p>
    </form>
</div>
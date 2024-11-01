<?php

use Codemanas\Webex\Core\Helpers\FormHelper;

global $vcw;
wp_nonce_field( 'vcw_meeting_fields', 'vcw_meeting_fields_nonce' );
?>

<?php do_action( 'vcw_before_event_setting_fields' ); ?>
<table class="form-table" role="presentation">
    <tbody>
	<?php if ( ! empty( $vcw->api ) ) { ?>
        <tr>
            <th scope="row"><label for="start_date"><?php _e( "Shortcode", "video-conferencing-webex" ); ?></label></th>
            <td>
                <span class="dashicons dashicons-admin-page"></span> <span style="background: #f0f0f1;padding: 10px;border: 1px solid #8c8f94;border-radius: 5px;">[vcw_single_event id="<?php echo $vcw->api->id; ?>" hide_password="true"]</span>
            </td>
        </tr>
	<?php } ?>
	<?php do_action( 'vcw_inside_event_setting_first_section_top' ); ?>
    <tr>
        <th scope="row"><label for="start_date"><?php _e( "Start Date/Time *", "video-conferencing-webex" ); ?></label></th>
        <td>
			<?php
			FormHelper::fields(
				'eventStartDate',
				[
					'type'        => 'text',
					'description' => __( "Starting Date and Time of the Meeting (Required).", "video-conferencing-webex" ),
					'required'    => true
				],
				! empty( $vcw->eventSettings['start'] ) ? $vcw->eventSettings['start'] : ''
			);
			?>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="duration"><?php _e( "Duration", "video-conferencing-webex" ); ?></label></th>
        <td>
            <span style="margin-right: 5px;">
			<?php
			FormHelper::fields(
				'eventHour',
				[
					'type'       => 'select',
					'options'    => [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24 ],
					'after_html' => '&nbsp;' . __( "hours", "video-conferencing-webex" )
				],
				! empty( $vcw->eventSettings['hour'] ) ? $vcw->eventSettings['hour'] : 0
			);
			?>
            </span>
            <span>
            <?php
            FormHelper::fields(
	            'eventMinute',
	            [
		            'type'       => 'select',
		            'options'    => [ 0 => 0, 10 => 10, 15 => 15, 20 => 20, 30 => 30, 40 => 40, 45 => 45, 50 => 50 ],
		            'after_html' => '&nbsp;' . __( "minutes", "video-conferencing-webex" )
	            ],
	            ! empty( $vcw->eventSettings['minute'] ) ? $vcw->eventSettings['minute'] : 40
            );
            ?>
            </span>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="timezone"><?php _e( "Timezone", "video-conferencing-webex" ); ?></label></th>
        <td>
			<?php
			FormHelper::fields(
				'eventTimezone',
				[
					'type'    => 'select',
					'options' => $vcw->defaultTimezones,
				],
				! empty( $vcw->eventSettings['timezone'] ) ? $vcw->eventSettings['timezone'] : ''
			);
			?>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="password"><?php _e( "Password", "video-conferencing-webex" ); ?></label></th>
        <td>
			<?php
			FormHelper::fields(
				'eventPassword',
				[
					'type'      => 'text',
					'maxlength' => 10
				],
				! empty( $vcw->eventSettings['password'] ) ? $vcw->eventSettings['password'] : $vcw->post_id . 'VW'
			);
			?>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="enabledJoinBeforeHost"><?php _e( "Enable Join before Host", "video-conferencing-webex" ); ?></label></th>
        <td>
			<?php
			FormHelper::fields(
				'enabledJoinBeforeHost',
				[
					'type'        => 'checkbox',
					'description' => __( "Whether or not to allow any attendee to join the meeting before the host joins the meeting.", "video-conferencing-webex" )
				],
				! empty( $vcw->eventSettings['enabledJoinBeforeHost'] ) ? 1 : ''
			);
			?>
        </td>
    </tr>
    </tbody>
</table>
<div class="vcw-accordion-wrapper">
    <div class="vcw-accordions-container">
        <a class="vcw-accordion" href="javascript:void(0);"><?php _e( "Advanced Settings", "video-conferencing-webex" ); ?></a>
        <div class="vcw-panel">
            <table class="form-table" role="presentation">
                <tbody>
                <tr>
                    <th scope="row">
                        <label for="enabledAutoRecordMeeting"><?php _e( "Auto Record Meeting", "video-conferencing-webex" ); ?></label></th>
                    <td>
						<?php
						FormHelper::fields(
							'enabledAutoRecordMeeting',
							[
								'type'        => 'checkbox',
								'description' => __( "Whether or not meeting is recorded automatically.", "video-conferencing-webex" )
							],
							! empty( $vcw->eventSettings['enabledAutoRecordMeeting'] ) ? 1 : ''
						);
						?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="enabledBreakoutSessions"><?php _e( "Enable Breakout sessions", "video-conferencing-webex" ); ?></label></th>
                    <td>
						<?php
						FormHelper::fields(
							'enabledBreakoutSessions',
							[
								'type'        => 'checkbox',
								'description' => __( "Whether or not breakout sessions is enabled.", "video-conferencing-webex" )
							],
							! empty( $vcw->eventSettings['enabledBreakoutSessions'] ) ? 1 : ''
						);
						?>
                    </td>
                </tr>
                <!--<tr>
                    <th scope="row">
                        <label for="reminderTime"><?php /*_e( "Email Reminder", "video-conferencing-webex" ); */ ?></label></th>
                    <td>
						<?php
				/*						FormHelper::fields(
											'reminderTime',
											[
												'type'        => 'select',
												'options'     => [ 10 => 10, 15 => 15, 20 => 20, 30 => 30, 40 => 40, 45 => 45, 50 => 50 ],
												'description' => __( "The number of minutes before the meeting begins, for sending an email reminder to the host.", "video-conferencing-webex" )
											],
											! empty( $vcw->eventSettings['reminderTime'] ) ? $vcw->eventSettings['reminderTime'] : 10
										);
										*/ ?>
                    </td>
                </tr>-->
                </tbody>
            </table>
        </div>
    </div>
    <div class="vcw-accordions-container">
        <a class="vcw-accordion" href="javascript:void(0);"><?php _e( "Security", "video-conferencing-webex" ); ?></a>
        <div class="vcw-panel">
            <table class="form-table" role="presentation">
                <tbody>
                <tr>
                    <th scope="row">
                        <label for="enableAutomaticLock"><?php _e( "Automatic lock", "video-conferencing-webex" ); ?></label></th>
                    <td>
						<span style="margin-right: 5px;">
                            <?php
                            FormHelper::fields(
	                            'enableAutomaticLock',
	                            [
		                            'type'       => 'checkbox',
		                            'after_html' => '&nbsp;' . __( "automatically lock my meeting in", "video-conferencing-webex" )
	                            ],
	                            ! empty( $vcw->eventSettings['enableAutomaticLock'] ) ? 1 : ''
                            );
                            ?>
                        </span>
                        <span>
                            <?php
                            FormHelper::fields(
	                            'automaticLockMinutes',
	                            [
		                            'type'       => 'select',
		                            'options'    => [ 0 => 0, 5 => 5, 10 => 10, 15 => 15, 20 => 20 ],
		                            'after_html' => '&nbsp;' . __( "minutes after the meeting starts.", "video-conferencing-webex" )
	                            ],
	                            ! empty( $vcw->eventSettings['automaticLockMinutes'] ) ? $vcw->eventSettings['automaticLockMinutes'] : 40
                            );
                            ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="unlockedMeetingJoinSecurity"><?php _e( 'Unlocked Meetings', 'video-conferencing-webex' ); ?></label></th>
                    <td>
                        <p><?php _e( 'Everyone in your organization can always join unlocked meetings. When the meeting is unlocked', 'video-conferencing-webex' ); ?>,</p>
						<?php
						FormHelper::fields(
							'unlockedMeetingJoinSecurity',
							[
								'type'    => 'radio',
								'options' => [
									'allowJoin'          => __( "Guests can join the meeting", "video-conferencing-webex" ),
									'allowJoinWithLobby' => __( "Guests wait in the lobby until the hosts admits them", "video-conferencing-webex" ),
									'blockFromJoin'      => __( "Guests can't join the meeting", "video-conferencing-webex" ),
								],
							],
							! empty( $vcw->eventSettings['unlockedMeetingJoinSecurity'] ) ? $vcw->eventSettings['unlockedMeetingJoinSecurity'] : 'allowJoinWithLobby'
						);
						?>
                        <p class="description"><?php _e( "You can choose what happens when guests join unlocked meetings. Guests are users who haven't signed in to their Webex accounts on this site, external users who don't have Webex accounts on this site, external video systems that aren't registered to this organization, and audio-only users who haven't signed in with an audio PIN.", "video-conferencing-webex" ); ?></p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php do_action( 'vcw_after_event_setting_fields' ); ?>
<?php
//Object of API Class
global $vcw;

use Codemanas\Webex\Core\Helpers\FormHelper;

echo \Codemanas\Webex\Core\Admin\Settings\Settings::get_message();

if ( ! empty( $vcw->api->errors ) ) {
	?>
  <div class="error">
	  <?php
	  foreach ( $vcw->api->errors->errors as $error ) {
		  echo '<p>' . $error->description . '</p>';
	  }
	  ?>
  </div>
	<?php
}
?>

<div class="vcw-card">
	<?php
	if ( ! empty( $vcw->api->accessTokenData ) && ! empty( $vcw->api->accessTokenData->access_token ) && ! empty( $vcw->api->currentUserInfo ) ) {
		$info = $vcw->api->currentUserInfo;

		if ( \Codemanas\Webex\Core\Helpers\Helper::checkAdminPriviledge() ) {
			?>
          <a href="<?php echo esc_url( $vcw->api->verified_uri . '&revoke=true' ); ?>" class="button vcw-authenticate-btn"><?php _e( "Disconnect your Webex Account", "video-conferencing-webex" ); ?></a>
		<?php } else if ( ! empty( $vcw->settings ) && empty( $vcw->settings['useMasterAccount'] ) ) { ?>
          <a href="<?php echo esc_url( $vcw->api->verified_uri . '&revoke=true' ); ?>" class="button vcw-authenticate-btn"><?php _e( "Disconnect your Webex Account", "video-conferencing-webex" ); ?></a>
		<?php } ?>

      <div class="vcw-connected-accounts-wrapper">
        <h3><?php _e( "Connected Account", "video-conferencing-webex" ); ?>:</h3>
        <ul>
          <li><strong><?php _e( "Name", "video-conferencing-webex" ); ?>:</strong> <?php echo esc_html( $info->firstName ) . ' ' . esc_html( $info->lastName ); ?></li>
          <li><strong><?php _e( "Email", "video-conferencing-webex" ); ?>:</strong> <?php echo esc_html( $info->emails[0] ); ?></li>
          <li><strong><?php _e( "Individual Accounts", "video-conferencing-webex" ); ?>?</strong> <?php echo ! empty( $vcw->settings ) && ! empty( $vcw->settings['useMasterAccount'] ) ? 'No' : 'Yes'; ?></li>
        </ul>
      </div>
	<?php } else { ?>
      <form method="post" id="vcw-save-connection-form">
		  <?php wp_nonce_field( 'verify_vcw_connect', 'verify_vcw_connect_nonce' ); ?>
        <table class="form-table">
          <tbody>
          <tr>
            <th scope="row"><label for="connect"><?php _e( "Source", "video-conferencing-webex" ); ?></label></th>
            <td>
              <input type="submit" name="save_vcw_settings" data-loading="<?php _e( "Connecting to Webex.. Please Wait..", "video-conferencing-webex" ); ?>" id="submit" class="button vcw-authenticate-btn" value="<?php _e( "Connect Webex Account", "video-conferencing-webex" ); ?>">
            </td>
          </tr>
		  <?php if ( \Codemanas\Webex\Core\Helpers\Helper::checkAdminPriviledge() ) { ?>
            <tr>
              <th scope="row"><label for="useAsMasterAccount"><?php _e( "Use one account for all ?", "video-conferencing-webex" ); ?></label></th>
              <td>
				  <?php
				  FormHelper::fields(
					  'useAsMasterAccount',
					  [
						  'type'       => 'checkbox',
						  'after_html' => __( "If this option is checked all users will use this connected Webex account for all meetings. By default this is set to individual accounts..", "video-conferencing-webex" ),
					  ],
					  ! empty( $vcw->settings['useMasterAccount'] ) ? 1 : ''
				  );
				  ?>
              </td>
            </tr>
		  <?php } ?>
          <tr>
            <th scope="row"><label for="connect"><?php _e( "Connect Manully?", "video-conferencing-webex" ); ?></label></th>
            <td>
				<?php
				FormHelper::fields(
					'useManualAuthentication',
					[
						'id'         => 'vcw-manually-connect-account',
						'type'       => 'checkbox',
						'after_html' => __( "When checked, you can connect with your own webex API credentials.", "video-conferencing-webex" ),
					],
					! empty( $vcw->settings['useManualAuthentication'] ) ? 1 : ''
				);
				?>
            </td>
          </tr>
          <tr class="show-only-manual-account-click" <?php echo ! empty( $vcw->settings['useManualAuthentication'] ) ? 'style=display:table-row' : 'style=display:none'; ?>>
            <th scope="row"><label for="client_id"><?php _e( "Client ID", "video-conferencing-webex" ); ?></label></th>
            <td>
				<?php
				FormHelper::fields(
					'client_id',
					[
						'type'     => 'password',
						'required' => true,
						'id'       => 'vcwapi-client-id'
					],
					! empty( $vcw->settings['useManualAuthentication'] ) && ! empty( $vcw->api->getClient() ) ? $vcw->api->getClient() : ''
				);
				?>
              <p class="description"><a href="https://codemanas.github.io/video-conferencing-webex-docs/manual-setup/" target="_blank"><?php _e( "See how you can get your API Client ID", "video-conferencing-webex" ); ?></a></p>
            </td>
          </tr>
          <tr class="show-only-manual-account-click" <?php echo ! empty( $vcw->settings['useManualAuthentication'] ) ? 'style=display:table-row' : 'style=display:none'; ?>>
            <th scope="row"><label for="client_secret"><?php _e( "Client Secret", "video-conferencing-webex" ); ?></label></th>
            <td>
				<?php
				FormHelper::fields(
					'client_secret',
					[
						'type'     => 'password',
						'required' => true,
						'id'       => 'vcwapi-client-secret'
					],
					! empty( $vcw->settings['useManualAuthentication'] ) && ! empty( $vcw->api->getSecret() ) ? $vcw->api->getSecret() : ''
				);
				?>
              <p class="description"><a href="https://codemanas.github.io/video-conferencing-webex-docs/manual-setup/" target="_blank"><?php _e( "See how you can get your API Client Secret", "video-conferencing-webex" ); ?></a></p>
            </td>
          </tr>
          </tbody>
        </table>
      </form>
		<?php
	}
	?>
</div>

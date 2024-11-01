<div class="vcw-filter-options">
    <div class="vcw-flex-wrapper">
        <div class="vcw-flexing">
			<?php _e( "Showing results from", "video-conferencing-webex" ); ?>:
        </div>
        <div class="vcw-flexing">
            <input type="text" placeholder="Select date range to Filter.." data-input id="datepicker-recordings" class="regular-text">
        </div>
    </div>
</div>
<table id="vcw-admin-recordings-table" class="hover wp-list-table widefat fixed striped table-view-list">
    <thead>
    <tr>
        <th><?php _e( 'Name', 'video-conferencing-webex' ); ?></th>
        <th><?php _e( 'Date Created', 'video-conferencing-webex' ); ?></th>
        <th><?php _e( 'Duration', 'video-conferencing-webex' ); ?></th>
        <th><?php _e( 'Size', 'video-conferencing-webex' ); ?></th>
        <th><?php _e( 'Format', 'video-conferencing-webex' ); ?></th>
        <th><?php _e( 'Download', 'video-conferencing-webex' ); ?></th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div class="wrap">
    <h2><?php echo get_admin_page_title(); ?></h2>
    <div class="vcw-notifications"></div>

    <div class="vcw-filter-options">
        <div class="vcw-flex-wrapper">
            <div class="vcw-flexing">
				<?php _e( "Showing results from", "video-conferencing-webex" ); ?>:
            </div>
            <div class="vcw-flexing">
                <input type="text" placeholder="Select date range to Filter.." data-input id="datepicker" class="regular-text">
            </div>
        </div>
    </div>
    <table id="vcw-admin-importer-table" class="hover wp-list-table widefat fixed striped table-view-list vcw-admin-importer-table">
        <thead>
        <tr>
            <th><?php _e( "Meeting ID", "video-conferencing-webex" ); ?></th>
            <th><?php _e( "Topic", "video-conferencing-webex" ); ?></th>
            <th><?php _e( "Start", "video-conferencing-webex" ); ?></th>
            <th><?php _e( "Action", "video-conferencing-webex" ); ?></th>
        </tr>
        </thead>
    </table>
</div>
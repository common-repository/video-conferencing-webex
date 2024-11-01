let table = new DataTable('#vcw-admin-users-table', {
    ajax: ajaxurl + '?action=vcw-get-users',
    columns: [
        {data: 'firstName'},
        {data: 'lastName'},
        {data: 'email'},
        {data: 'createdOn'}
    ],
});
$(document).ready(function () {

    // Generate the responsive and dynamic table
    var supplier_table = $("#supplier-table").DataTable({
        // Set the number of records per page
        "pageLength": 10,

        // Make the table responsive
        "responsive": true,

        // Hide the first column
        "columnDefs": [{
            "targets": [0],
            "visible": false
        }],

        // Generate buttons
        "dom": 'B<"d-flex justify-content-between mt-3"lf>rtip',
        buttons: [
            {
                extend: 'colvis',
                text: 'Show/Hide Columns',
            }
        ],

        // Get the data from the server
        "ajax": {
            "url": base_url('ajax/ajax_get_suppliers'),
        },

        // Define the columns
        "columnDefs": [{
            // Column 1 - id
            "targets": 0,
            'data': 'id',
            'visible': false
        },
        {
            // Column 2 - supplier name
            "targets": 1,
            'data': 'name',
        },
        {
            // Column 3 - supplier address
            "targets": 2,
            'data': 'address',
        },
        {
            // Column 4 - supplier mobile
            "targets": 3,
            'data': 'mobile',
        },
        {
            // Column 5 - options
            "targets": 4,
            'data': null,
            "render": function (data, type, row) {
                // Generate the edit and delete buttons
                let html = '';
                html += `<button id="edit" class="btn btn-primary btn-sm m-1">Edit</button>`
                html += `<button id="delete" class="btn btn-danger btn-sm m-1">Delete</button>`
                return html;
            }
        }
        ],

        // Row callback to attach event listeners to the edit and delete buttons
        "rowCallback": function (row, data, dataIndex) {

            // Attach an event listener to the delete button
            $('button#delete', row).click(function () {
                // Check if the user is sure they want to delete the supplier
                if (confirm('Are you sure you want to delete ' + data.name + '?')) {
                    // Set the supplier id in the delete form
                    $('form#supplier-delete-form input#supplier_id').val(data.id);
                    // Submit the delete form
                    $('form#supplier-delete-form').unbind('submit').submit();
                }
            });

            // Attach an event listener to the edit button
            $('button#edit', row).click(function () {
                // Set the supplier id in the add/update form
                $('form#supplier-add-update-form input#supplier_id').val(data.id);
                // Set the supplier name, mobile, and address in the add/update form
                $('form#supplier-add-update-form input#name').val(data.name);
                $('form#supplier-add-update-form input#mobile').val(data.mobile);
                $('form#supplier-add-update-form input#address').val(data.address);
                // Focus on the supplier name input field
                $('form#supplier-add-update-form input#name').focus();
                // Set the button text and class
                $('form#supplier-add-update-form button#submit').text('Update Supplier').removeClass('btn-primary').addClass('btn-danger');
            });
        }
    });

});

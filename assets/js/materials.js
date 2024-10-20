$(document).ready(function () {

    // generate the reponsive and dynamic table 
    var supplier_table = $("#materials-table").DataTable({
        // number of records per page
        "pageLength": 10,

        // make the table responsive
        "responsive": true,

        // hide the first column
        "columnDefs": [{
            "targets": [0],
            "visible": false
        }],

        order: [
            [0, 'desc']
        ],

        // generate buttons
        "dom": 'B<"d-flex justify-content-between mt-3"lf>rtip',
        buttons: [
            {
                extend: 'colvis',
                text: 'Show/Hide Columns',
            }
        ],

        // get the data from the server
        "ajax": {
            "url": base_url('ajax/ajax_get_materials'),
        },

        // define the columns
        "columnDefs": [{
            // column 1 - id
            "targets": 0,
            'data': 'id',
            'visible': false
        },
        {
            // column 2 - supplier id
            "targets": 1,
            'data': 'supplier_id',
            'visible': false
        },
        {
            // column 3 - supplier name
            "targets": 2,
            'data': 'supplier_name',
        },
        {
            // column 4 - material
            "targets": 3,
            'data': 'material',
        },
        {
            // column 5 - price
            "targets": 4,
            'data': 'price',
            "render": function (data, type, row) {
                // format the price
                data = parseFloat(data);
                return '₱' + data.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        {
            // column 4 - stock
            "targets": 5,
            'data': 'quantity',
        },
        {
            // column 5 - options
            "targets": 6,
            'data': null,
            "render": function (data, type, row) {
                let html = '';
                html += `<button id="edit" class="btn btn-primary btn-sm m-1">Edit</button>`
                html += `<button id="delete" class="btn btn-danger btn-sm m-1">Delete</button>`
                return html;
            }
        }],
        "rowCallback": function (row, data, dataIndex) {

            // edit button
            $('button#edit', row).click(function () {
                $('form#material-add-update-form input#material_id').val(data.id);
                $('form#material-add-update-form select#supplier_id').val(data.supplier_id);
                $('form#material-add-update-form input#material').val(data.material);
                $('form#material-add-update-form input#price').val(data.price);
                $('form#material-add-update-form input#additional_price').val(data.additional_price);
                $('form#material-add-update-form input#quantity').val(data.quantity);
                $('form#material-add-update-form input#material').focus();
                $('form#material-add-update-form button#submit').text('Update Material').removeClass('btn-primary').addClass('btn-danger');
            });

            // delete button
            $('button#delete', row).click(function () {
                if (confirm('Are you sure you want to delete ' + data.material + '?')) {
                    $('form#material-delete-form input#material_id').val(data.id);
                    $('form#material-delete-form').unbind('submit').submit();
                }
            });
        }
    });






    var product_tables = $("#products-table").DataTable({
        // show 10 records per page
        "pageLength": 10,

        // make the table responsive
        "responsive": true,

        // sort by column
        order: [
            [0, 'desc']
        ],

        // generate buttons
        "dom": 'B<"d-flex justify-content-between mt-3"lf>rtip',
        buttons: [
            {
                extend: 'colvis',
                text: 'Show/Hide Columns',
            }
        ],

        // get the data from the server
        "ajax": {
            "url": base_url('ajax/ajax_get_products'),
        },

        // define the columns
        "columnDefs": [{
            "targets": 0,
            'data': 'id',
        }, {
            "targets": 1,
            'data': 'name',
        }, {
            "targets": 2,
            'data': 'price',
            "render": function (data, type, row) {
                // format the price
                data = parseFloat(data);
                return '₱' + data.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

        }, {
            "targets": 3,
            'data': 'quantity',
        }, {
            "targets": 4,
            'data': 'date_added',
            "render": function (data, type, row) {
                return moment(data).format('MMM D, YYYY');
            }
        },
        {
            "targets": 5,
            'data': null,
            "render": function (data, type, row) {
                // generate the edit button
                let html = '';
                html += `<button id="edit" class="btn btn-primary btn-sm m-1">Edit</button>`
                html += `<button id="delete" class="btn btn-danger btn-sm m-1">Delete</button>`
                return html;
            }
        }],
        "rowCallback": function (row, data, dataIndex) {

            // edit button
            $('button#edit', row).click(function () {
                debugger
                $('form#product-add-update-form input#product_id').val(data.id);
                $('form#product-add-update-form input#product_name').val(data.name);
                $('form#product-add-update-form input#product_price').val(data.price);
                $('form#product-add-update-form input#product_quantity').val(data.quantity);
                $('form#product-add-update-form button#submit').text('Update Product').removeClass('btn-primary').addClass('btn-danger');
            });

            // delete button
            $('button#delete', row).click(function () {
                debugger
                if (confirm('Are you sure you want to delete ' + data.name + '?')) {
                    $('form#product-delete-form input#product_id').val(data.id);
                    $('form#product-delete-form').unbind('submit').submit();
                }
            });
        }
    })


});

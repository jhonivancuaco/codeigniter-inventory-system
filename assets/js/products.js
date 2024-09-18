$(document).ready(function () {

    // generate the reponsive and dynamic table 
    var supplier_table = $("#product-table").DataTable({
        // number of records per page
        "pageLength": 10,

        // make the table responsive
        "responsive": true,

        // hide the first column
        "columnDefs": [{
            "targets": [0],
            "visible": false
        }],

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
            // column 6 - additional price
            "targets": 5,
            'data': 'additional_price',
            "render": function (data, type, row) {
                // format the additional price
                data = parseFloat(data);
                return '₱' + data.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        {
            // column 7 - total price
            "targets": 6,
            'data': 'total_price',
            "render": function (data, type, row) {
                // calculate the total price by adding the price and additional price
                data = parseFloat(data.price + data.additional_price);
                return '₱' + data.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        {
            // column 8 - quantity
            "targets": 7,
            'data': 'quantity',
        },
        {
            // column 9 - stock
            "targets": 8,
            'data': 'stock',
        },
        {
            // column 10 - sold
            "targets": 9,
            'data': 'sold',
        },
        {
            // column 11 - amount purchased
            "targets": 10,
            'data': 'amount_purchased',
            "render": function (data, type, row) {
                // format the amount purchased
                data = parseFloat(data);
                return '₱' + data.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        {
            // column 12 - options
            "targets": 11,
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
                $('form#product-add-update-form input#product_id').val(data.id);
                $('form#product-add-update-form select#supplier_id').val(data.supplier_id);
                $('form#product-add-update-form input#material').val(data.material);
                $('form#product-add-update-form input#price').val(data.price);
                $('form#product-add-update-form input#quantity').val(data.quantity);
                $('form#product-add-update-form input#material').focus();
                $('form#product-add-update-form button#submit').text('Update Product').removeClass('btn-primary').addClass('btn-danger');
            });

            // delete button
            $('button#delete', row).click(function () {
                if (confirm('Are you sure you want to delete ' + data.material + '?')) {
                    $('form#product-delete-form input#product_id').val(data.id);
                    $('form#product-delete-form').unbind('submit').submit();
                }
            });
        }
    });

});

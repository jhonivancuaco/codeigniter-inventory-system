$(document).ready(function () {

    // generate the reponsive and dynamic table 
    var supplier_table = $("#transactions-table").DataTable({
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
            "url": base_url('ajax/ajax_get_transactions'),
        },

        // define the columns
        "columnDefs": [
            // column 1
            {
                "targets": 0,
                'data': 'id',
                'visible': false
            },

            // column 2
            {
                "targets": 1,
                'data': 'product_id',
            },

            // column 3
            {
                "targets": 2,
                'data': 'product_name',
            },

            // column 4
            {
                "targets": 3,
                'data': 'transaction_id',
            },

            // column 5
            {
                "targets": 4,
                'data': 'name',
            },

            // column 6
            {
                "targets": 5,
                'data': 'address',
            },

            // column 7
            {
                "targets": 6,
                'data': 'mobile',
            },

            // column 8
            {
                "targets": 7,
                'data': 'quantity',
            },

            // column 9
            {
                "targets": 8,
                'data': null,
                "render": function (data, type, row) {
                    // calculate the total price by multiplying the price and quantity
                    data = parseFloat(data.product_price * data.quantity);
                    // return the total price with comma separators
                    return '₱' + data.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },

            // column 10
            {
                "targets": 9,
                'data': 'mode_of_payment',
            },

            // column 11
            {
                "targets": 10,
                'data': 'status',
            },

            // column 12
            {
                "targets": 11,
                'data': 'date_purchased',
                'visible': false,
                "render": function (data, type, row) {
                    // return the date purchased in MMM D, YYYY format
                    return moment(data).format('MMM D, YYYY');
                }
            },

            // column 13
            {
                "targets": 12,
                'data': 'date_delivered',
                "render": function (data, type, row) {
                    // if the date delivered is null, return N/A
                    if (data == null) {
                        return 'N/A';
                    }
                    // else return the date delivered in MMM D, YYYY format
                    else {
                        return moment(data).format('MMM D, YYYY');
                    }
                }
            },

            // column 14
            {
                "targets": 13,
                'data': null,
                "render": function (data, type, row) {
                    // generate the edit button
                    let html = '';
                    html += `<button id="edit" class="btn btn-primary btn-sm m-1">Edit</button>`
                    return html;
                }
            }
        ],

        // callback function when the row is rendered
        "rowCallback": function (row, data) {
            // add event listener to the edit button
            $('button#edit', row).click(function () {
                // get the order id
                $('form#order-add-update-form input#order_id').val(data.id);
                // get the product id
                $('form#order-add-update-form select#product_id').val(data.product_id);
                // get the transaction id
                $('form#order-add-update-form input#transaction_id').val(data.transaction_id);
                // get the date purchased
                $('form#order-add-update-form input#date_purchased').val(moment(data.date_purchased).format('MM/DD/YYYY'));
                // get the date delivered
                $('form#order-add-update-form input#date_delivered').val(data.date_delivered == null ? '' : moment(data.date_delivered).format('MM/DD/YYYY'));
                // get the name
                $('form#order-add-update-form input#name').val(data.name);
                // get the mobile
                $('form#order-add-update-form input#mobile').val(data.mobile);
                // get the address
                $('form#order-add-update-form input#address').val(data.address);
                // get the mode of payment
                $('form#order-add-update-form select#mode_of_payment').val(data.mode_of_payment);
                // get the status
                $('form#order-add-update-form select#status').val(data.status);
                // get the quantity
                $('form#order-add-update-form input#quantity').val(data.quantity);
                // focus the date purchased input
                $('form#order-add-update-form input#date_purchased').focus();
                // change the submit button text to Update Product and change the class to btn-danger
                $('form#order-add-update-form button#submit').text('Update Product').removeClass('btn-primary').addClass('btn-danger');
            });
        }
    });
});

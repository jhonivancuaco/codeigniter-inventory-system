$(document).ready(function () {

    // generate the reponsive and dynamic table 
    var supplier_table = $("#order-table").DataTable({
        // show 10 records per page
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
            "url": base_url('ajax/ajax_get_orders'),
        },

        // define the columns
        "columnDefs": [
            // column 1 - id
            {
                "targets": 0,
                'data': 'id',
                'visible': false
            },

            // column 2 - transaction id
            {
                "targets": 1,
                'data': 'transaction_id',
            },

            // column 3 - name
            {
                "targets": 2,
                'data': 'name',
            },

            // column 4 - address
            {
                "targets": 3,
                'data': 'address',
            },

            // column 5 - mobile
            {
                "targets": 4,
                'data': 'mobile',
            },

            // column 6 - product name
            {
                "targets": 5,
                'data': 'product_name',
            },

            // column 7 - quantity
            {
                "targets": 6,
                'data': 'quantity',
            },

            // column 8 - total price
            {
                "targets": 7,
                'data': null,
                "render": function (data, type, row) {
                    // calculate the total price by multiplying the price and quantity
                    data = parseFloat(data.product_price * data.quantity);
                    // return the total price with comma separators
                    return '₱' + data.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },

            // column 9 - mode of payment
            {
                "targets": 8,
                'data': 'mode_of_payment',
            },

            // column 10 - status
            {
                "targets": 9,
                'data': 'status',
            },

            // column 11 - date purchased
            {
                "targets": 10,
                'data': 'date_purchased',
                'visible': false,
                "render": function (data, type, row) {
                    // return the date purchased in MMM D, YYYY format
                    return moment(data).format('MMM D, YYYY');
                }
            },

            // column 12 - date delivered
            {
                "targets": 11,
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

            // column 13 - edit button
            {
                "targets": 12,
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

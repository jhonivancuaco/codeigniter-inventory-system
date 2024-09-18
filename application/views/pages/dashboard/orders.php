<div class="container-fluid">

    <?php if ($this->session->flashdata('order_success')): ?>
        <div class="alert alert-primary text-center">
            <?php echo $this->session->flashdata('order_success') ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('order_failed')): ?>
        <div class="alert alert-primary text-center">
            <?php echo $this->session->flashdata('order_failed') ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <table id="order-table" class="table table-striped small text-center w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Transaction ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Mobile</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Mode of Payment</th>
                        <th>Status</th>
                        <th>Date Purchased</th>
                        <th>Date Delivered</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>


    <div class="card">
        <div class="card-body">

            <h4>Orders</h4>

            <hr>

            <?php echo form_open(site_url("dashboard/orders"), ['id' => 'order-add-update-form']); ?>

            <input type="hidden" name="order_id" id="order_id" value="<?php echo set_value('order_id'); ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_id">Product</label>
                        <select class="form-control" name="product_id" id="product_id">
                            <option value="0" selected disabled>Select Product</option>
                            <?php foreach ($products as $product) : ?>
                                <option value="<?php echo $product->id; ?>" <?php echo set_select('product_id', $product->id); ?>>
                                    <?php echo $product->material; ?> - Supplier: <?php echo $product->supplier_name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('product_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="transaction_id">Transcation ID</label>
                        <input type="text" class="form-control" name="transaction_id" id="transaction_id" placeholder="Transaction ID" value="<?php echo set_value('transaction_id') ? set_value('transaction_id') : random_int(1000000000, 9999999999) . time(); ?>">
                        <?php echo form_error('transaction_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date_purchased">Date Purchased</label>
                        <div class="input-group date" id="reservationdatetime-purchased" data-target-input="nearest">
                            <input type="text" id="date_purchased" name="date_purchased" class="form-control datetimepicker-input" data-target="#reservationdatetime-purchased" value="<?php echo set_value('date_purchased') ?>" />
                            <div class=" input-group-append" data-target="#reservationdatetime-purchased" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        <?php echo form_error('date_purchased', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date_delivered">Date or Expected Date Delivered</label>
                        <div class="input-group date" id="reservationdatetime-delivered" data-target-input="nearest">
                            <input type="text" id="date_delivered" name="date_delivered" class="form-control datetimepicker-input" data-target="#reservationdatetime-delivered" value="<?php echo set_value('date_delivered') ?>" />
                            <div class="input-group-append" data-target="#reservationdatetime-delivered" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Customer Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo set_value('name'); ?>">
                        <?php echo form_error('name', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mobile">Customer Contact</label>
                        <input type="number" class="form-control" name="mobile" id="mobile" placeholder="Mobile" value="<?php echo set_value('mobile'); ?>">
                        <?php echo form_error('mobile', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Customer Address</label>
                <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?php echo set_value('address'); ?>">
                <?php echo form_error('address', '<small class="text-danger">', '</small>'); ?>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mode_of_payment">Mode of Payment</label>
                        <select name="mode_of_payment" id="mode_of_payment" class="form-control">
                            <option value="" <?php echo set_select('mode_of_payment', '', TRUE); ?> disabled>Select Mode of Payment</option>
                            <option value="Over-the-Counter" <?php echo set_select('mode_of_payment', 'Over-the-Counter'); ?>>Over-the-Counter</option>
                            <option value="Cash On Delivery" <?php echo set_select('mode_of_payment', 'Cash On Delivery'); ?>>Cash On Delivery</option>
                            <option value="Bank Transfer" <?php echo set_select('mode_of_payment', 'Bank Transfer'); ?>>Bank Transfer</option>
                            <option value="GCash" <?php echo set_select('mode_of_payment', 'GCash'); ?>>GCash</option>
                            <option value="PayMaya" <?php echo set_select('mode_of_payment', 'PayMaya'); ?>>PayMaya</option>
                            <option value="Other" <?php echo set_select('mode_of_payment', 'Other'); ?>>Other</option>
                        </select>
                        <?php echo form_error('mode_of_payment', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="" selected disabled>Select Status</option>
                            <option value="Completed" <?php echo set_select('status', 'Completed'); ?>>Completed</option>
                            <option value="Pending" <?php echo set_select('status', 'Pending'); ?>>Pending</option>
                            <option value="Returned" <?php echo set_select('status', 'Returned'); ?>>Returned</option>
                            <option value="Cancelled" <?php echo set_select('status', 'Cancelled'); ?>>Cancelled</option>
                        </select>
                        <?php echo form_error('status', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" min="1" name="quantity" id="quantity" placeholder="quantity" value="<?php echo set_value('quantity'); ?>">
                        <?php echo form_error('quantity', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
            </div>

            <button type="submit" id="submit" class="btn btn-primary float-right">
                <?php echo set_value('order_id') ? 'Update Order' : 'Add New Order' ?>
            </button>


            <?php echo form_close(); ?>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Format the dates for the datepicker in MM/DD/YYYY format (date only)
        let purchasedDate = '<?php echo set_value('date_purchased') ? date("m/d/Y", strtotime(set_value('date_purchased'))) : date("m/d/Y"); ?>';
        let deliveredDate = '<?php echo set_value('date_delivered') ? date("m/d/Y", strtotime(set_value('date_delivered'))) : date("m/d/Y"); ?>';

        $('#reservationdatetime-purchased').find('input').val(purchasedDate);
        $('#reservationdatetime-delivered').find('input').val(deliveredDate);

        // Initialize the datepickers for the purchase date (date only)
        $('#reservationdatetime-purchased').daterangepicker({
            singleDatePicker: true,
            timePicker: false, // No time picker
            minDate: new Date(),
            locale: {
                format: 'MM/DD/YYYY' // Date format without time
            }
        }, function(start) {
            // When date is selected, update the input field
            debugger
            $('#reservationdatetime-purchased').find('input').val(start.format('MM/DD/YYYY'));
        });

        // Initialize the datepickers for the delivery date (date only)
        $('#reservationdatetime-delivered').daterangepicker({
            singleDatePicker: true,
            timePicker: false, // No time picker
            minDate: new Date(),
            locale: {
                format: 'MM/DD/YYYY' // Date format without time
            },
            startDate: deliveredDate
        }, function(start) {
            // When date is selected, update the input field
            $('#reservationdatetime-delivered').find('input').val(start.format('MM/DD/YYYY'));
        });
    });
</script>
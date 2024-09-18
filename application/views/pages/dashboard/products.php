<div class="container-fluid">

    <!-- Display success message -->
    <?php if ($this->session->flashdata('product_success')) : ?>
        <div class="alert alert-primary text-center">
            <?php echo $this->session->flashdata('product_success') ?>
        </div>
    <?php endif ?>

    <!-- Display failure message -->
    <?php if ($this->session->flashdata('product_failed')) : ?>
        <div class="alert alert-danger text-center">
            <?php echo $this->session->flashdata('product_failed') ?>
        </div>
    <?php endif ?>

    <div class="card">
        <div class="card-body">
            <table id="product-table" class="table table-striped w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Supplier ID</th>
                        <th>Supplier</th>
                        <th>Material</th>
                        <th>Price</th>
                        <th>Additional Price</th>
                        <th>Total Price</th>
                        <th>Quantity</th>
                        <th>Available</th>
                        <th>Sold</th>
                        <th>Amount Purchased</th>
                        <th>Options</th>
                    </tr>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4>Products</h4>

            <hr>

            <?php echo form_open(site_url("dashboard/products"), ['id' => 'product-add-update-form']); ?>

            <?php echo form_hidden('product_action', 'add_update'); ?>
            <input type="hidden" name="product_id" id="product_id" value="<?php echo set_value('product_id'); ?>">

            <div class="form-group">
                <label for="supplier_id">Suppliers</label>
                <select class="form-control" name="supplier_id" id="supplier_id">
                    <option value="0" selected disabled>Select Supplier</option>

                    <?php foreach ($suppliers as $supplier) : ?>
                        <option value="<?php echo $supplier->id; ?>" <?php echo set_select('supplier_id', $supplier->id); ?>><?php echo $supplier->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('supplier_id', '<small class="text-danger">', '</small>'); ?>
            </div>

            <div class="form-group">
                <label for="material">Product Name</label>
                <input type="text" class="form-control" name="material" id="material" placeholder="Product Name" value="<?php echo set_value('material'); ?>">
                <?php echo form_error('material', '<small class="text-danger">', '</small>'); ?>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" min="1" class="form-control" name="price" id="price" placeholder="Price" value="<?php echo set_value('price'); ?>">
                        <?php echo form_error('price', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="additional_price">Additional Price</label>
                        <input type="number" min="1" class="form-control" name="additional_price" id="additional_price" placeholder="Price" value="<?php echo set_value('additional_price'); ?>">
                        <?php echo form_error('additional_price', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" min="1" class="form-control" name="quantity" id="quantity" placeholder="Quantity" value="<?php echo set_value('quantity'); ?>">
                        <?php echo form_error('quantity', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
            </div>


            <button type="submit" id="submit" class="btn btn-primary float-right <?php echo set_value('product_id') ? 'btn-danger' : 'btn-primary'; ?>">
                <?php echo set_value('product_id') ? 'Update Product' : 'Add New Product'; ?>
            </button>

            <?php echo form_close(); ?>
        </div>
    </div>

    <!-- Product Delete Form Section -->
    <div class="card d-none">
        <div class="card-body">
            <?php echo form_open(base_url('dashboard/products'), ['id' => 'product-delete-form']); ?>
            <?php echo form_hidden('product_action', 'delete'); ?>
            <input type="hidden" name="product_id" id="product_id">
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
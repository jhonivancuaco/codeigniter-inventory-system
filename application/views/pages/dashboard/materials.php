<div class="container-fluid">

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <!-- Display success message -->
    <?php if ($this->session->flashdata('material_success')) : ?>
        <div class="alert alert-primary text-center">
            <?php echo $this->session->flashdata('material_success') ?>
        </div>
    <?php endif ?>

    <!-- Display failure message -->
    <?php if ($this->session->flashdata('material_failed')) : ?>
        <div class="alert alert-danger text-center">
            <?php echo $this->session->flashdata('material_failed') ?>
        </div>
    <?php endif ?>

    <div class="card">
        <div class="card-body">
            <h4>Materials Information</h4>

            <table id="materials-table" class="table table-striped w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Supplier ID</th>
                        <th>Supplier</th>
                        <th>Material</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Options</th>
                    </tr>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4>Materials</h4>

            <hr>

            <?php echo form_open(site_url("dashboard/materials"), ['id' => 'material-add-update-form']); ?>

            <?php echo form_hidden('material_action', 'add_update_material'); ?>
            <input type="hidden" name="material_id" id="material_id" value="<?php echo set_value('material_id'); ?>">

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
                <label for="material">Material Name</label>
                <input type="text" class="form-control" name="material" id="material" placeholder="Product Name" value="<?php echo set_value('material'); ?>">
                <?php echo form_error('material', '<small class="text-danger">', '</small>'); ?>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" min="1" class="form-control" name="price" id="price" placeholder="Price" value="<?php echo set_value('price'); ?>">
                        <?php echo form_error('price', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" min="1" class="form-control" name="quantity" id="quantity" placeholder="Quantity" value="<?php echo set_value('quantity'); ?>">
                        <?php echo form_error('quantity', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
            </div>


            <button type="submit" id="submit" class="btn btn-primary float-right <?php echo set_value('material_id') ? 'btn-danger' : 'btn-primary'; ?>">
                <?php echo set_value('material_id') ? 'Update Material' : 'Add New Material'; ?>
            </button>

            <?php echo form_close(); ?>
        </div>
    </div>

    <!-- Material Delete Form Section -->
    <div class="card d-none">
        <div class="card-body">
            <?php echo form_open(base_url('dashboard/materials'), ['id' => 'material-delete-form']); ?>
            <?php echo form_hidden('material_action', 'delete_material'); ?>
            <input type="hidden" name="material_id" id="material_id">
            <?php echo form_close(); ?>
        </div>
    </div>







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
            <h4>Products Information</h4>

            <table id="products-table" class="table table-striped w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Date Added</th>
                        <th>Options</th>
                    </tr>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4>Products</h4>

            <?php echo form_open(site_url("dashboard/materials"), ['id' => 'product-add-update-form']) ?>

            <?php echo form_hidden('product_action', 'add_update_product'); ?>
            <input type="hidden" name="product_id" id="product_id" value="<?php echo set_value('product_id'); ?>">

            <div class="form-group">
                <label for="product_name">Name</label>
                <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name" value="<?php echo set_value('product_name'); ?>">
                <?php echo form_error('product_name', '<small class="text-danger">', '</small>'); ?>
            </div>

            <?php if (!set_value('product_id')): ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_price">Price</label>
                            <input type="number" class="form-control" name="product_price" id="product_price" placeholder="Product Price" value="<?php echo set_value('product_price') ? set_value('product_price') : 1; ?>">
                            <?php echo form_error('product_price', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_quantity">Quantity</label>
                            <input type="number" class="form-control" name="product_quantity" id="product_quantity" placeholder="Product Quantity" value="<?php echo set_value('product_quantity') ? set_value('product_quantity') : 1; ?>">
                            <?php echo form_error('product_quantity', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="form-group">
                    <label for="product_price">Price</label>
                    <input type="number" class="form-control" name="product_price" id="product_price" placeholder="Product Price" value="<?php echo set_value('product_price') ? set_value('product_price') : 1; ?>">
                    <?php echo form_error('product_price', '<small class="text-danger">', '</small>'); ?>
                </div>
            <?php endif ?>


            <button type="submit" id="submit" class="btn btn-primary float-right <?php echo set_value('product_id') ? 'btn-danger' : 'btn-primary'; ?>">
                <?php echo set_value('product_id') ? 'Update Product' : 'Add New Product'; ?>
            </button>

            <?php echo form_close() ?>
        </div>
    </div>

    <!-- Product Delete Form Section -->
    <div class="card d-none">
        <div class="card-body">
            <?php echo form_open(base_url('dashboard/materials'), ['id' => 'product-delete-form']); ?>
            <?php echo form_hidden('product_action', 'delete_product'); ?>
            <input type="hidden" name="product_id" id="product_id">
            <?php echo form_close(); ?>
        </div>
    </div>

</div>
<div class="container-fluid">

    <!-- Display success message -->
    <?php if ($this->session->flashdata('supplier_success')) : ?>
        <div class="alert alert-primary text-center">
            <?php echo $this->session->flashdata('supplier_success') ?>
        </div>
    <?php endif ?>

    <!-- Display failure message -->
    <?php if ($this->session->flashdata('supplier_failed')) : ?>
        <div class="alert alert-danger text-center">
            <?php echo $this->session->flashdata('supplier_failed') ?>
        </div>
    <?php endif ?>


    <div class="card">
        <div class="card-body">
            <table id="supplier-table" class="table table-striped w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Options</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Supplier Form Section -->
    <div class="card mt-4">
        <div class="card-body">
            <h4>Supplier</h4>

            <hr>

            <!-- Supplier Form -->
            <?php echo form_open(base_url('dashboard/supplier'), ['id' => 'supplier-add-update-form']); ?>

            <?php echo form_hidden('supplier_action', 'add_update'); ?>
            <input type="hidden" name="supplier_id" id="supplier_id" value="<?php echo set_value('supplier_id'); ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Supplier Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Supplier Name" value="<?php echo set_value('name'); ?>">
                        <?php echo form_error('name', '<small class="form-text text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mobile">Contact</label>
                        <input type="number" class="form-control" name="mobile" id="mobile" placeholder="Contact" value="<?php echo set_value('mobile'); ?>">
                        <?php echo form_error('mobile', '<small class="form-text text-danger">', '</small>'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?php echo set_value('address'); ?>">
                <?php echo form_error('address', '<small class="form-text text-danger">', '</small>'); ?>
            </div>

            <!-- Dynamic Button Label -->
            <button type="submit" id="submit" class="btn <?php echo set_value('supplier_id') ? 'btn-danger' : 'btn-primary'; ?> float-right">
                <?php echo set_value('supplier_id') ? 'Update Supplier' : 'Add New Supplier'; ?>
            </button>

            <?php echo form_close(); ?>
        </div>
    </div>


    <!-- Supplier Delete Form Section -->
    <div class="card d-none">
        <div class="card-body">
            <?php echo form_open(base_url('dashboard/supplier'), ['id' => 'supplier-delete-form']); ?>
            <?php echo form_hidden('supplier_action', 'delete'); ?>
            <input type="hidden" name="supplier_id" id="supplier_id" value="<?php echo set_value('supplier_id'); ?>">
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
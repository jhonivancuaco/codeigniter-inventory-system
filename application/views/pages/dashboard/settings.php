<div class="container-fluid">
    <div class="card card-danger card-outline">
        <div class="card-body">

            <h4>User Profile</h4>

            <hr>

            <?php if ($this->session->flashdata('update_profile_success')): ?>
                <div class="alert alert-primary text-center">
                    <?php echo $this->session->flashdata('update_profile_success'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('update_profile_failed')): ?>
                <div class="alert alert-danger text-center">
                    <?php echo $this->session->flashdata('update_profile_failed'); ?>
                </div>
            <?php endif; ?>

            <?php echo form_open(base_url('dashboard/settings'), array('id' => 'update-profile')); ?>

            <?php echo form_hidden('user_id', $this->session->user_id); ?>
            <?php echo form_hidden('action', 'update-profile'); ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name" value="<?php echo $userdata->firstname ?>">
                        <?php echo form_error('firstname', '<small class="form-text text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name" value="<?php echo $userdata->lastname ?>">
                        <?php echo form_error('lastname', '<small class="form-text text-danger">', '</small>'); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo $userdata->email ?>">
                        <?php echo form_error('email', '<small class="form-text text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="number" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number" value="<?php echo $userdata->mobile ?>">
                        <?php echo form_error('mobile', '<small class="form-text text-danger">', '</small>'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control" placeholder="Address" value="<?php echo $userdata->address ?>">
                <?php echo form_error('address', '<small class="form-text text-danger">', '</small>'); ?>
            </div>

            <button class="btn btn-danger float-right">Update Profile</button>

            <?php echo form_close(); ?>
        </div>
    </div>

    <div class="card card-danger card-outline">
        <div class="card-body">

            <h4>Change Password</h4>

            <hr>

            <?php if ($this->session->flashdata('change_password_success')): ?>
                <div class="alert alert-primary text-center">
                    <?php echo $this->session->flashdata('change_password_success'); ?>
                </div>
            <?php endif; ?>

            <?php echo form_open(base_url('dashboard/settings'), array('id' => 'change-password')); ?>

            <?php echo form_hidden('user_id', $this->session->user_id); ?>
            <?php echo form_hidden('action', 'change-password'); ?>

            <div class="form-group">
                <label for="change_password">Set New Password</label>
                <div class="password-control">
                    <input type="password" name="change_password" id="change_password" class="form-control" placeholder="Old Password">
                </div>
                <?php echo form_error('change_password', '<small class="form-text text-danger">', '</small>'); ?>
            </div>

            <button class="btn btn-danger float-right">Change Password</button>

            <?php echo form_close(); ?>

        </div>
    </div>
</div>
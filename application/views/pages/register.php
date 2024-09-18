<div class="container min-vh-100 d-flex flex-column align-items-center justify-content-center">

    <div class="d-flex align-items-center mb-4">
        <img src="<?php echo LOGO ?>" width="100" class="mr-2">
        <h1 class="m-0">
            <?php echo str_replace('Graphics Services', 'Graphics<br>Services', SITE_NAME) ?>
        </h1>
    </div>

    <div class="card cold-md-10 col-lg-8 col-xl-6 mx-auto">
        <div class="card-body">
            <h2 class="text-center">REGISTER</h2>

            <?php echo form_open(base_url('register')); ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name" value="<?php echo set_value('firstname'); ?>">
                        <?php echo form_error('firstname', '<small class="form-text text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name" value="<?php echo set_value('lastname'); ?>">
                        <?php echo form_error('lastname', '<small class="form-text text-danger">', '</small>'); ?>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo set_value('email'); ?>">
                <?php echo form_error('email', '<small class="form-text text-danger">', '</small>'); ?>
            </div>

            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="number" name="mobile" id="mobile" class="form-control" placeholder="Mobile" value="<?php echo set_value('mobile'); ?>">
                <?php echo form_error('mobile', '<small class="form-text text-danger">', '</small>'); ?>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo set_value('username'); ?>">
                <?php echo form_error('username', '<small class="form-text text-danger">', '</small>'); ?>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                <?php echo form_error('password', '<small class="form-text text-danger">', '</small>'); ?>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                <?php echo form_error('confirm_password', '<small class="form-text text-danger">', '</small>'); ?>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">REGISTER</button>
            </div>

            <?php echo form_close(); ?>

            <p class="text-center">Already have an account? <a href="<?php echo base_url() ?>">Login</a></p>
        </div>
    </div>

</div>
<div class="container min-vh-100 d-flex flex-column align-items-center justify-content-center">


    <div class="d-flex align-items-center mb-4">
        <img src="<?php echo LOGO ?>" width="100" class="mr-2">
        <h1 class="m-0">
            <?php echo str_replace('Graphics Services', 'Graphics<br>Services', SITE_NAME) ?>
        </h1>
    </div>

    <div class="card cold-md-10 col-lg-8 col-xl-6 mx-auto">
        <div class="card-body">
            <h2 class="text-center">LOG IN</h2>

            <?php if ($this->session->flashdata('register_success')): ?>
                <div class="alert alert-primary text-center">
                    <?php echo $this->session->flashdata('register_success'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('login_error')): ?>
                <div class="alert alert-danger text-center">
                    <?php echo $this->session->flashdata('login_error'); ?>
                </div>
            <?php endif; ?>

            <?php echo form_open(base_url()); ?>

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
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="remember_me" id="remember_me" checked>
                        Remember Me
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">LOG IN</button>
            </div>

            <?php echo form_close(); ?>

            <p class="text-center">Don't have an account? <a href="<?php echo base_url('register') ?>">Register</a></p>
        </div>
    </div>

</div>
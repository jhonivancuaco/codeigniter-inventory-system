<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6 d-flex align-items-center">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-dark border border-dark rounded px-3 mr-3" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <h1><?php echo isset($title) && $title ? $title : 'Page' ?></h1>
            </div>
            <div class="col-sm-6">
                <nav class="navbar">
                    <ul class="navbar-nav flex-row align-items-center gap-14 ml-auto">
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="<?php echo base_url('logout') ?>" class="nav-link text-dark">Logout?</a>
                        </li>
                        <li class="nav-item d-none d-sm-inline-block">
                            <i class="far fa-user-circle fa-lg"></i>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
</section>
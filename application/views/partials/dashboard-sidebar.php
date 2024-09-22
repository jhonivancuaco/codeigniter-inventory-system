<aside class="main-sidebar sidebar-pastel_blue-primary elevation-4">
    <a href="<?php echo base_url('dashboard') ?>" class="brand-link d-flex flex-column align-items-center justify-content-center text-center">
        <img src="<?php echo LOGO ?>" class="brand-image elevation-3 my-2" style="opacity: .8">
        <span class="brand-text font-weight-light small text-wrap font-weight-bold">
            <?php echo SITE_NAME ?>
        </span>
    </a>

    <div class="sidebar">

        <!-- DO NOT FORGET TO ADD (nav-icon) CLASSS TO EACH ICONS -->

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo base_url('dashboard') ?>" class="nav-link <?php echo isset($title) && $title == 'Inventory' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>
                            Inventory
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('dashboard/sales_activity') ?>" class="nav-link  <?php echo isset($title) && $title == 'Sales Activity' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Sales Activity
                        </p>
                    </a>
                </li>
                <li class="nav-item <?php echo strpos($title, 'Manage Sales') === 0 ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?php echo strpos($title, 'Manage Sales') === 0 ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                            Manage Sales
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('dashboard/supplier') ?>" class="nav-link <?php echo isset($title) && $title == 'Manage Sales - Supplier' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>Supplier</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('dashboard/products') ?>" class="nav-link <?php echo isset($title) && $title == 'Manage Sales - Products' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('dashboard/orders') ?>" class="nav-link <?php echo isset($title) && $title == 'Manage Sales - Orders' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-receipt"></i>
                                <p>Orders</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('dashboard/settings') ?>" class="nav-link  <?php echo isset($title) && $title == 'Settings' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-sliders-h"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
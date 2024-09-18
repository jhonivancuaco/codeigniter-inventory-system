<!DOCTYPE html>
<html lang="en">

<?php $this->view('head') ?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php $this->view('partials/dashboard-sidebar') ?>

        <div class="content-wrapper bg-pastel_light_red pb-5">

            <?php $this->view('partials/dashboard-header') ?>

            <section class="content">
                <?php $this->view("$page") ?>
            </section>
        </div>

        <?php $this->view('partials/dashboard-footer') ?>

    </div>

    <?php $this->view('footer') ?>
</body>

</html>
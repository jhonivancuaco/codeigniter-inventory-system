<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="<?php echo LOGO ?>" type="image/x-icon">

    <?php $sitename = SITE_NAME ? SITE_NAME : 'Page'; ?>
    <title><?php echo isset($title) && $title ? $title . ' | ' . $sitename : $sitename ?></title>

    <!-- Main Styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/resources/css/main.css?ver=' . time()) ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/resources/plugins/fontawesome-free/css/all.css?ver=' . time()) ?>">
    <script src="<?php echo base_url('assets/resources/plugins/jquery/jquery.js?ver=' . time()) ?>"></script>

    <!-- Chart.js -->
    <script src="<?php echo base_url('assets/resources/plugins/chart.js/Chart.min.js?ver=' . time()) ?>"></script>

    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo base_url('assets/resources/plugins/toastr/toastr.min.css?ver=' . time()) ?>">
    <script src="<?php echo base_url('assets/resources/plugins/toastr/toastr.min.js?ver=' . time()) ?>"></script>

    <!-- Moment.js -->
    <script src="<? echo base_url('assets/resources/plugins/moment/moment.min.js?ver=' . time()); ?>"></script>

    <!-- Date Range Picker -->
    <link rel="stylesheet" href="<? echo base_url('assets/resources/plugins/daterangepicker/daterangepicker.css?ver=' . time()); ?>">
    <script src="<? echo base_url('assets/resources/plugins/daterangepicker/daterangepicker.js?ver=' . time()); ?>"></script>

    <!-- DataTables and Plugins -->
    <link rel="stylesheet" href="<?php echo base_url('assets/resources/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css?ver=' . time()) ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/resources/plugins/datatables-responsive/css/responsive.bootstrap4.min.css?ver=' . time()) ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/resources/plugins/datatables-buttons/css/buttons.bootstrap4.min.css?ver=' . time()) ?>">
    <script src="<?php echo base_url('assets/resources/plugins/datatables/jquery.dataTables.min.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/resources/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/resources/plugins/datatables-responsive/js/dataTables.responsive.min.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/resources/plugins/datatables-responsive/js/responsive.bootstrap4.min.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/resources/plugins/datatables-buttons/js/dataTables.buttons.min.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/resources/plugins/datatables-buttons/js/buttons.bootstrap4.min.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/resources/plugins/jszip/jszip.min.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/resources/plugins/pdfmake/pdfmake.min.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/resources/plugins/pdfmake/vfs_fonts.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/resources/plugins/datatables-buttons/js/buttons.html5.min.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/resources/plugins/datatables-buttons/js/buttons.print.min.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/resources/plugins/datatables-buttons/js/buttons.colVis.min.js?ver=' . time()) ?>"></script>


    <!-- Global Styles and Scripts -->
    <script src="<?php echo base_url('assets/resources/plugins/bootstrap/js/bootstrap.bundle.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/resources/dist/js/adminlte.js?ver=' . time()) ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/global.css?ver=' . time()) ?>">
    <script src="<?php echo base_url('assets/js/global.js?ver=' . time()) ?>"></script>

    <script>
        function base_url(path = '') {
            const base_url = "<?php echo base_url() ?>";

            if (path) {
                if (path.startsWith('/')) {
                    path = path.substring(1);
                }
            }

            return base_url + path;
        }
    </script>

    <?php if (isset($css) && !empty($css)) : ?>
        <?php foreach ($css as $style) : ?>
            <script src="<?php echo $style ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($js) && !empty($js)) : ?>
        <?php foreach ($js as $script) : ?>
            <script src="<?php echo $script ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</head>
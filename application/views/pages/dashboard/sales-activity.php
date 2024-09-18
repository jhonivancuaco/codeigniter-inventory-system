<div class="container-fluid">

    <div class="row">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-cog"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Order Completed</span>
                    <span class="info-box-number">
                        <?php echo $reports['order_status']['completed'] ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="info-box">
                <span class="info-box-icon bg-pastel_blue elevation-1"><i class="fas fa-cog"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Order Pending</span>
                    <span class="info-box-number">
                        <?php echo $reports['order_status']['pending'] ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="info-box">
                <span class="info-box-icon bg-pastel_red elevation-1"><i class="fas fa-cog"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Order Return</span>
                    <span class="info-box-number">
                        <?php echo $reports['order_status']['return'] ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cog"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Order Cancelled</span>
                    <span class="info-box-number">
                        <?php echo $reports['order_status']['cancelled'] ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <canvas id="barChart" style="min-height: 320px; height: 320px; max-height: 320px; max-width: 100%;"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Lowest Product Stocks</h5>

                    <div class="table-responsive">
                        <table class="table table-striped w-100">
                            <tr>
                                <th>Product</th>
                                <th>Stocks</th>
                            </tr>
                            <?php foreach ($reports['lowest_product_stocks'] as $item) : ?>
                                <tr class="small">
                                    <td><?php echo $item['name'] ?></td>
                                    <td><?php echo $item['quantity'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-body">
                        <canvas id="doughnutChart" style="min-height: 280px; height: 280px; max-height: 280px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        // LINE CHART -----------------------------------------------------------------------------------------
        var areaChartData = {
            labels: [<?php echo '"' . implode('","', $reports['sales_and_profit']['labels']) . '"' ?>],
            datasets: [{
                    label: 'Monthly Sales',
                    backgroundColor: 'rgba(155,190,237,0)',
                    borderColor: 'rgba(155,190,237,0.8)',
                    pointRadius: 2,
                    pointBackgroundColor: '#3b8bba',
                    pointBorderColor: 'rgba(155,190,237,1)',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(155,190,237,1)',
                    lineTension: 0,
                    data: [<?php echo implode(',', $reports['sales_and_profit']['total_sales']) ?>]
                },
                {
                    label: 'Monthly Profit',
                    backgroundColor: 'rgba(229, 120, 143,0)',
                    borderColor: 'rgba(229, 120, 143,0.8)',
                    pointRadius: 2,
                    pointBackgroundColor: 'rgba(229, 120, 143,1)',
                    pointBorderColor: 'rgba(229, 120, 143,1)',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(229, 120, 143,1)',
                    lineTension: 0,
                    data: [<?php echo implode(',', $reports['sales_and_profit']['total_profit']) ?>]
                }
            ]
        };


        var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
        var lineChartData = $.extend(true, {}, areaChartData);

        var lineChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        };

        new Chart(lineChartCanvas, {
            type: 'line',
            data: areaChartData,
            options: lineChartOptions
        });

        // BAR CHART -----------------------------------------------------------------------------------------
        var areaChartData = {
            labels: [<?php echo '"' . implode('","', $reports['monthly_sales']['labels']) . '"' ?>],
            datasets: [{
                label: 'Monthly Products Sold',
                backgroundColor: 'rgba(155,190,237,0.9)',
                borderColor: 'rgba(155,190,237,0.8)',
                pointRadius: false,
                pointColor: 'rgba(155,190,237,0.9)',
                pointStrokeColor: 'rgba(155,190,237,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(155,190,237,1)',
                data: [<?php echo implode(',', $reports['monthly_sales']['data']) ?>]
            }]
        };

        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChartData = $.extend(true, {}, areaChartData);

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        };

        new Chart(barChartCanvas, {
            type: 'bar',
            data: areaChartData,
            options: barChartOptions
        });


        // PIE CHART -----------------------------------------------------------------------------------------

        var pieData = {
            labels: [<?php echo '"' . implode('","', $reports['top_sales']['labels']) . '"' ?>],
            datasets: [{
                data: [<?php echo implode(',', $reports['top_sales']['data']) ?>],
                backgroundColor: [
                    'rgba(220, 53, 69, 1)', // Fully opaque red
                    'rgba(220, 53, 69, 0.9)', // 90% opacity red
                    'rgba(220, 53, 69, 0.8)', // 80% opacity red
                    'rgba(220, 53, 69, 0.7)', // 70% opacity red
                    'rgba(220, 53, 69, 0.6)', // 60% opacity red
                    'rgba(220, 53, 69, 0.5)' // 50% opacity red
                ],
            }]
        };

        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');

        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true, // Show the default legend
                position: 'bottom',
                labels: {
                    boxWidth: 20, // Adjust box width for better appearance
                }
            },
            title: {
                display: true, // Enable the title
                text: 'Top Payment Methods', // The title text
                fontSize: 12, // Customize the title font size (optional)
                padding: 10 // Add padding around the title (optional)
            }
        };

        new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        });

        // DOUGHNUT CHART -----------------------------------------------------------------------------------------

        var doughnutData = {
            labels: [<?php echo '"' . implode('","', $reports['highest_payment_method']['labels']) . '"' ?>],
            datasets: [{
                data: [<?php echo implode(',', $reports['highest_payment_method']['data']) ?>],
                backgroundColor: [
                    'rgba(0, 123, 255, 1)', // Fully opaque blue (Bootstrap default)
                    'rgba(0, 123, 255, 0.9)', // 90% opacity red
                    'rgba(0, 123, 255, 0.8)', // 80% opacity red
                    'rgba(0, 123, 255, 0.7)', // 70% opacity red
                    'rgba(0, 123, 255, 0.6)', // 60% opacity red
                    'rgba(0, 123, 255, 0.5)' // 50% opacity red
                ],
            }]
        };

        var doughnutChartCanvas = $('#doughnutChart').get(0).getContext('2d');

        var doughnutOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true, // Show the default legend
                position: 'right',
                labels: {
                    boxWidth: 20, // Adjust box width for better appearance
                }
            },
            title: {
                display: true, // Enable the title
                text: 'Top Sales', // The title text
                fontSize: 12, // Customize the title font size (optional)
                padding: 10 // Add padding around the title (optional)
            }
        };

        new Chart(doughnutChartCanvas, {
            type: 'pie',
            data: doughnutData,
            options: doughnutOptions
        });
    });
</script>
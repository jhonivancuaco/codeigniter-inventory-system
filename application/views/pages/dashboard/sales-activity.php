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
                        <?php echo $reports['order_status']['returned'] ?>
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

    <div class="card">
        <div class="card-body">
            <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5>Products With Lowest Stock</h5>

                    <div class="table-responsive">
                        <table class="table table-striped w-100">
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Stock</th>
                            </tr>
                            <?php if (!empty($reports['products_with_lowest_stocks'])): ?>
                                <?php foreach ($reports['products_with_lowest_stocks'] as $item) : ?>
                                    <tr class="small">
                                        <td><?php echo $item->id ?></td>
                                        <td><?php echo $item->name ?></td>
                                        <td><?php echo $item->quantity ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2">
                                        <p class="text-center">No data available</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <canvas id="doughnutChart" style="min-height: 318px; height: 318px; max-height: 318px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var line_graph_data = <?php echo json_encode($reports['line_graph_data']); ?>;
        let lineChartInstance; // To store the chart instance

        // Function to determine which dataset (labels and data) to use based on screen size
        function getChartDataByScreenSize() {

            var screenWidth = window.innerWidth;

            // Decide which dataset to use based on screen size
            if (screenWidth < 576) {
                // Extra small screens (xs)
                return {
                    labels: line_graph_data.xs.labels,
                    data: line_graph_data.xs.data
                };
            } else if (screenWidth < 992) {
                // Small screens (sm)
                return {
                    labels: line_graph_data.sm.labels,
                    data: line_graph_data.sm.data
                };
            } else {
                // Large screens and above (lg)
                return {
                    labels: line_graph_data.lg.labels,
                    data: line_graph_data.lg.data
                };
            }
        }

        // Function to render or update the chart with the correct data and labels
        function renderOrUpdateLineChart() {
            const chartData = getChartDataByScreenSize();

            var areaChartData = {
                labels: chartData.labels, // Update the labels based on the screen size
                datasets: [{
                    label: 'Monthly Products Purchased (Delivered)',
                    backgroundColor: 'rgba(220, 53, 69, 0)',
                    borderColor: 'rgba(220, 53, 69, 0.8)',
                    pointRadius: 2,
                    pointBackgroundColor: '#3b8bba',
                    pointBorderColor: 'rgba(220, 53, 69, 1)',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(220, 53, 69, 1)',
                    lineTension: 0,
                    data: chartData.data // Update the data based on the screen size
                }]
            };

            var lineChartCanvas = $('#lineChart').get(0).getContext('2d');

            // Check if the chart already exists
            if (lineChartInstance) {
                // If the chart exists, update it with the new data
                lineChartInstance.data.labels = areaChartData.labels;
                lineChartInstance.data.datasets[0].data = areaChartData.datasets[0].data;
                lineChartInstance.update(); // Update the chart
            } else {
                // If the chart doesn't exist, create it
                var lineChartOptions = {
                    responsive: true, // This enables the chart to resize with the window
                    maintainAspectRatio: false, // Ensure aspect ratio is not locked for responsive flexibility
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Sales'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                };

                // Create the chart and store the instance
                lineChartInstance = new Chart(lineChartCanvas, {
                    type: 'line',
                    data: areaChartData,
                    options: lineChartOptions
                });
            }
        }

        // Initial rendering of the chart
        renderOrUpdateLineChart();

        // Re-render the chart with updated data and labels when the window is resized
        $(window).resize(function() {
            renderOrUpdateLineChart(); // Just update the chart instead of removing the canvas
        });





        var barChartData = {
            labels: [<?php echo '"' . implode('","', $reports['top_selling_products']['labels']) . '"' ?>],
            datasets: [{
                label: 'Top Selling Products',
                backgroundColor: 'rgba(220, 53, 69, 0.5)',
                borderColor: 'rgba(220, 53, 69, 0.5)',
                data: [<?php echo implode(',', $reports['top_selling_products']['data']) ?>]
            }]
        };

        var barChartCanvas = $('#barChart').get(0).getContext('2d');

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        min: 0 // Set minimum value to 0
                    }
                }]
            }
        };

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });









        var doughnutData = {
            labels: [<?php echo '"' . implode('","', $reports['mop']['labels']) . '"' ?>],
            datasets: [{
                data: [<?php echo implode(',', $reports['mop']['data']) ?>],
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
                position: 'bottom',
                labels: {
                    boxWidth: 20, // Adjust box width for better appearance
                }
            },
            title: {
                display: true, // Enable the title
                text: 'Payment Methods Usage', // The title text
                fontSize: 12, // Customize the title font size (optional)
                padding: 10 // Add padding around the title (optional)
            },
            plugins: {
                datalabels: {
                    color: '#fff', // Change label color
                    anchor: 'end', // Positioning options
                    align: 'start', // Alignment options
                    formatter: function(value, context) {
                        debugger
                        return context.chart.data.labels[context.dataIndex] + ': ' + value; // Custom label format
                    }
                }
            }
        };

        new Chart(doughnutChartCanvas, {
            type: 'doughnut',
            data: doughnutData,
            options: doughnutOptions
        });








    })
</script>
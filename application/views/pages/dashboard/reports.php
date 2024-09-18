<div id="<?php echo $id ?>" class="container-fluid">
    <div class="row bg-pastel_red py-2 mb-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-2">

                    <h4>Sales</h4>

                    <div class="row">
                        <div class="col-6">
                            <div class="info-box bg-transparent shadow-none m-0">
                                <span class="info-box-icon bg-pastel_blue elevation-1"><i class="fas fa-cog"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Sales</span>
                                    <span class="info-box-number">
                                        10
                                        <small>%</small>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="info-box bg-transparent shadow-none m-0">
                                <span class="info-box-icon bg-pastel_blue elevation-1"><i class="fas fa-cog"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Profit</span>
                                    <span class="info-box-number">
                                        10
                                        <small>%</small>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-2">

                    <h4>Purchase</h4>

                    <div class="row">
                        <div class="col-6">
                            <div class="info-box bg-transparent shadow-none">
                                <span class="info-box-icon bg-pastel_blue elevation-1"><i class="fas fa-cog"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Purchase Amount</span>
                                    <span class="info-box-number">
                                        10
                                        <small>%</small>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="info-box bg-transparent shadow-none">
                                <span class="info-box-icon bg-pastel_blue elevation-1"><i class="fas fa-cog"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">No. of Purchase</span>
                                    <span class="info-box-number">
                                        10
                                        <small>%</small>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="info-box bg-transparent shadow-none">
                                <span class="info-box-icon bg-pastel_blue elevation-1"><i class="fas fa-cog"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Returns</span>
                                    <span class="info-box-number">
                                        10
                                        <small>%</small>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="info-box bg-transparent shadow-none">
                                <span class="info-box-icon bg-pastel_blue elevation-1"><i class="fas fa-cog"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Cancel of Orders</span>
                                    <span class="info-box-number">
                                        10
                                        <small>%</small>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body">

                    <h4>Stocks</h4>

                    <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>

                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">

                    <h4>Wastage Product</h4>

                    <div class="d-flex flex-column align-items-center justify-content-around h-100">
                        <div class="info-box bg-transparent shadow-none m-0">
                            <span class="info-box-icon bg-pastel_blue elevation-1" style="width: 100px"><i class="fas fa-cog"></i></span>
                            <div class="info-box-content text-center">
                                <span class="info-box-text">Sales</span>
                                <span class="info-box-number">
                                    10
                                    <small>%</small>
                                </span>
                            </div>
                        </div>

                        <div class="info-box bg-transparent shadow-none m-0">
                            <div class="info-box-content text-center">
                                <span class="info-box-text">Sales</span>
                                <span class="info-box-number">
                                    10
                                    <small>%</small>
                                </span>
                            </div>
                            <span class="info-box-icon bg-pastel_blue elevation-1" style="width: 100px"><i class="fas fa-cog"></i></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 p-0">
            <div class="card bg-pastel_red rounded-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-8 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-dark">

                                    <h4 class="text-center">Sales Statictics</h4>

                                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-dark">

                                    <h4 class="text-center">Top Selling</h4>

                                    <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var areaChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Digital Goods',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [19, 27, 28, 40, 48, 86, 90]
            }]
        }

        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        }

        new Chart(barChartCanvas, {
            type: 'bar',
            data: areaChartData,
            options: barChartOptions
        })


        var pieData = {
            labels: [
                'Chrome',
                'IE',
                'FireFox',
                'Safari',
                'Opera',
                'Navigator',
            ],
            datasets: [{
                data: [700, 500, 400, 600, 300, 100],
                backgroundColor: [
                    'rgba(255, 0, 0, 1)',
                    'rgba(255, 0, 0, 0.9)',
                    'rgba(255, 0, 0, 0.8)',
                    'rgba(255, 0, 0, 0.7)',
                    'rgba(255, 0, 0, 0.6)',
                    'rgba(255, 0, 0, 0.5)',
                ],
            }]
        }

        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieData = pieData;
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    generateLabels: function(chart) {
                        var data = chart.data;
                        return data.datasets[0].data.map(function(value, index) {
                            return {
                                text: data.labels[index] + ' - ' + value + ' sales',
                                fillStyle: data.datasets[0].backgroundColor[index],
                                hidden: null,
                                index: index
                            };
                        });
                    },
                    padding: 20
                },
                columns: 2,
            }
        }

        new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })

        var donutData = {
            labels: [
                'Holding Stock',
                'Pending Stock',
            ],
            datasets: [{
                data: [700, 500],
                backgroundColor: ['#f00', '#ddd']
            }]
        }

        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData = donutData;
        var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    generateLabels: function(chart) {
                        var data = chart.data;
                        return data.datasets[0].data.map(function(value, index) {
                            return {
                                text: value + ' ' + data.labels[index],
                                fillStyle: data.datasets[0].backgroundColor[index],
                                hidden: null,
                                index: index
                            };
                        });
                    },
                    padding: 20
                },
                columns: 2,
            }
        }

        new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        })
    });
</script>
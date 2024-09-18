<?php
$chartId = 'line-chart';
?>

<h5>Line Chart</h5>
<canvas id="<?php echo $chartId; ?>"></canvas>

<script>
    var chartId = $chartId

    var chart = new Chart($('#' + chartId).get(0).getContext('2d'), {
        type: 'line',
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [{
                label: 'Data One',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [0, 10, 5, 2, 20, 30, 45]
            }]
        }
    });

    console.log(chart)
</script>
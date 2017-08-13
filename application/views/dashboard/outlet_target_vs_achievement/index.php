<div id="productivity_div_graph" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<script type="text/javascript">
    $(function () {
        $('#productivity_div_graph').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            style:{
                /*fontFamily: 'serif',     */           
                'font-size': '15px'
            },
            text: '<b>Outlet Target Vs Achievement <br>(<?php echo $start_date . " to " .$end_date?>)</b>'
        },
        xAxis: {
            categories: [
                'Outlet'
            ]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Outlet'
            }
        },

        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Target',
            data: [<?php echo $num_of_outlet; ?>]

        }, {
            name: 'Achievement',
            data: [<?php echo $visited; ?>]

        }]
    });
    });
</script>
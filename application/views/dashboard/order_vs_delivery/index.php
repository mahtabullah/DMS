<div id="order_vs_delivery_graph" style="min-width: 310px; height: 400px; margin: 1px;"></div>
<script type="text/javascript">
    $(function () {
        $('#order_vs_delivery_graph').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                style:{
                    /*fontFamily: 'serif',     */           
                    'font-size': '15px'
                },
                text: '<b>Order VS Delivery <br> (<?php echo $start_date . " to ". $end_date; ?>)</b>'
            },
            tooltip: {
                pointFormat: '<br />volume: {point.y} CS'
            },
            xAxis: {
                categories: [
                    'SKU'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'CS'
                }
            },

            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                color: '#ac3ec1',
                name: 'Order',
                data: [<?php echo $order_value; ?>]

            }, {
                color: '#477bd1',
                name: 'Delivered',
                data: [<?php echo $delivered_value; ?>]

            }]
        });
    });
</script>
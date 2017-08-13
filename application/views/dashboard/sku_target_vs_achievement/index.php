<div id="sku_target_div_graph" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<script type="text/javascript">
    $(function () {
        $('#sku_target_div_graph').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                style:{
                    /*fontFamily: 'serif',     */           
                    'font-size': '15px'
                },
                text: '<b>Target vs Achievement <br> (<?php echo date('M,Y',strtotime($end_date)); ?>)</b>'
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
                name: 'Target(FM)',
                data: [<?php echo $target; ?>]

            }, {
                color: '#477bd1',
                name: 'Achievement(MTD)',
                data: [<?php echo $achievement; ?>]

            }]
        });
    });
</script>
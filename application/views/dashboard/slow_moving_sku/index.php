<div id="slow_moving_sku_graph" style="min-width: 310px; height: 400px;margin-right: 1px;"></div>
<script type="text/javascript">
    $(function () {
    
    $('#slow_moving_sku_graph').highcharts({
        chart: {
            type: 'pyramid',
            marginRight: 100
        },
        title: {
            text: 'Slow Moving SKU ',
            x: -50
        },
        tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br />value: {point.y} CS'
            },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b> ({point.y:,.0f})',
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                    softConnector: true
                }
            }
        },
        legend: {
            enabled: true
            
        },
        series: [{
            name: 'SKU Sales',
            data: [
                <?php
                foreach($sku as $k=>$v){
                    echo "['".$v['sku_name']."',".$v['delivered_qty']."],";
                }
                ?>
                
                ]
                }]
    });
});
</script>
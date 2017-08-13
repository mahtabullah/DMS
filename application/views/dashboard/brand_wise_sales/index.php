<div id="brand_wise_sales_graph" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script type="text/javascript">

    $(function () {
        $('#brand_wise_sales_graph').highcharts({
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                style:{
                /*fontFamily: 'serif',     */           
                'font-size': '15px'
            },
                text: '<b>Brand Wise Sales<br> (<?php echo $start_date . " to " .$end_date ?>)</b>'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br />volume: {point.y} CS'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    }
                }
            },
            series: [{
                    type: 'pie',
                    name: 'Sales',
                    data: [
                        <?php
                        foreach($sales as $k=>$v){
                        $name = $v['element_name'];
                        $color = "";
                        if($name =='PEPSI'){
                            $color = "color: '#1c3c70', ";
                        }else if($name =='Mirinda Orange'){
                            $color = "color: '#ffc000', ";
                        }else if($name =='7UP'){
                            $color = "color: '#00b050', ";
                        }else if($name =='M. DEW'){
                            $color = "color: '#b7d426', ";
                        }else if($name =='Aquafina'){
                            $color = "color: '#455fd6', ";
                        }else if($name =='Slice'){
                            $color = "color: '#ebc053', ";
                        }else if($name =='SODA-MIR'){
                            $color = "color: '#bfbfbf', ";
                        }
                            echo "{".$color." name:'".$v['element_name']."',y:".$v['sales']."},";
                        }
                        ?>
                    ]
                }]
        });
    });
</script>
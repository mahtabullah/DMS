<div id="geo_location_status_graph" style="min-width: 310px; height: 400px; margin: 0 auto;"></div>
<script type="text/javascript">

    var start_date_1 = '<?php echo $start_date?>'
    var end_date_1 = '<?php echo $end_date?>'


    $(function () {
            $('#geo_location_status_graph').highcharts({
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                title: {
                    text: 'Geolocation Status'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
                        name: 'Geolocation Status',
                        data: [
                            {name: 'Successfull call is done @ Zero Location',  y: <?php echo $green; ?>, color: '#8AB800',start_date:'<?php echo $start_date;?>',end_date:'<?php echo $end_date;?>'},
                            {name: 'Successfull call is done @ Immediate Location',  y: <?php echo $yellow; ?>, color: '#E6E600',start_date:'<?php echo $start_date;?>',end_date:'<?php echo $end_date;?>'},
                            {name: 'Not Visited', y:  <?php echo $red; ?>, color: '#E62E00',start_date:'<?php echo $start_date;?>',end_date:'<?php echo $end_date;?>'},
                            {name: 'Visited but Unproductive', y:  <?php echo $exception_reason; ?>, color: '#4d90fe',start_date:'<?php echo $start_date;?>',end_date:'<?php echo $end_date;?>'}
                        ],
                        point:{
                                events:{
                                    click: function (event) {
                                        market_pjp_details(this.start_date,this.end_date);
                                    }
                                }
                            }
                    }]
            });
        });


    function market_pjp_details(){
        var url = '<?php echo site_url('report/sr_market_pjp'); ?>/'+start_date_1+'/'+end_date_1;
        window.location.href = url;
    }

        function geo_location(){
            var url = '<?php echo site_url('geolocation/index'); ?>/'+start_date_1+'/'+end_date_1;
            window.location.href = url;
        }
        
</script>
<div style="float: right"><button  class="btn blue" id="save" onclick="market_pjp_details()">Market Pjp</button></div>
<div style="float: left"><button  class="btn blue" id="save" onclick="geo_location()">Geo Location</button></div>


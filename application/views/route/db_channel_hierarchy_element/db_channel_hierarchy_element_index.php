<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    DB Journey Plan Elements
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>DB Journey Plan Elements</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">

            <!--DB Layer start-->
            <div id="geo_layer"></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-success" onclick="get_data();">Search</button>
            </div>
        </div>

        <div id="row">
            <div id="content-view"></div>
        </div>



        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<?php
$this->load->view('footer/footer');
?>
<script type="text/javascript">
    $(document).ready(function () {
        geoLayerFilterInitDB('#geo_layer');
        //productLayerInit('#product_layer');
        //getAllSku("#sku_list");
        getDateRange('#date_range');

    });
//    $(document).ready(function(){
//        $('#sample_4').DataTable( {
//                dom: 'T<"clear">lfrtip',
//                "bSort": false,
//                "paging": false,
//                searching: false,
//                "iDisplayLength": 100
//            });
//    });
//    $.ajax({
//        type: "POST",
//        url: "<?php //echo base_url(); ?>//dynamic_filter/load/",
//        data: {type: 'geography', target: 'dbhouse'},
//        success: function(data) {
//            $('#filter').append(data);
//        }
//    });
    
    function get_search_data(){
        var search  = $("#search").val();
        if(search !=''){
        $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>distribution_channel/get_search_data/",
                data: {search: search},
                success: function(data) {
                  $('#search_area').html(data);
                  $('#sample_2').DataTable( {
                        dom: 'T<"clear">lfrtip'
                    });
                    $("#sample_2_filter").hide();  
                }
            });
        }
    }

    function get_data() {
        var db_id = $("#dbhouse_id").val();
        $('#ajax_load').css("display","block");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>distribution_channel/getFilterData/",
            data: {db_id:db_id},
            dataType: "html",
            success: function (data) {
                $('#content-view').html(data);
                DataTable("#sample_3");
                $('#ajax_load').css("display","none");
            }
        });
    }
</script>
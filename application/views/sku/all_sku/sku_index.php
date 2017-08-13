<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    Product
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Product</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">
            <!--DB Layer start-->
            <div id="db_layer"></div>
            <!--DB Layer end-->
            <!--sku_filter Layer start-->
            <div id="sku_filter"></div>
            <!--sku_filter Layer end-->
        </div>
        <br />
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-success" onclick="get_data();">Search</button>
            </div>
        </div>
        <br />
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="content-view"></div>
    </div>

<?php
$this->load->view('footer/footer');
?>
<script type="text/javascript">
    $(document).ready(function(){
        dbLayerOnlyInit('#db_layer');
        //getSkuType('#sku_filter');
    });

    //get filter data
    function get_data() {
        var db_id = $("#dbhouse_id").val();
        var sku_list = $("#sku_list").val();

        if(db_id =='' || db_id ==null){
            alert("Please Select DB");

        }else if(db_id.length>1){
            alert("Please Select Only one DB");
        }else {


            $('#ajax_load').css("display", "block");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>sku/get_sku_detail_view/",
                data: {db_id:db_id[0],sku_list:sku_list},
                dataType: "html",
                success: function (data) {
                    $('.content-view').html(data);
                    DataTable("#sample_3");
                    $('#ajax_load').css("display", "none");
                }
            });


        }

    }//end
</script>
                               
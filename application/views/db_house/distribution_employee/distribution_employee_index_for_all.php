<?php
$this->load->view( 'header/header' );
$data[ 'role' ] = $this->session->userdata( 'user_role' );
$emp_id = $this->session->userdata('emp_id');
$this->load->view( 'left/left', $data );
?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <h3 class="page-title">
                        Distribution Employees
                    </h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="<?php echo site_url( 'home/home_page' ); ?>">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <p>Distribution Employees</p>
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
         </div>
    </div>

<?php
$this->load->view( 'footer/footer' );
?>

<script>
    $(document).ready(function () {
        geoLayerFilterInitDB('#geo_layer');
        //productLayerInit('#product_layer');
        //getAllSku("#sku_list");
        //getDateRange('#date_range');

    });

    function get_data() {
        var db_id = $("#dbhouse_id").val();
        if (db_id == '' || db_id == null){
            alert('Please Select A DB ');
        } else {
            $('#ajax_load').css("display","block");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>db_house/getFilterData/",
                data: {db_id:db_id},
                dataType: "html",
                success: function (data) {
                    $('#content-view').html(data);
                    DataTable("#sample_2");
                    $('#ajax_load').css("display","none");
                }
            });
        }

    }

</script>

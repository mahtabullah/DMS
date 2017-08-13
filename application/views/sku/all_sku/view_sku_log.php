<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<script src="<?php echo base_url(); ?>assets/js/utility_functions.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                   SKU Log
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href=""> SKU Log</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="control-label" for="biz_zone_layer">Select SKU:</label>
                <select class="form-control input-xlarge select2me" id="sku_id" onchange="get_data()">
                    <option value=""></option>
                    <?php foreach ($sku_name as $sku_names) {
                    ?>
                        <option value="<?php echo $sku_names['id'] ?>"><?php echo $sku_names['sku_name'] ?></option>
                    <?php } ?>
                </select>
                <span class="help-block">
                    Select SR
                </span>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Date Range</label>
                    <div class="input-group date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                        <input type="text" class="form-control" name="date_frm" id="date_frm" onchange="get_data()">
                        <span class="input-group-addon">
                            to
                        </span>
                        <input type="text" class="form-control" name="date_to" id="date_to" onchange="get_data()">
                    </div>
                </div>
            </div>

        </div>
        <script>


            var nowDate = new Date();

            $('#date_frm').datepicker({

                format: 'yyyy-mm-dd',
                autoclose: true
            });

            $('#date_to').datepicker({

                format: 'yyyy-mm-dd',
                autoclose: true
            });




        </script>




        <div id="content-view">

        </div>





    </div>
</div>

<?php
                    $this->load->view('footer/footer');
?>

                    <script>

                        function get_data(){



                            var sku_id = $('#sku_id').val();
                            var date_frm = $('#date_frm').val();
                            var date_to = $('#date_to').val();
                            //alert(sr_id);


                            if(date_frm != '' && date_to != '' ||  sku_id == ''){
                                var request = $.ajax({
                                    url: "<?php echo base_url(); ?>sku/get_data_sku_filter/",
                type: "POST",
                data: {sku_id: sku_id,date_frm: date_frm,date_to: date_to},
                dataType: "html"
            });

            request.done(function(msg) {
                $("#content-view").html( msg );
                $('#sample_2').DataTable( {
                    dom: 'T<"clear">lfrtip'
                });
                console.log(msg);
            });
        }

    }



</script>
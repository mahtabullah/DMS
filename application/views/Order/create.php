<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>


<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->

        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="<?php echo site_url('sales_order/index/others'); ?>">Sales Order Others</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Create
            </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<div class="row">
    <form role="form" id="add_order_form" action="<?php echo site_url('order/add_other_sale_order'); ?>"
          method="post">
        <!-- BEGIN FORM-->
        <div class="form-body">
            <div class="portlet-body form">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12" >
                        <div class="form-group">
                            <label class="control-label col-md-3" for="sales_order_type">Sales Type</label>

                            <div class="col-md-3">
                                <select class="form-control select2me" data-placeholder="Select..."
                                        id="sales_order_type" name="sales_order_type"
                                        onchange="getOutletPart();">
                                    <option value="">Choose Sales Type</option>
                                    <?php foreach ($outlet_type_name as $mm) { ?>
                                        <option value="<?php echo $mm['id']; ?>" code="<?php echo $mm['outlet_type_code']; ?>"><?php echo $mm['outlet_type_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <input id="type" type="hidden" name="type"/>
            </div>
            <div class="col-md-12" id="outlet_part"></div>
            <div class="col-md-12" id="order_part"></div>
            </div>
        </div>
    </form>
</div>



<?php
$this->load->view('footer/footer');
?>

<script type="text/javascript">

    function getOutletPart() {
        var type = $('#sales_order_type option:selected').attr('code');
        $('#type').val(type);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>order/getInfoSales_order_type",
            data: {sales_order_type: type},
            dataType: "html",
            success: function (data) {
                $("#outlet_part").html(data);
                $("#order_part").html('');
                getOrderPart();
                
            }
        });
    }

    function getOrderPart() {
        
        var outlet_id = $("#outlet").val();
        $("#order_part").html('');
        var type = $('#type').val();
        if (type != ''){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>order/gerOrderPart/",
                data: {type: type, outlet_id: outlet_id},
                dataType: "html",
                success: function (data){
                    $("#order_part").html(data);
                }
            });
        }
    }



</script>

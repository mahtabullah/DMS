<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
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
                        <a href="<?php echo site_url('sku/skuIndex'); ?>">Product</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Create</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-reorder"></i>Create
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"></a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form role="form" action="<?php echo site_url('sku/saveSku'); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="parent_id">Sub Brand <span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select Sub Brand"
                                                id="parent_id" name="parent_id"
                                                required>
                                            <option value=""></option>
                                            <?php for ($i = 0; $i < count($sku_category); $i ++) {
                                                foreach ($sku_category[$i] as $mms) {
                                                    ?>
                                                    <option
                                                        value="<?php echo $mms['id'] ?>"><?php echo $mms['element_name'] ?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sku_name">SKU Name Bangla <span style="color: red;">*</span></label>
<!--                                        <input type="text" class="form-control" placeholder="Sku Name Bangla"-->
<!--                                               id="sku_name_b" name="sku_name_b" required>-->
                                        <textarea class="form-control" placeholder="Sku Name Bangla"
                                                  id="sku_name_b" name="sku_name_b" required></textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sku_name">SKU Short Name <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Sku Short Name"
                                               id="sku_name"
                                               name="sku_name" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sku_description">SKU Name</label><!--replace in description-->
                                        <input type="text" class="form-control" placeholder="SKU Name"
                                               id="sku_description" name="sku_description">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="sku_code">SKU Code <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Sku Code" id="sku_code"
                                               name="sku_code" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sku_type_id">SKU Flavor <span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select Sku Type"
                                                id="sku_type_id" name="sku_type_id" required>
                                            <option value=""></option>
                                            <?php foreach ($sku_type as $mmss) { ?>
                                                <option
                                                    value="<?php echo $mmss['id'] ?>"><?php echo $mmss['sku_type_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sku_type_id">SKU Category <span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select Sku Category"
                                                id="sku_category_id" name="sku_category_id" required>
                                            <option value=""></option>
                                            <?php foreach ($category as $mmss) { ?>
                                                <option
                                                    value="<?php echo $mmss['id'] ?>"><?php echo $mmss['sku_category_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="unit">Packaging Size <span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select Packaging Size"
                                                id="unit" name="unit[]"
                                                multiple class="unit" onchange="get_outlet_default_size(this);"
                                                required>
                                            <?php foreach ($unit as $unit_category) { ?>
                                                <option value="<?php echo $unit_category['id']; ?>"><?php echo $unit_category['unit_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="weight_unit">Volume Unit<span
                                                style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select Container Type"
                                                id="weight_unit"
                                                name="weight_unit" required onchange="getMaxUnit()">
                                            <option value=""></option>
                                            <?php foreach ($volume_unit as $unit_category) { ?>
                                                <option
                                                    value="<?php echo $unit_category['id']; ?>"><?php echo $unit_category['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="volume">Volume<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control float-input" id="volume"
                                               name="volume" required >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="outlet_default_pack_size">Retail Unit<span
                                                style="color: red;">*</span></label>
                                        <select class="form-control" data-placeholder="Select Outlet Default Pack Size"
                                                id="outlet_default_pack_size" name="outlet_default_pack_size" required>
                                            <option value=''></option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="db_default_pack_size">DB Unit<span
                                                style="color: red;">*</span></label>
                                        <select class="form-control" data-placeholder="Select DB Default Pack Size"
                                                id="db_default_pack_size" name="db_default_pack_size" required >
                                            <option value=''></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="sku_waight_value">Pcs Weight(8 OZ)<span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control float-input" id="sku_waight_value"
                                               name="sku_waight_value" required oninput="getPacGrossWeight()">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sku_waight_value">Pack Gross Weight (8 OZ)<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control float-input" id="sku_waight_value_pack"
                                               name="sku_waight_value_pack" required >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="sku_active_status_id">Status <span
                                                style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select Status"
                                                id="sku_active_status_id" name="sku_active_status_id" required>
                                            <option value=""></option>
                                            <?php foreach ($status as $mm) { ?>
                                                <option
                                                    value="<?php echo $mm['id'] ?>"><?php echo $mm['sku_active_status_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sku_creation_date">Creation Date <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="sku_creation_date"
                                               name="sku_creation_date" value="<?php echo date("d-m-Y"); ?>" readonly
                                               required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="sku_launch_date">Launch Date</label>
                                        <input type="text" class="form-control date-picker" id="sku_launch_date"
                                               name="sku_launch_date">
                                    </div>
<!--                                    <div class="col-md-6 form-group">
                                        <label for="sku_expiry_date">Expiry Date</label>
                                        <input type="text" class="form-control" id="sku_expiry_date"
                                               name="sku_expiry_date">
                                    </div>-->
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="lpc_unit">LPC<span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select Weight Unit" id="lpc_unit" name="lpc_unit" required>
                                            <option value=""></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="container_type">Container Type <span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select Container Type"
                                                id="container_type"
                                                name="container_type" required onchange="getMaxUnit()">
                                            <option value=""></option>
                                            <?php foreach ($container as $unit_category) { ?>
                                                <option
                                                    value="<?php echo $unit_category['id']; ?>"><?php echo $unit_category['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

<!--                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="bulk_purchase_price">Invoice Price (Per Pcs) <span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control float-input"
                                               placeholder="Invoice Price (Per Pcs)" id="sku_default_price" 
                                               name="sku_default_price" required oninput="getPacGrossWeight()">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sku_default_price_case">Invoice Price (Case)  <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control float-input"
                                               placeholder="Invoice Price (Case)" id="sku_default_price_case"
                                               name="sku_default_price_case" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="sku_default_price">Trade Price (Per Pcs) <span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control float-input"
                                               placeholder="Trade Price (Per Pcs)" id="trade_price"
                                               name="trade_price" required oninput="getPacGrossWeight()">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sku_default_price">Trade Price (Case)<span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control float-input"
                                               placeholder="Trade Price (Case)" id="trade_price_case"
                                               name="trade_price_case" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="sku_mrp_price">Retail Price (Per Pcs) <span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control float-input"
                                               placeholder="Retail Price (Per Pcs)" id="sku_mrp_price"
                                               name="sku_mrp_price"
                                               required oninput="getPacGrossWeight()">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sku_mrp_price">Retail Price (Case)<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control float-input"
                                               placeholder="Retail Price (Case)" id="sku_mrp_price_case" name="sku_mrp_price_case"
                                               required>
                                    </div>-->
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn blue" id="save">Save</button>
                                    <button type="button" class="btn default"
                                            onclick="document.location.href = '<?php echo site_url('sku/skuIndex'); ?>'">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('footer/footer');
?>
<script>
    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    var max_unit ;


    $('#sku_launch_date').datepicker({
        startDate: today,
        format: 'dd-mm-yyyy',
        autoclose: true
    });
    $('#sku_expiry_date').datepicker({
        startDate: today,
        format: 'dd-mm-yyyy',
        autoclose: true
    });
    function get_outlet_default_size(id){
        var pack_list = $(id).select2('data');

        $("#outlet_default_pack_size").empty();
        $("#db_default_pack_size").empty();
        for (var i = 0; i < pack_list.length; i++) {
            $("#outlet_default_pack_size").append("<option value='" + pack_list[i].id + "'>" + pack_list[i].text + "</option>");
            $("#db_default_pack_size").append("<option value='" + pack_list[i].id + "'>" + pack_list[i].text + "</option>");
        }
    }

    function getMaxUnit(){
        var unit = $("#unit").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>sku/getMaxUnit",
            data: {unit: unit},
            dataType: "html",
            success: function (data) {
                max_unit = data;
            }
        });
    }

    function getPacGrossWeight(){        
        var unit = $("#unit").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>sku/getMaxUnit",
            data: {unit: unit},
            dataType: "html",
            success: function (data) {
                max_unit = data;
                var input = $("#sku_waight_value").val();
                var sku_default_price = $("#sku_default_price").val();
                var trade_price = $("#trade_price").val();
                var sku_mrp_price = $("#sku_mrp_price").val();
                var pack_groww_weight = $("#sku_waight_value_pack").val(input*max_unit);
                var sku_default_price_case = $("#sku_default_price_case").val(sku_default_price*max_unit);
                var trade_price_case = $("#trade_price_case").val(trade_price*max_unit);
                var sku_mrp_price_case = $("#sku_mrp_price_case").val(sku_mrp_price*max_unit);
                var sku_waight_value_pack = $("#sku_waight_value_pack").val(input*max_unit);
            }
        });
    }



</script>
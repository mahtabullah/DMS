<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$data['user_role_code'] = $this->session->userdata('user_role_code');
if ($data['user_role_code'] == 'DB') {
    $readonly = 'readonly';
} else {
    $readonly = '';
}

$this->load->view('left/left', $data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    DB House Configuration
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('db_house/distributionHouseIndex'); ?>">Distribution House</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Create </p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i>Create
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"></a>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" action="" method="post"
                              onsubmit="return validateStandard(this);">
                            <div class="form-body">
                                <h4>DB House Info</h4>
                                <hr>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">Distributor Name:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="dbhouse_name" name="dbhouse_name" value="<?php echo $db_info['dbhouse_name'] ?>" <?php echo $readonly; ?> >
                                        </div>
                                        <label for="po" class="col-md-2">Distributor Code:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="dbhouse_code" name="dbhouse_code" value="<?php echo $db_info['dbhouse_code'] ?>" <?php echo $readonly; ?> >
                                        </div>
                                    </div>
                                </div>

                                <br />
                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">Distributor Description:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" rows="4"
                                                   id="dbhouse_description" name="dbhouse_description" value="<?php echo $db_info['dbhouse_description'] ?>" <?php echo $readonly; ?> >
                                        </div>

                                        <label for="supplier_id" class="col-md-2">Email:</label>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control"
                                                   id="db_email"
                                                   name="db_email" value="<?php echo $db_info['email']; ?>" <?php echo $readonly; ?> >
                                        </div>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">Cluster:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['cluster_name'] ?>" <?php echo $readonly; ?> >
                                        </div>

                                        <label for="supplier_id" class="col-md-2">VAT No:</label>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control "  id="db_email" name="db_email" value="<?php echo $db_info['vat_no']; ?>" <?php echo $readonly;?> >
                                        </div>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">TIN No:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['tin_no'] ?>" <?php echo $readonly;?> >
                                        </div>

                                        <label for="supplier_id" class="col-md-2">Credit Limit (BDT):</label>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control " 
                                                   id="db_email"
                                                   name="db_email" value="<?php echo $db_info['db_credit_limit']; ?>" <?php echo $readonly;?> >
                                        </div>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">Creation Date:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['create_date'] ?>" <?php echo $readonly;?> >
                                        </div>

                                        <label for="supplier_id" class="col-md-2">W/H Manager Name:</label>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control "
                                                   id="db_email"
                                                   name="db_email" value="<?php echo $db_info['wh_manager_name']; ?>" <?php echo $readonly;?> >
                                        </div>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">W/H Contact No:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['wh_manager_contruct_no'] ?>" <?php echo $readonly;?> >
                                        </div>

                                        <label for="supplier_id" class="col-md-2">W/H Address:</label>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control " 
                                                   id="db_email"
                                                   name="db_email" value="<?php echo $db_info['warehouse_address']; ?>" <?php echo $readonly;?> >
                                        </div>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">Office Address:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['office_address'] ?>" <?php echo $readonly;?> >
                                        </div>


                                    </div>
                                </div>
                                <br/>

                                <h4>Owner</h4>
                                <hr>

                                <br/>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">Owner Name:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['distributor_name'] ?>" <?php echo $readonly;?> >
                                        </div>

                                        <label for="supplier_id" class="col-md-2">Owner Address:</label>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control " id="db_email"
                                                   name="db_email" value="<?php echo $db_info['distributor_address']; ?>" <?php echo $readonly;?> >
                                        </div>
                                    </div>
                                </div>

                                <br/>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">Owner Road:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['owner_road'] ?>" <?php echo $readonly;?> >
                                        </div>

                                        <label for="supplier_id" class="col-md-2">Owner Village:</label>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control " placeholder=""
                                                   id="db_email"
                                                   name="db_email" value="<?php echo $db_info['owner_village']; ?>" <?php echo $readonly;?> >
                                        </div>
                                    </div>
                                </div>

                                <br/>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">Owner Division:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['owner_division'] ?>" <?php echo $readonly;?> >
                                        </div>

                                        <label for="supplier_id" class="col-md-2">Owner District:</label>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control "
                                                   id="db_email"
                                                   name="db_email" value="<?php echo $db_info['owner_district']; ?>" <?php echo $readonly;?> >
                                        </div>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">Owner Thana:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['owner_thana'] ?>" <?php echo $readonly;?> >
                                        </div>
                                        <label for="supplier_id" class="col-md-2">Mobile No:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['owner_mobile'] ?>" <?php echo $readonly;?> >
                                        </div>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">Email Address:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['distributor_email'] ?>" <?php echo $readonly;?> >
                                        </div>
                                        <label for="supplier_id" class="col-md-2">Telephone No:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['owner_telephone'] ?>" <?php echo $readonly;?> >
                                        </div>
                                    </div>
                                </div>
                                <br />

                                <h4>Address</h4>
                                <hr>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">Address:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['address_name'] ?>" <?php echo $readonly;?> >
                                        </div>
                                        <label for="supplier_id" class="col-md-2">DB Road:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['db_road'] ?>" <?php echo $readonly;?> >
                                        </div>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">DB Village:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['db_village'] ?>" <?php echo $readonly;?> >
                                        </div>
                                        <label for="supplier_id" class="col-md-2">DB Division:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['db_division'] ?>" <?php echo $readonly;?> >
                                        </div>

                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">DB District:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['db_district'] ?>" <?php echo $readonly;?> >
                                        </div>
                                        <label for="supplier_id" class="col-md-2">DB Thana:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['db_thana'] ?>" <?php echo $readonly;?> >
                                        </div>

                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">DB Union:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['db_union'] ?>" <?php echo $readonly;?> >
                                        </div>
                                    </div>
                                </div>
                                <br/>

                                <h3>GEO Info</h3>
                                <hr>

                                <br/>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">Business Unit:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['business_unit'] ?>" <?php echo $readonly;?> >
                                        </div>
                                        <label for="supplier_id" class="col-md-2">Territory:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['territory'] ?>" <?php echo $readonly;?> >
                                        </div>
                                    </div>
                                </div>
                                <br />

                                <div class="row">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-md-2">CE Area:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo $db_info['ce_area'] ?>" <?php echo $readonly;?> >
                                        </div>
                                    </div>
                                </div>          
                                <br/>

                                <hr>
                                <div class="portlet box purple">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i><?php echo "Bank Info"; ?>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-scrollable">
                                            <table class="table  table-hover" id="bank_info">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Account Holder Name
                                                        </th>
                                                        <th>
                                                            Account No
                                                        </th>
                                                        <th>
                                                            Bank Name
                                                        </th>
                                                        <th>
                                                            Branch Name
                                                        </th>
                                                        <th>
                                                            Bank Type
                                                        </th>
                                                        <th>
                                                            Mobile No
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody id="tbody_cycle_bank_info">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <a class="btn green row_add" id="row_add_bank"
                                                               onclick="add_row_bank()"><i class="fa fa-plus"></i>Add</a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="portlet box purple">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i><?php echo "Asset"; ?>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-scrollable">
                                            <table class="table  table-hover" id="expenseAmount">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Asset Name
                                                        </th>
                                                        <th>
                                                            Asset Market Value
                                                        </th>
                                                        <th>
                                                            QTY
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody id="tbody_cycle">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <a class="btn green row_add" id="row_add"
                                                               onclick="add_row()"><i class="fa fa-plus"></i>Add</a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="portlet box purple">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i> Vehicle
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-scrollable">
                                            <table class="table  table-hover" id="vehicle">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Vehicle Code
                                                        </th>
                                                        <th>
                                                            Vehicle Name
                                                        </th>
                                                        <th>
                                                            Type
                                                        </th>
                                                        <th>
                                                            Reg.Number
                                                        </th>
                                                        <th>
                                                            Driver Name
                                                        </th>
                                                        <th>
                                                            Contact No.(Driver)
                                                        </th>
                                                        <th>
                                                            Exp.Date of Reg.No
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody id="vehicle_tbody">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="7"></td>
                                                        <td>
                                                            <a class="btn green row_add" id="row_add"
                                                               onclick="addVehicleRow()"><i class="fa fa-plus"></i>Add</a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br/>

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
    $(document).ready(function () {
        get_assets_details();
        get_vehicle_details();

        $('#select_hub').hide();
        $('.row_add').hide();
        $('#row_add_bank').hide();

    });

    function get_assets_details()
    {
        var db_id = '<?php echo $this->session->userdata('db_id'); ?>';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getAssetsbyDbId/",
            data: {db_id: db_id},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
//                                        console.log(i);
                    add_row(i);
                    var count = $("#sample tbody tr").length;

                    $('#asset_name' + i).val(data[i].name);
                    $('#asset_amount' + i).val(data[i].market_value);
                    $('#asset_qty' + i).val(data[i].qty);
                    $(".delete").hide();
                }

                //get_salary_calculation(id);

            }
        });
    }
    function get_vehicle_details()
    {
        var db_id = '<?php echo $this->session->userdata('db_id'); ?>';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getVehiclesbyDbId/",
            data: {db_id: db_id},
            dataType: "json",
            success: function (data) {
//                            alert(data.length);
                for (var i = 0; i < data.length; i++) {
                    addVehicleRow();
                    var count = $("#sample tbody tr").length;

                    $('#vehicle_code' + i).val(data[i].vehicle_code);
                    $('#vehicle_name' + i).val(data[i].vehicle_name);
                    $('#reg_no' + i).val(data[i].reg_no);
                    $('#vehicle_type' + i).select2('val', data[i].vehicle_type);
                    $('#driver_name' + i).val(data[i].driver_name);
                    $('#contact_no' + i).val(data[i].contact_no);
                    $('#exp_date' + i).val(data[i].exp_date);
                    $(".delete").hide();
                }

                //get_salary_calculation(id);

            }
        });
    }


//    function get_assets_details()
//        {
//            var outlet_id = '<?php echo $id; ?>';
//            
//        $.ajax({
//                type: "POST",
//                url: "<?php echo base_url(); ?>outlet/get_shop_sign_details/",
//                data: {outlet_id:outlet_id},
//                dataType: "json",
//                
//                    success: function (data) {
//                        for (var i = 0; i < data.length; i++) {
//                            add_row(i);
//                            var count=$("#sample tbody tr").length;
//                            
//                            $('#brand'+ i).select2('val', data[i].brand_id);
//                            $('#shop_sign'+ i).select2('val', data[i].shop_sign_id);
//                            $('#square_feet'+ i).select2('val', data[i].sqf_id);
//                            $('#remuneration'+ i).select2('val', data[i].remuneration_id);
//                            $('#status'+ i).select2('val', data[i].status);
//                            $('#date'+i).val(data[i].installation_date);
//                            
//                        }
//                        
//                        //get_salary_calculation(id);
//                   
//                    }
//                });
//    }


    var count;

    function add_row_bank() {
        count = $("#bank_info tbody tr").length;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/bankInfoRowAdd/",
            data: {count: count},
            dataType: "html",
            success: function (data) {

                $('#bank_info tbody').append(data);
                $("#bank_info tbody select").select2();

            }
        });
    }

    function get_dbh_type() {
        var db_type = $('#db_type').val();

        if (db_type == "6") {
            $('#hub').attr('required', true);
            $('#select_hub').show();
        } else {
            $('#select_hub').css('display', 'none');
            $('#hub').attr('required', false);
        }

    }

    function get_distribution_house() {
        var territory = $('#territory').val();
        $('#hub').empty();
        $('#hub').append('<option value=""></option>');

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getDBHbyterritory/",
            data: {territory: territory},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#hub').append("<option value='" + data[i].id + "'>" + data[i].dbhouse_name + "</option>");
                }
            }
        });
    }

    function add_row() {
        count = $("#expenseAmount tbody tr").length;
        $.ajax({
            type: "POST",
            async: false,
            url: "<?php echo base_url(); ?>db_house/add_po_row/",
            data: {count: count},
            dataType: "html",
            success: function (data) {

                $('#expenseAmount tbody').append(data);
                $("#expenseAmount tbody select").select2();

            }
        });
    }

    function addVehicleRow() {
        count = $("#vehicle tbody tr").length;
        $.ajax({
            type: "POST",
            async: false,
            url: "<?php echo base_url(); ?>db_house/addVehicleRow/",
            data: {count: count},
            dataType: "html",
            success: function (data) {
                $('#vehicle tbody').append(data);
                $("#vehicle tbody select").select2();

            }
        });
    }

    $("#expenseAmount").on('click', '.delete', function () {
        $(this).parent().parent().remove();
    });


    $("#vehicle").on('click', '.delete', function () {
        $(this).parent().parent().remove();
    });

    $("#bank_info").on('click', '.delete', function () {
        $(this).parent().parent().remove();
    });


    $('#business_zone_layer').change(function () {
        var business_zone_layer = $('#business_zone_layer').val();
        //alert(business_zone_layer);
        $('#business_zone_name').empty();
        $('#business_zone_name').append('<option value=""></option>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getBusinessZoneName/",
            data: "business_zone_layer=" + business_zone_layer,
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#business_zone_name').append("<option value='" + data[i].id + "'>" + data[i].biz_zone_name + "</option>");
                }
            }
        });
    });
    $('#business_zone_name').change(function () {
        var business_zone_name = $('#business_zone_name').val();
//                alert(business_zone_name);
        $('#territory').empty();
        $('#territory').append('<option value=""></option>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getTerritoryName/",
            data: "business_zone_name=" + business_zone_name,
            dataType: "json",
            success: function (data) {
                //alert(data);
                for (var i = 0; i < data.length; i++) {
                    $('#territory').append("<option value='" + data[i].id + "'>" + data[i].biz_zone_name + "</option>");
                }
            }
        });
    });


    function get_district() {
        var division = $('#division').val();
        $('#district').empty();
        $('#district').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getDistricts",
            data: {division: division},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#district').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            }
        });
    }

    function get_district1() {
        var division = $('#division1').val();
        $('#district1').empty();
        $('#district1').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getDistricts",
            data: {division: division},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#district1').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            }
        });
    }

    function get_thana() {
        var district = $('#district').val();
        $('#thana').empty();
        $('#thana').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getThana",
            data: {district: district},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#thana').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            }
        });
    }

    function get_thana1() {
        var district = $('#district1').val();
        $('#thana1').empty();
        $('#thana1').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getThana",
            data: {district: district},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#thana1').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            }
        });
    }

    function get_union() {
        var thana = $('#thana').val();
        $('#union').empty();
        $('#union').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getUnion",
            data: {thana: thana},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#union').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            }
        });
    }

    function get_union1() {
        var thana = $('#thana1').val();
        $('#union1').empty();
        $('#union1').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getUnion",
            data: {thana: thana},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#union1').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            }
        });
    }

    function get_village() {
        var union = $('#union').val();
        $('#village').empty();
        $('#village').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getVillage",
            data: {union: union},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#village').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            }
        });
    }

    $('select').change(function () {
        var a = $(this).val();
        if (a == 'add_distributor') {
            $('#model_for_add_distributor').modal('show');
            $('#add_distributor').click(function () {
                var form_data = $('#add_distributor_form').serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>db_house/saveDistributorAndBankAccount/",
                    data: {form_data: form_data, type: 'add_distributor'},
                    dataType: "html",
                    success: function (data) {
                        $("#distributor_id option:last").before(data);
                        $("#distributor_id option:last").prev().attr('selected', true);
                        var c = $("#distributor_id option:last").prev().val();
                        $("#distributor_id").select2('val', c);
                        $('#model_for_add_distributor').modal('hide');
                    }
                });

            });
        }
        //add bank account info script

        if (a == 'add_bank_account') {
            $('#model_for_add_bank_account').modal('show');
            $('#add_bank_account').click(function () {
                var form_data = $('#add_bank_account_form').serialize();

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>db_house/saveDistributorAndBankAccount/",
                    data: {form_data: form_data, type: 'add_bank_account'},
                    dataType: "html",
                    success: function (data) {
                        $("#bank_acount_id option:last").before(data);
                        $("#bank_acount_id option:last").prev().attr('selected', true);
                        var c = $("#bank_acount_id option:last").prev().val();
                        $("#bank_acount_id").select2('val', c);
                        $('#model_for_add_bank_account').modal('hide');
                    }
                });
            });
        }
        // end account add script

    });

    $('#creation_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });

    $('#exp_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });


    $('.date_range').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });


    // Mobile number Validation Checking

    function check() {

        var pass = $('#mobile').val();

        if (pass.length != 11) {
            $("#message").html("Required 11 digits, match requested format!");
        } else {
            $("#message").html('');
        }
    }

    function check_2() {

        var pass = $('#telephone').val();

        if (pass.length != 9) {
            $("#message2").html("Required 9 digits, match requested format!");
        } else {
            $("#message2").html('');
        }
    }

</script>

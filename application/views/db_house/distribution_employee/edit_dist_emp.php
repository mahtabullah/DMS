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
                    Distribution Employee
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('distribution_employee'); ?>">Distribution Employee</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="">Create Distribution Employee</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="row">
            <div class="col-md-12">
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                    <a href="" class="reload"></a>
                    <a href="" class="remove"></a>
                </div>
            </div>
            <?php
//            echo "<pre>";
//            print_r($distribution_employee);
//            echo "</pre>";
            foreach ($distribution_employee as $key) {
                $id = $key['id'];
                $dist_emp_code = $key['dist_emp_code'];
                $first_name = $key['first_name'];
                $middle_name = $key['middle_name'];
                $last_name = $key['last_name'];
                $emp_status = $key['emp_status'];
                $dist_emp_address = $key['dist_emp_address'];
                $dist_role_id = $key['dist_role_id'];
                $manager_id = $key['manager_id'];
                $sales_manager_id = $key['sales_manager_id'];
                $distribution_house_id = $key['distribution_house_id'];
                $login_user_id = $key['login_user_id'];
            }
            $address = $this->method_call->Get_address_names($dist_emp_address);
            foreach ($address as $key) {
                $address_name = $key['address_name'];
            }
            ?>
            <div class="portlet-body form">

                <form role="form" action="<?php $segments = array('distribution_employee', 'edit_dist_emp_done', $id);
            echo site_url($segments); ?>" method="post">
                    <div class="form-body">
                        <input type="hidden" name="emp_address_id" value="<?php echo $dist_emp_address ?>" />
                        <div class="row">
                            <div class="col-md-6">
                                <label for="exampleInputEmail1">Employee Code</label>
                                <input type="text" class="form-control" placeholder="Code" id="dist_emp_code" name="dist_emp_code" value="<?php echo $dist_emp_code; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="exampleInputEmail1">First Name</label>
                                <input type="text" class="form-control" placeholder="Name" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleInputEmail1">Last Name</label>
                                <input type="text" class="form-control" placeholder="" id="middle_name" value="<?php echo $middle_name; ?>" name="middle_name">
                            </div>
                            <!--<div class="form-group">-->
                            <div class="col-md-3">
                                <label for="exampleInputEmail1">Mobile Number</label>
                                <input type="text" class="form-control" placeholder="" id="last_name" value="<?php echo $last_name; ?>" name="last_name">
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="outlet_status">Employee Status <span style="color: red;">*</span></label>
                                    <select class="form-control select2me" data-placeholder="Select..." id="emp_status" name="emp_status" required ">
                                            <option value=""></option>
                                        <option value='1' <?php if ($emp_status) {
                echo 'selected';
            } ?>>Active</option>
                                        <option value='0' <?php if (!$emp_status) {
                echo 'selected';
            } ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="address">Address</label>

                                <input type="text" class="form-control" placeholder="Enter Address here" id="address" value="<?php echo $address_name; ?>" name="address">

                            </div>
                            <div class="col-md-6">
                                <label for="exampleInputPassword1">Role ID</label>
                                <select class="form-control input-medium" data-placeholder="Select..." id="dist_role_id" name="dist_role_id" required onchange="SR()">
                                    <option value="">Choose Role</option>
                                    <?php
                                    foreach ($dist_role_ids as $mm) {

                                        $selected_owner = ($mm['id'] == $dist_role_id) ? " selected='selected'" : "";
                                        echo '<option value="' . $mm['id'] . '"' . $selected_owner . '>' . $mm['dist_role_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <br>

                        <br>
                        <div class="row">

                            <div class="col-md-3">
                                <label for="exampleInputPassword1">User Login ID</label>
                                <!--<div class="col-md-4">-->
                                <select class="form-control input-medium" data-placeholder="Select..." id="login_user_id" name="login_user_id">
                                    <option value="">Choose User Login ID</option>
<?php
foreach ($user_id as $mmss) {
    $selected_owner = ($mmss['id'] == $login_user_id) ? " selected='selected'" : "";
    echo '<option value="' . $mmss['id'] . '"' . $selected_owner . '>' . $mmss['user_name'] . '</option>';
}
?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="exampleInputPassword1">Manager</label>
                                <select class="form-control input-medium" data-placeholder="Select..." id="manager_id" name="manager_id" >
                                    <option value=""></option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="exampleInputPassword1">Sales Manager</label>
                                <!--<div class="col-md-4">-->
                                <select class="form-control input-medium" data-placeholder="Select..." id="sales_manager_id" name="sales_manager_id">
                                    <option value="">Choose Sales Manager</option>
                                    <?php
                                    foreach ($sales_manager_ids as $sm) {
                                        $selected_owner = ($sm['id'] == $sales_manager_id) ? " selected='selected'" : "";
                                        echo '<option value="' . $sm['id'] . '"' . $selected_owner . '>' . $sm['first_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <!--<div class="form-group">-->
                                <label class="control-label" for="message">Area:</label>
                                <select class="form-control" data-placeholder="Select..." id="business_zone_layer" name="business_zone_layer" required>
                                    <option value="">Choose Business Zone</option>
                                    <?php foreach ($business_zone as $business_zone_name) { ?>
                                        <option value="<?php echo $business_zone_name['id'] ?>"><?php echo $business_zone_name['biz_zone_category_name'] ?></option>
                                    <?php } ?>
                                </select>
                                <!--</div>-->

                            </div>
                            <div class="col-md-6">


                                <label class="control-label" for="message">Territory Name:</label>

                                <select class="form-control" id="business_zone_name" name="business_zone_name" onchange="get_db()" required>
                                    <!--<option value="0" selected="selected"></option>-->
                                </select>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="message">Distribution House:</label>  
                                </div>
                                <select class="form-control" id="dbhouse" name="dbhouse" onchange="get_product_line()" required>
                                    <!--<option value="0" selected="selected"></option>-->
                                </select>

                            </div>
                            <br />
                            


                        </div>
                        <br>
                        <br/>


                        <div class="row_sku_element">
                            <div class="col-md-6">
                                <label for="product_line_id">Select</label>
                                <select class="form-control " id="product_line_id" name="product_line_id"  >

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                            </div>
                        </div>




                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Save</button>
                        <a href="<?php echo site_url('distribution_employee/index'); ?>"><button type="button" class="btn default">Cancel</button></a>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div><!--
</div>
</div>-->

<?php
$this->load->view('footer/footer');
?>

<script>
    var biz_zone_id = '<?php echo $zone_info[0]['biz_zone_id']?>';
    var db_id = '<?php echo $zone_info[0]['db_id']?>';
    var pl = '<?php echo $pl;?>';
    var manager_id = '<?php echo $distribution_employee[0]['manager_id']?>';
 
    
$(document).ready(function() {
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>distribution_employee/getParents/",
        data: {id: $('#dist_role_id').val()},
        dataType: "json",
        success: function(data) {
            $('#manager_id').empty();
            $('#manager_id').append("<option value='' ></option>");
            for (var i = 0; i < data.length; i++) {
                $.each(data[i], function(key, val) {
                    $('#manager_id').append("<option  value='" + val.id + "'>" + val.first_name + "</option>");
                });
                $("#manager_id").val(manager_id);
            }
        }
    });
    
    $("#business_zone_layer").val('5');
    $("#business_zone_layer").change();
});



    $('#business_zone_layer').change(function() {
        var business_zone_layer = $('#business_zone_layer').val();
        $('#business_zone_name').empty();
        $('#business_zone_name').append('<option value=""></option>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>business_zone/get_business_zone_name/",
            data: "business_zone_layer=" + business_zone_layer,
            dataType: "json",
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    $('#business_zone_name').append("<option value='" + data[i].id + "'>" + data[i].biz_zone_name + "</option>");
                }
                $("#business_zone_name").val(biz_zone_id);
                get_db();
            }
        });
    });

    function get_db() {
        var biz_zone = $('#business_zone_name').val();
        if ($('#business_zone_layer').val() != '5') {
            alert("Select 'Territory' to get Distribution House");
        }
        else {
            $('#dbhouse').empty();
            $('#dbhouse').append("<option value=''></option>");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>business_zone/get_db_house_name/",
                data: "business_zone_name=" + biz_zone,
                dataType: "json",
                success: function(data) {
                    //console.log(data);
                    for (var i = 0; i < data.length; i++) {
                        $('#dbhouse').append("<option value='" + data[i].id + "'>" + data[i].dbhouse_name + "</option>");
                    }
                    $("#dbhouse").val(db_id);
                    get_product_line();
                }
            });
        }
    }




    //$(".row_sku_element").hide();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>dynamic_filter/load/",
        data: {type: 'geography', target: 'dbhouse'},
        success: function(data) {
            $('#dbhouse_filter').append(data);

        }
    });
    function get_product_line() {
        var db_id = $("#dbhouse").val();

        $('#product_line_id').empty();
        $('#product_line_id').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>distribution_employee/get_product_line/",
            data: {db_id: db_id},
            dataType: "json",
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    //alert(data);
                    $('#product_line_id').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>")
                }
                $("#product_line_id").val(pl)
               
            }
        });

    }

    $('#dist_role_id').change(function() {
    
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>distribution_employee/getParents/",
            data: {id: $('#dist_role_id').val()},
            dataType: "json",
            success: function(data) {
                $('#manager_id').empty();
                $('#manager_id').append("<option value='' selected='selected'></option>");
                for (var i = 0; i < data.length; i++) {
                    $.each(data[i], function(key, val) {
                        $('#manager_id').append("<option value='" + val.id + "'>" + val.first_name + "</option>");
                    });
                    
                }
            }
        });
    });


    function SR() {
        var role = $('#dist_role_id').val();
//alert(role);
        if (role == 7) {
            $(".row_sku_element").show();
        }
        else {
            $(".row_sku_element").hide();
        }


    }
</script>
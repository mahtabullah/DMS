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
            <div class="portlet-body form">
                <form role="form" action="<?php echo site_url('distribution_employee/add_dist_emp'); ?>" method="post">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="exampleInputEmail1">Employee Code</label>
                                <input type="text" class="form-control" placeholder="Code" id="dist_emp_code" name="dist_emp_code" required>
                            </div>
                            <div class="col-md-6">
                                <label for="exampleInputEmail1">First Name</label>
                                <input type="text" class="form-control" placeholder="Name" id="first_name" name="first_name" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="exampleInputEmail1">Middle Name</label>
                                <input type="text" class="form-control" placeholder="" id="middle_name" name="middle_name">
                            </div>
                            <!--<div class="form-group">-->
                            <div class="col-md-6">
                                <label for="exampleInputEmail1">Last Name</label>
                                <input type="text" class="form-control" placeholder="" id="last_name" name="last_name">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="address">Address</label>

                                <input type="text" class="form-control" placeholder="Enter Address here" id="address" name="address">

                            </div>
                            <div class="col-md-6">
                                <label for="exampleInputPassword1">Role ID</label>
                                <select class="form-control input-medium" data-placeholder="Select..." id="dist_role_id" name="dist_role_id" required onchange="SR()">
                                    <option value="">Choose Role</option>
                                    <?php foreach ($dist_role_id as $mm) {
                                        ?>

                                        <option value="<?php echo $mm['id'] ?>"><?php echo $mm['dist_role_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>
                        <br>

                        <br>
                        <div class="row">

                            <div class="col-md-6">
                                <label for="exampleInputPassword1">User Login ID</label>
                                <!--<div class="col-md-4">-->
                                <select class="form-control input-medium" data-placeholder="Select..." id="login_user_id" name="login_user_id">
                                    <option value="">Choose User Login ID</option>
                                    <?php foreach ($user_id as $mmss) { ?>

                                        <option value="<?php echo $mmss['id'] ?>"><?php echo $mmss['user_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="exampleInputPassword1">Manager</label>
                                <select class="form-control input-medium" data-placeholder="Select..." id="manager_id" name="manager_id">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <br>

                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="exampleInputPassword1">Sales Manager</label>
                                <!--<div class="col-md-4">-->
                                <select class="form-control input-medium" data-placeholder="Select..." id="sales_manager_id" name="sales_manager_id">
                                    <option value="">Choose Sales Manager</option>
                                    <?php foreach ($sales_manager_id as $sm) { ?>

                                        <option value="<?php echo $sm['id'] ?>"><?php echo $sm['first_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6" id="dbhouse_filter">
                                <label for="exampleInputPassword1">Distribution House</label>
                            </div>
                            <br>
                            <div class="col-md-6">
                                <button type="button" class="btn blue" onclick="get_territory()">Get Territory</button>
                            </div>
                            <div>
<!--                                <button type="button" class="btn blue" onclick="get_product_line()">Get Product Line</button>-->
                            </div>
<!--                            <div class="form-actions">-->
                            <!--</div>-->

                        </div>
                        <br>
                        <br/>


                        <div class="row_sku_element">
                            <div class="col-md-6">
                                <label for="exampleInputPassword1">Select</label>
                                <select class="form-control input-medium" data-placeholder="Select..." id="territory_id" name="territory_id">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                            </div>
                        </div>



                        <br>
                        <br>
                        <br>
                        <br>

                        <br>

                        <br>

                        <br>

                        <br>




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


                                    $(".row_sku_element").hide();
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>dynamic_filter/load/",
                                        data: {type: 'geography', target: 'dbhouse'},
                                        success: function(data) {
                                            $('#dbhouse_filter').append(data);

                                        }
                                    });
                                    function get_territory() {
                                        var count = $('#select_count').val();
                                        var db_id = $('#layer' + count).val();
                                            //alert(db_id);
                                        $('#territory_id').empty();
//                                            $('#product_line_id').append("<option value=''></option>");

                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo base_url(); ?>distribution_employee/get_territory/",
                                            data: {db_id: db_id},
                                            dataType: "json",
                                            success: function(data) {
                                                for (var i = 0; i < data.length; i++) {
                                                    //alert(data);
                                                    $('#territory_id').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>")
                                                }
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
                                        if (role == 2) {
                                            $(".row_sku_element").show();
                                        }
                                        else {
                                            $(".row_sku_element").hide();
                                        }


                                    }
</script>
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
                    Sales Employee
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sales_employee/sales_emp_index'); ?>">Sales Employee</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="">Create Sales Employee</a>
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
                <form role="form" action="<?php echo site_url('sales_employee/add_sales_emp'); ?>" method="post">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="sales_emp_code">Employee Code <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Code" id="sales_emp_code" name="sales_emp_code" required>
                            </div>
                            <div class="col-md-6">
                                <label for="first_name">Name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Name" id="first_name" name="first_name" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
<!--                            <div class="col-md-6">
                                <label for="middle_name">Middle Name</label>
                                <input type="text" class="form-control" placeholder="" id="middle_name" name="middle_name">
                            </div>-->
                            <!--<div class="form-group">-->
                            <div class="col-md-6">
                                <label for="exampleInputEmail1">Nick Name</label>
                                <input type="text" class="form-control" placeholder="" id="last_name" name="last_name">
                            </div>
                            <div class="col-md-6">
                                <label for="address">Address <span style="color: red;">*</span></label>
                                
                                
                                <input type="text" class="form-control" placeholder="Enter address here" id="address" name="address" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            
                            <div class="col-md-6">
                                <label for="sales_role_id">Role ID <span style="color: red;">*</span></label>
                                <select class="form-control select2me" data-placeholder="Choose Role" id="sales_role_id" name="sales_role_id" onchange="getManager();" required>
                                    <option value=""></option>
                                    <?php foreach ($sales_role_id as $mm) { ?>

                                        <option value="<?php echo $mm['id'] ?>"><?php echo $mm['sales_role_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="login_user_id">User Login ID <span style="color: red;">*</span></label>
                                <!--<div class="col-md-4">-->
                                <select class="form-control select2me" data-placeholder="Choose User Login ID" id="login_user_id" name="login_user_id" required>
                                    <option value=""></option>
                                    <?php foreach ($user_id as $mmss) { ?>
                                        <option value="<?php echo $mmss['id'] ?>" ><?php echo $mmss['user_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>
                        
                        <br>
                        <br>
                        <div class="row">
<!--                            <div class="col-md-6" id="dbhouse_filter">-->
<!--                                <label for="exampleInputPassword1">Business Zone</label>-->
<!--                            </div>-->
                            <div class="col-md-6" >
                                <label for="manager_id">Geo Layer<span style="color: red;">*</span></label>
                                <select class="form-control select2me" data-placeholder="Select..." id="business_zone" name="business_zone" onchange="getGeoLayerElement()" required />
                                <option value=""></option>
                                <?php foreach ($geo_layer as $v) { ?>
                                    <option value="<?php echo $v['id'] ?>" ><?php echo $v['name'] ?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6" >
                                <label for="manager_id">Geo Layer Name<span style="color: red;">*</span></label>
                                <select class="form-control select2me" data-placeholder="Select..." id="business_zone_element" name="business_zone_element" required />
                                <option value=""></option>
                                </select>
                            </div>
                            <br />
                            <div class="col-md-6" id="manager_part">
                                <br />
                                <label for="manager_id">Manager<span style="color: red;">*</span></label>
                                <select class="form-control select2me" data-placeholder="Select..." id="manager_id" name="manager_id" required />
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            
                        </div>
                        <!--</div>-->
                        <div class="form-actions">
                            <button type="submit" class="btn blue">Save</button> 
                            <a href="<?php echo site_url('sales_employee/sales_emp_index'); ?>"><button type="button" class="btn default">Cancel</button></a>
                        </div>
                        <!-- END SAMPLE FORM PORTLET-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$this->load->view('footer/footer');
?>

<script>
    
    function getManager(){
      var sales_role_id = $('#sales_role_id').val();
        if(sales_role_id==1){
            $("#manager_part").css('display','none');
            $("#manager_id").attr('disabled',true);
        }else{
            $("#manager_part").css('display','block');
            $("#manager_id").attr('disabled',false);
        }
        $("#manager_id").empty();
        $("#manager_id").select2('val','');
      
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>sales_employee/getManager/",
        data: {sales_role_id: sales_role_id},
        dataType: "html",
        success: function(data) {
             $("#manager_id").empty();
             $("#manager_id").append(data);
        }
    });
      
    }
    

$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>dynamic_filter/load/",
        data: {type: 'geography', target: 'none'},
        success: function(data) {
            //alert();
            $('#dbhouse_filter').append(data);
        }
    });
    
    
function getGeoLayerElement(){
    var business_zone = $("#business_zone").val();
    $("#business_zone_element").select2('val','');
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>sales_employee/getGeoLayerElement/",
        data: {business_zone: business_zone},
        dataType: "html",
        success: function(data) {
            $("#business_zone_element").empty();
            $("#business_zone_element").append(data);
        }
    });
}

</script>
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
                        <a href="">Edit Sales Employee</a>
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
             
            foreach ($sales_emp as $key) {
                $id = $key['id'];
                $sales_emp_code = $key['sales_emp_code'];
                $first_name = $key['first_name'];
                $middle_name = $key['middle_name'];
                $last_name = $key['last_name'];
                $sales_emp_address = $key['sales_emp_address'];
                $sales_role_id = $key['sales_role_id'];
                $sales_manager_id = $key['sales_manager_id'];
                $login_user_id = $key['login_user_id'];
                $biz_zone_id = $key['biz_zone_id'];
                
            }
            $address_name = $sales_emp_address;
            
//
//            $a = $this->method_call->get_address_by_id($sales_emp_address);
//            if(!empty($a)){
//                foreach ($a as $key1) {
//                $address_name = $key1['address_name'];
//
//
//            }
//        }else{
//            $address_name = '';
//        }
            
            // echo $address_name;
            //  echo "<pre>";
            // print_r($a);
            // echo "</pre>";
            ?>
            <div class="portlet-body form">
                <form role="form" action="<?php $segments = array('sales_employee', 'sales_emp_index_edit_done', $id); echo site_url($segments); ?>" method="post">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="sales_emp_code">Employee Code <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Code" id="sales_emp_code" name="sales_emp_code" value="<?php echo $sales_emp_code;?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="first_name">Name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Name" id="first_name" name="first_name" value="<?php echo $first_name;?>" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="last_name">Nick Name</label>
                                <input type="text" class="form-control" placeholder="" id="last_name" name="last_name" value="<?php echo $last_name;?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="address">Address <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter address here" id="address" name="address" value="<?php echo $address_name;?>" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="sales_role_id">Role ID <span style="color: red;">*</span></label>
                                <select class="form-control select2me" data-placeholder="Choose Role" id="sales_role_id" name="sales_role_id" onchange="getManager();" required>
                                    <option value=""></option>
                                    
                                    <?php
                                    foreach ($sales_role as $key) {
                                        $selected_owner = ($key['id'] == $sales_role_id) ? " selected='selected'" : "";
                                        echo '<option value="'.$key['id'].'"'.$selected_owner.'>'.$key['sales_role_name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="login_user_id">User Login ID <span style="color: red;">*</span></label>
                                <!--<div class="col-md-4">-->
                                <select class="form-control select2me" data-placeholder="Choose User Login ID" id="login_user_id" name="login_user_id" required>
                                    <option value=""></option>
                                    <?php
                                    foreach ($user_id as $key) {
                                        $selected_owner = ($key['id'] == $login_user_id) ? " selected='selected'" : "";
                                        echo '<option value="'.$key['id'].'"'.$selected_owner.'>'.$key['user_name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6" >
                                <label for="manager_id">Geo Layer<span style="color: red;">*</span></label>
                                <select class="form-control select2me" data-placeholder="Select..." id="business_zone" name="business_zone" onchange="getGeoLayerElement()" required />
                                <option value=""></option>
                                <?php
                                foreach ($geo_layer as $key) {
                                    $selected_owner = ($key['id'] == $biz_zone[0]['id']) ? " selected='selected'" : "";
                                    echo '<option value="'.$key['id'].'"'.$selected_owner.'>'.$key['name'].'</option>';
                                }
                                ?>
                                </select>
                            </div>
                            <div class="col-md-6" >
                                <label for="manager_id">Geo Layer Name<span style="color: red;">*</span></label>
                                <select class="form-control select2me" data-placeholder="Select..." id="business_zone_element" name="business_zone_element" required />
                                <option value=""></option>

                                <?php
                                foreach ($biz_zone_element as $key) {
                                    $selected_owner = ($key['id'] == $sales_emp[0]['biz_zone_id']) ? " selected='selected'" : "";
                                    echo '<option value="'.$key['id'].'"'.$selected_owner.'>'.$key['name'].'</option>';
                                }
                                ?>
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

    var sales_manager_id = '<?php echo $sales_manager_id;?>';

    $(document).ready(function(){
        getManager();
    });

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
                $("#manager_id").select2('val',sales_manager_id);
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
<?php
$this->load->view( 'header/header' );
$data[ 'role' ] = $this->session->userdata( 'user_role' );
$this->load->view( 'left/left', $data );
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
                            <a href="<?php echo site_url( 'home/home_page' ); ?>">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="<?php echo site_url( 'db_house/distributionEmployeeIndex' ); ?>">Distribution
                                Employee</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <p>Edit</p>
                        </li>
                    </ul>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            
            <?php
            foreach ($distribution_employee as $key) {
                
                $id = $key['id'];
                $dist_emp_code = $key['dist_emp_code'];
                $first_name = $key['first_name'];
                $middle_name = $key['middle_name'];
                $last_name = $key['last_name'];
                //$emp_status = $key['emp_status'];
                $dist_emp_address = $key['dist_emp_address'];
                $dist_role_id = $key['dist_role_id'];
                $manager_id = $key['manager_id'];
                $sales_manager_id = $key['sales_manager_id'];
                $distribution_house_id = $key['distribution_house_id'];
                $login_user_id = $key['login_user_id'];
                $contact_no = $key['contact_no'];
                $joining_date = $key['joining_date'];
                $designation = $key['designation'];
                $performance_grade = $key['performance_grade'];
                $d_o_b = $key['d_o_b'];
                $email = $key['email'];
                $experience = $key['experience'];
                $emergency_contact_person = $key['emergency_contact_person'];
                $emergency_contact_number = $key['emergency_contact_number'];
                $educational_qualification = $key['educational_qualification'];
                
            }
            foreach ($address as $v)
            {
                $address_id = $v['id'];
                $owner_image = $v['owner_image'];
            }
        ?>
            
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-edit"></i>Edit
                            </div>
                            <div class="tools">
                                <a href="" class="collapse"></a>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" action="<?php $segments = array('db_house', 'edit_dist_emp_done', $id); echo site_url($segments); ?>" method="post"
                                  enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="dist_emp_code">Employee Code<span
                                                    style="color: red;">*</span></label>
                                            <input type="text" class="form-control" placeholder="Code" id="dist_emp_code" name="dist_emp_code" value="<?php echo $dist_emp_code; ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="dist_first_name">Name<span
                                                    style="color: red;">*</span></label>
                                            <input type="text" class="form-control" placeholder="Name" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>
                                        </div>
                                    </div>
                                    <br />

                                    <div class="row">
<!--                                        <div class="col-md-6">
                                            <label for="dist_middle_name">Middle Name</label>
                                            <input type="text" class="form-control" placeholder="" id="dist_middle_name"
                                                   name="dist_middle_name">
                                        </div>-->
                                        <div class="col-md-6">
                                            <label for="dist_last_name">Nick Name</label>
                                            <input type="text" class="form-control" placeholder="" id="last_name" value="<?php echo $last_name; ?>" name="last_name">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="dist_address">Address<span style="color: red;">*</span></label>
                                            <?php foreach($address as $add)
                                            { ?>
                                            <input type="text" class="form-control" placeholder="Enter Address here" id="address" value="<?php echo $add['address_name']; ?>" name="address">
                                            <?php
                                            }
                                            ?>
                                            <input type="hidden" name="address_id" value="<?php echo $address_id?>">
                                        </div>
                                    </div>
                                    <br />

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <label for="dist_role_id">Role ID<span style="color: red;">*</span></label>
                                            <select class="form-control select2me" data-placeholder="Select..."
                                                    id="dist_role_id" name="dist_role_id" 
                                                    onchange="manageUserRoleField();" required>
                                                <option value=""></option>
                                                <?php
                                                foreach ($dist_role_ids as $mm) {

                                                    $selected_owner = ($mm['id'] == $dist_role_id) ? " selected='selected'" : "";
                                                    echo '<option value="' . $mm['id'] . '"' . $selected_owner . '>' . $mm['user_role_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="login_user_id">User Login ID<span
                                                    style="color: red;">*</span></label>
                                            <select class="form-control select2me" data-placeholder="Select..."
                                                    id="login_user_id" name="login_user_id" required>
                                                <option value=""></option>
                                                <?php
                                                foreach ($user_id as $mmss) {
                                                    $selected_owner = ($mmss['id'] == $login_user_id) ? " selected='selected'" : "";
                                                    echo '<option value="' . $mmss['id'] . '"' . $selected_owner . '>' . $mmss['user_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br />
                                    

                                    <div class="row">
                                        
<!--                                        <div class="col-md-6">
                                            <label for="manager_id">Manager<span style="color: red;">*</span></label>
                                            <select class="form-control select2me" data-placeholder="Select..."
                                                    id="manager_id" name="manager_id">
                                                <option value=""></option>
                                                <?php foreach ( $manager_id as $manager_ids ) { ?>
                                                    <option
                                                        value="<?php echo $manager_ids[ 'id' ] ?>"><?php echo $manager_ids[ 'first_name' ] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>-->
                                        <!-- <div class="col-md-6">
                                            <label for="sales_manager_id">Customer Executive<span
                                                    style="color: red;">*</span></label>
                                            <select class="form-control select2me" data-placeholder="Select..."
                                                    id="sales_manager_id" name="sales_manager_id" required>
                                                <option value=""></option>
                                                <?php
                                                foreach ($sales_manager_ids as $sm) {
                                                    $selected_owner = ($sm['id'] == $sales_manager_id) ? " selected='selected'" : "";
                                                    echo '<option value="' . $sm['id'] . '"' . $selected_owner . '>' . $sm['first_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div> -->
                                        <div class="col-md-6" id="dbhouse_filter">
                                            <label for="distribution_point">Distribution House<span style="color: red;">*</span></label>
                                            <select class="form-control select2me" data-placeholder="Select..."
                                                    id="dbhouse_id" name="dbhouse_id" required>
                                                <option value=""></option>
                                                
                                                <?php
                                                foreach ($dbhouse_name as $db) {
                                                    $dbhouse_name1 = ($db['id'] == $distribution_house_id) ? " selected='selected'" : "";
                                                    echo '<option value="' . $db['id'] . '"' . $dbhouse_name1 . '>' . $db['dbhouse_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br />
                                  

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="contact_no">Contact No.</label>
                                            <input type="text" class="form-control integer-input" placeholder="Enter Contact Number"
                                                   id="contact_no" name="contact_no" value="<?php echo $contact_no?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="joining_date">Date of Joining</label>
                                            <input type="text" class="form-control date" id="joining_date" name="joining_date" value="<?php if($joining_date != '1970-01-01'){echo $joining_date;}else{ echo '';};?>">
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="designation">Designation</label>
                                            <input type="text" class="form-control" placeholder="Enter Designation"
                                                   id="designation" name="designation" value="<?php echo $designation?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="performance_grade">Performance Grade</label>
                                            <input type="text" class="form-control" id="performance_grade" name="performance_grade" value="<?php echo $performance_grade;?>">
                                        </div>
                                    </div>
                                    <br />
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="date_of_birth">Date of Birth</label>
                                            <input type="text" class="form-control date" id="date_of_birth" name="d_o_b"
                                                   value="<?php if($d_o_b != '1970-01-01'){echo $d_o_b;}else{ echo '';};?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control" placeholder="Enter Email Address"
                                                   id="email" name="email" value="<?php echo $email?>">
                                        </div>
                                    </div>
                                    <br />
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="experience">Experience</label>
                                            <input type="text" class="form-control" placeholder="Enter Experiences"
                                                   id="experience" name="experience" value="<?php echo $experience?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="emergency_contact">Emergency Contact Person</label>
                                            <input type="text" class="form-control" id="emergency_contact" 
                                                   placeholder="Emergency Contact Person" name="emergency_contact_person" value="<?php echo $emergency_contact_person?>">
                                        </div>
                                    </div>
                                    <br />
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="educational_qualification">Educational Qualification</label>
                                            <input type="text" class="form-control" placeholder="Enter Educational Qualifications"
                                                   id="educational_qualification" name="educational_qualification" value="<?php echo $educational_qualification?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="emergency_contact_number">Emergency Contact Number</label>
                                            <input type="text" class="form-control integer-input" id="emergency_contact_number" 
                                                   placeholder="Emergency Contact Number" name="emergency_contact_number" value="<?php echo $emergency_contact_number?>">
                                        </div>
                                    </div>
                                    
                                    <br />
                                    <br />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="photo">Upload Photo</label>
                                            <input type="file" id="photo" name="photo">
                                            <br />
                                            <img src="<?php echo base_url().'/'.$owner_image?>" height="85" width="85">
                                            <input type="hidden" name="previous_photo" value="<?php echo $owner_image?>">
                                        </div>
                                    </div>
                                    <br />
                              
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Update</button>
                                    <a href="<?php echo site_url( 'db_house/distributionEmployeeIndex' ); ?>">
                                        <button type="button" class="btn default">Cancel</button>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->load->view( 'footer/footer' );
?>

<script>
    function manageUserRoleField(){
        
        var dist_role_id = $('#dist_role_id').val();
        
//        if(dist_role_id == "3"){
//                $('#login_user_id').attr('required', false);
//                $('#login_user_id').attr('disabled', true);
//        }else{
//            $('#login_user_id').attr('required', true);
//            $('#login_user_id').attr('disabled', false);
//        }
            
$.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/get_user_id/",
            data: {dist_role_id: dist_role_id},
            dataType: "json",
            success: function (data) {
                $("#login_user_id").empty();
                $("#login_user_id").append('<option value=""></option>');
                for(var i=0;i<data.length;i++){
                    $("#login_user_id").append('<option value="'+data[i].id+'">'+data[i].user_id+'</option>');
                }
            }
        });
    }

    $('.date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

</script>
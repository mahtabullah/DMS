<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Distributor
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('db_house/distributionEmployeeIndex'); ?>">Distributor Employee</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Detail</p>
                    </li>
                </ul>
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
               
            }
        ?>
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
                        <form role="form" action="<?php $segments = array('db_house', 'edit_dist_emp_done', $id); echo site_url($segments); ?>" method="post">
                            <div class="form-body">
                                <input type="hidden" name="emp_address_id" value="<?php echo $dist_emp_address ?>" />
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="dist_emp_code">Employee Code</label>
                                        <input type="text" class="form-control" placeholder="Code" id="dist_emp_code" name="dist_emp_code" value="<?php echo $dist_emp_code; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" placeholder="Name" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="middle_name">Middle Name</label>
                                        <input type="text" class="form-control" placeholder="" id="middle_name" value="<?php echo $middle_name; ?>" name="middle_name">
                                    </div>                            
                                    <div class="col-md-6">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" placeholder="" id="last_name" value="<?php echo $last_name; ?>" name="last_name">
                                    </div>
                                   <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label" for="emp_status">Employee Status <span style="color: red;">*</span></label>
                                            <select class="form-control select2me" data-placeholder="Select..." id="emp_status" name="emp_status" required ">
                                                    <option value=""></option>
                                                //<?php 
//                                                    if($emp_status = '3'){
//                                                        echo'Active';
//                                                    }else {
//                                                        echo 'Inactive';   
//                                                    }
//                                                ?>
                                            </select>
                                        </div>
                                    </div>-->
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                      
                                        <label for="address">Address</label>
                                        <?php foreach($address as $add)
                                        { ?>
                                        <input type="text" class="form-control" placeholder="Enter Address here" id="address" value="<?php echo $add['address_name']; ?>" name="address">
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dist_role_id">Role ID</label>
                                        <select class="form-control select2me" data-placeholder="Select..." id="dist_role_id" name="dist_role_id" required onchange="SR()">
                                            <option value=""></option>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="login_user_id">User Login ID</label>                                    
                                        <select class="form-control select2me" data-placeholder="Select..." id="login_user_id" name="login_user_id">
                                            <option value=""></option>
                                                <?php
                                                foreach ($user_id as $mmss) {
                                                    $selected_owner = ($mmss['id'] == $login_user_id) ? " selected='selected'" : "";
                                                    echo '<option value="' . $mmss['id'] . '"' . $selected_owner . '>' . $mmss['user_name'] . '</option>';
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="manager_id">Manager</label>
                                        <select class="form-control select2me" data-placeholder="Select..." id="manager_id" name="manager_id" >
                                            <option value=""></option>
                                            <?php
                                                foreach ($manager_ids as $mmss) {
                                                    $selected_owner = ($mmss['id'] == $manager_id) ? " selected='selected'" : "";
                                                    echo '<option value="' . $mmss['id'] . '"' . $selected_owner . '>' . $mmss['first_name'] . '</option>';
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    </div>
                                <br />
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="sales_manager_id">Sales Manager</label>                                        
                                        <select class="form-control select2me" data-placeholder="Select..." id="sales_manager_id" name="sales_manager_id">
                                            <option value=""></option>
                                            <?php
                                            foreach ($sales_manager_ids as $sm) {
                                                $selected_owner = ($sm['id'] == $sales_manager_id) ? " selected='selected'" : "";
                                                echo '<option value="' . $sm['id'] . '"' . $selected_owner . '>' . $sm['first_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                
                                    <div class="col-md-6">                                        
                                        <label for="dbhouse_id">Distribution House:</label>
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
                                <br>
                                <div class="form-actions">
                                  <?php if($user_role_code =='MIS'){ ?>  <a class="btn red" href="<?php echo base_url()?>db_house/distributionEmployeeDeleteById/<?php echo $db_emp_id;?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
								  <?php }?>
                                        <a href="<?php echo site_url('db_house/distributionEmployeeIndex'); ?>"><button type="button" class="btn default">Cancel</button></a>
                                        
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
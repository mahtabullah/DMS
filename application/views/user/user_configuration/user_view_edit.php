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
                    User Configuration
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('user'); ?>">All User</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Edit</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i>Edit 
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"></a>                           
                        </div>
                    </div>
                     <?php 
            
                        foreach ($user as $key) {
                            $id = $key['id'];
                            $user_id = $key['user_id'];
                            $user_name = $key['user_name'];
                            $user_password = $key['user_password'];
                            $user_email = $key['user_email'];

                        }            
                        $group_id = $user_group_by_id['id'];
                        $group_name = $user_group_by_id['user_group_name'];

                        $role_id = $user_role_by_id['id'];
                        $role_name = $user_role_by_id['user_role_name'];
                    ?>
                    <div class="portlet-body form">
                        <form role="form" action="<?php $segments = array('user', 'user_view_edit_done', $id); echo site_url($segments); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="user_name">User Name <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter User Name" name="user_name" id="user_name" required value="<?php echo $user_name;?>">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="user_id">User Login ID : <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="user_id" placeholder="Enter User ID" name="user_id" required value="<?php echo $user_id;?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="user_email">Email </label>
                                        <input type="email" class="form-control" placeholder="Enter User Email" name="user_email" id="user_email" value="<?php echo $user_email;?>">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="user_password">Password <span style="color: red;">*</span></label>
                                        <input type="password" class="form-control" id="user_password" placeholder="Enter User Password" name="user_password" required value="<?php echo $user_password;?>">
                                    </div>
                                </div>                                
                                <div class="row">                        
                                    <div class="col-md-6 form-group">
                                        <label for="user_role_id">Role <span style="color: red;">*</span></label>
                                        <select class="form-control  select2me" data-placeholder="Select..." id="user_role_id" name="user_role_id" required>
                                            <option value=""></option>
                                            <?php
                                            foreach ($tbld_user_role as $key) {
                                                $selected_owner = ($key['id'] == $role_id) ? " selected='selected'" : "";
                                                echo '<option value="'.$key['id'].'"'.$selected_owner.'>'.$key['user_role_name'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>                        
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Update</button>
                                    <button type="button" class="btn default" onclick="document.location.href = '<?php echo site_url('user'); ?>'">Cancel</button>
                                </div>
                                <!-- END SAMPLE FORM PORTLET-->
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
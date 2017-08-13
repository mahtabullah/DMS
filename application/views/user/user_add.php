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
                    User Configuration
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('user'); ?>">All User </a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <label>Create <label>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="tools">
            <a href="" class="collapse"></a>            
        </div>        
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
            <form role="form" action="<?php echo site_url('user/user_save'); ?>" method="post">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="user_name">User Login Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter User Login Name" name="user_name" id="user_name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="user_id">ID</label>
                            <input type="text" class="form-control" id="user_id" placeholder="Enter User ID" name="user_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="user_email">Email <span style="color: red;">*</span></label>
                            <input type="email" class="form-control" placeholder="Enter User Email" name="user_email" id="user_email" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="user_password">Password <span style="color: red;">*</span></label>
                            <input type="password" class="form-control" id="user_password" placeholder="Enter User Password" name="user_password" required>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-md-6 form-group">
                            <label for="user_role_id">Role <span style="color: red;">*</span></label>
                            <select class="form-control  select2me" data-placeholder="Select Role" id="user_role_id" name="user_role_id" required>
                                <option value=""></option>
                                <?php
                                foreach ($tbld_user_role as $tbld_user_role_row) {
                                    echo '<option value="' . $tbld_user_role_row['id'] . '">' . $tbld_user_role_row['user_role_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Save</button>
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
<!--        </div>
    </div>
</div>-->

<?php
$this->load->view('footer/footer');
?>
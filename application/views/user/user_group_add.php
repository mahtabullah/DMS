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
                    Create User Group
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('user/user_group_add'); ?>">Create User Group</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="">Create User Group</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="tools">
            <a href="" class="collapse"></a>
            <a href="#portlet-config" data-toggle="modal" class="config"></a>
            <a href="" class="reload"></a>
            <a href="" class="remove"></a>
        </div>
        <!--</div>-->
        <div class="portlet-body form">
            <form role="form" action="<?php echo site_url('user/user_group_save'); ?>" method="post">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="user_group_name">Name</label>
                            <input type="text" class="form-control" placeholder="Enter User Group Name" name="user_group_name" id="user_group_name">
                        </div>

                        <div class="col-md-6">
                            <label for="user_group_code">Code</label>
                            <input type="text" class="form-control" id="user_group_code" placeholder="Enter User Group Code" name="user_group_code">
                        </div>
                    </div>
                    <br>
                    <div class="row">                        
                        <div class="col-md-6">
                            <label for="user_group_description">Description</label>
                            <input type="text" class="form-control" id="user_group_description" placeholder="Enter User Group Description" name="user_group_description">
                        </div>
                       

                    </div>
                    <br>

                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Add</button>
                        <button type="button" class="btn default" onclick="document.location.href = '<?php echo site_url('user/user_group'); ?>'">Cancel</button>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </form>


        </div>
    </div>
</div>
<!--        </div>
    </div>
</div>-->

<?php
$this->load->view('footer/footer');
?>
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
                    User Role Configuration
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('user/user_role'); ?>">All User Role</a>
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

                        foreach ($user_role as $key) {
                            $id = $key['id'];
                            $user_role_name = $key['user_role_name'];
                            $user_role_code = $key['user_role_code'];
                            $user_role_description = $key['user_role_description'];
                        }
                    ?>
                    
                    <div class="portlet-body form">
                        <form role="form" action="<?php $segments = array('user', 'user_role_view_edit_done', $id); echo site_url($segments); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="user_role_name">Name <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter User Role Name" name="user_role_name" id="user_role_name" value="<?php echo $user_role_name;?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="user_role_code">Code</label>
                                        <input type="text" class="form-control" id="user_role_code" placeholder="Enter User Role Code" name="user_role_code" value="<?php echo $user_role_code;?>">
                                    </div>
                                </div>
                                <br>
                                <div class="row">                        
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Description</label>
                                        <input type="text" class="form-control" id="user_role_description" placeholder="Enter User Role Description" name="user_role_description" value="<?php echo $user_role_description;?>">
                                    </div>
                                </div>
                                <br>                               
                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Update</button>
                                    <button type="button" class="btn default" onclick="document.location.href = '<?php echo site_url('user/user_role'); ?>'">Cancel</button>
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
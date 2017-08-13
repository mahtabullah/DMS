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
                   Distribution Employee Hierarchy
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('db_house/distributionEmployeeHierarchyIndex'); ?>">Distribution Employee Hierarchy</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Create</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->
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
                        <form role="form" action="<?php echo site_url('db_house/saveDistributionEmployeeHierarchy'); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="route_number">Name</label>
                                            <input type="text" class="form-control" id="name" name="dist_role_name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="route_number">Code</label>
                                            <input type="text" class="form-control" id="code" name="dist_role_code" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="route_number">Description</label>
                                            <textarea class="form-control" rows="3" id="description" name="dist_role_description" placeholder="Description" ></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Parent Role</label>
                                            <select class="form-control input-xlarge select2me" data-placeholder="Select..." id="parent_role_id" name="parent_role_id">
                                                <option value=""></option>
                                                <?php
                                                foreach ($dist_role_name as $dist_role_names) {
                                                    echo '<option value="' . $dist_role_names['id'] . '">' . $dist_role_names['dist_role_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="help-block">
                                                select Parent Role
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <!--</div>-->
                            <div class="form-actions">
                                <button type="submit" class="btn blue">Save</button>
                                <button type="button" class="btn default" onclick="document.location.href='<?php echo site_url('db_house/distributionEmployeeHierarchyIndex');?>'">Cancel</button>
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
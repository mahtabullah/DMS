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
                        <p>Edit</p>
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
                            <i class="fa fa-reorder"></i>Edit
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"></a>                            
                        </div>
                    </div>
                    <?php foreach ($distributionEmployeeHierarchyInFoById as $data) {
                        
                        $id = $data['id'];
                        $dist_role_name = $data['dist_role_name'];
                        $dist_role_code = $data['dist_role_code'];
                        $dist_role_description = $data['dist_role_description'];                        
                        $parent_role_id = $data['parent_role_id'];                        
                        }
                        
                    ?>
                    <div class="portlet-body form">                        
                            <form role="form"  action="<?php $segments = array('db_house', 'distributionEmployeeHierarchyUpdateById', $data['id']); echo site_url($segments); ?>" method="post" novalidate>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dist_role_name">Name<span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="dist_role_name" name="dist_role_name" required value="<?php echo $dist_role_name;?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dist_role_code">Code<span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="dist_role_code" name="dist_role_code" required value="<?php echo$dist_role_code; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dist_role_description">Description</label>
                                                <textarea class="form-control" rows="3" id="dist_role_description" name="dist_role_description" placeholder="Description" ><?php echo $dist_role_description ;?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="parent_role_id">Parent Role<span style="color: red;">*</span></label>
                                                <select class="form-control input-xlarge select2me" data-placeholder="Select..." id="parent_role_id" name="parent_role_id" required>
                                                    <option value=""></option>
                                                    <?php   
                                                       foreach ($all_dist_role_name as $key) {
                                                           $selected_owner = ($key['id'] == $parent_role_id) ? " selected='selected'" : "";
                                                           echo '<option value="'.$key['id'].'"'.$selected_owner.'>'.$key['dist_role_name'].'</option>';
                                                           
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
                                    <button type="submit" class="btn blue">Update</button>
                                    <button type="button" class="btn default" onclick="document.location.href='<?php echo site_url('db_house/distributionEmployeeHierarchyIndex');?>'">Cancel</button>
                                </div>
                            </form>
                 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>

<?php
$this->load->view('footer/footer');
?>
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
                    Geographical Hierarchy
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('geographical/geoGraphicalHierarchyIndex'); ?>">Geographical Hierarchy</a>
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
                        <form role="form" action="<?php echo site_url('geographical/saveGeoGraphicalHierarchy'); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code">Code<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="code" name="code" placeholder="Code" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" rows="3" id="description" name="description" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_layer">Parent Layer<span style="color: red;">*</span></label>
                                            <select class="form-control input-xlarge select2me" data-placeholder="Select..." id="parent_layer" name="parent_layer" required>
                                                <option value=""></option>                                                
                                                <?php 
                                                    if($count_row !=0){                                                    
                                                        foreach ($biz_zone as $biz_zone_name) {
                                                            echo '<option value="' . $biz_zone_name['id'] . '">' . $biz_zone_name['biz_zone_category_name'] . '</option>';
                                                        }
                                                    }else {
                                                        echo '<option value="0">No Parent</option>';
                                                    }
                                                ?>
                                            </select>
                                            <span class="help-block">
                                                select Parent Business Layer
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue">Save</button>
                                <button type="button" class="btn default" onclick="document.location.href='<?php echo site_url('geographical/geoGraphicalHierarchyIndex');?>'">Cancel</button>
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
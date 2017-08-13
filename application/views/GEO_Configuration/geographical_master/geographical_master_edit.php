<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    Geographical Master
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>                        
                        <a href="<?php echo site_url('geographical/geoGraphicalMasterIndex'); ?>">Geographical Master</a>
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
                     <?php
                        
                        foreach ($tbld_business_zone as $key) {
                            $id = $key['id'];
                            $biz_zone_name = $key['biz_zone_name'];
                            $biz_zone_code = $key['biz_zone_code'];
                            $biz_zone_description = $key['biz_zone_description'];
                            $biz_zone_category_id = $key['biz_zone_category_id'];
                            $parent_biz_zone_id = $key['parent_biz_zone_id'];
                        }

                    ?>
                    <div class="portlet-body form">
                        <form role="form" action="<?php $segments = array('geographical', 'geoGraphicalMasterUpdateById', $id); echo site_url($segments); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="biz_zone_name">Name<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="biz_zone_name" name="biz_zone_name" value="<?php echo $biz_zone_name;?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="biz_zone_code">Code<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="biz_zone_code" name="biz_zone_code" value="<?php echo $biz_zone_code;?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="biz_zone_description">Description</label>
                                            <textarea class="form-control" rows="3" id="biz_zone_description" name="biz_zone_description" placeholder="Description"><?php echo $biz_zone_description;?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="biz_zone_category_id">Geographical Layer<span style="color: red;">*</span></label>                                            
                                            <select class="form-control input-xlarge select2me" data-placeholder="Select..." id="biz_zone_category_id" name="biz_zone_category_id" required>
                                                <option value=""></option>
                                                <?php
                                                    foreach ($biz_zone as $key) {
                                                            $selected_owner = ($key['id'] == $biz_zone_category_id) ? " selected='selected'" : "";
                                                            echo '<option value="'.$key['id'].'"'.$selected_owner.'>'.$key['biz_zone_category_name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                            <span class="help-block">
                                                select Geographical Layer
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!--</div>-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_biz_zone_id">Parent Business Zone<span style="color: red;">*</span></label>                                            
                                            <select class="form-control input-xlarge select2me" data-placeholder="Select..." id="parent_biz_zone_id" name="parent_biz_zone_id" required>
                                                <option value=""></option>
                                                <?php
                                                        foreach ($biz_zone_names as $key) {
                                                            $selected_owner = ($key['id'] == $parent_biz_zone_id) ? " selected='selected'" : "";
                                                            echo '<option value="'.$key['id'].'"'.$selected_owner.'>['.$key['biz_zone_name'].'] ['.$key['biz_zone_category_name'].']</option>';
                                                    }
                                                ?>
												
                                            </select>
                                            <span class="help-block">
                                                select Parent Business Zone
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue">Update</button>
                                <button type="button" class="btn default" onclick="document.location.href='<?php echo site_url('geographical/geoGraphicalMasterIndex');?>'">Cancel</button>
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
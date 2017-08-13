<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>

<script src="<?php echo base_url(); ?>assets/js/utility_functions.js" type="text/javascript"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Product Hierarchy Element Create
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sku/skuHierarchyElementIndex'); ?>">Product Hierarchy Elements</a>
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
                        <form role="form" action="<?php echo site_url('sku/saveSkuHierarchyElement'); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code">Code<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="code" name="code" required>
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
                                            <label for="sku_layer">Product Layer<span style="color:red;">*</span></label>
                                            <select class="form-control input-xlarge select2me" data-placeholder="Select..." id="sku_layer" name="sku_layer" required>
                                                <option value=""></option>
                                                <?php
                                                foreach ($sku_hierarchy as $sku) {
                                                    echo '<option value="' . $sku['id'] . '">' . $sku['layer_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="help-block"> select SKU Layer </span>
                                        </div>                                        
                                        <label class="col-sm-2 control-label">Attachment </label>
                                        <div class="col-sm-3">
                                            <input type="file" name="upload_files" value="" name="upload_files" id="upload_files" size="25">
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_element">Parent Element</label>                                            
                                            <select class="form-control input-xlarge select2me" data-placeholder="Select..." id="parent_element" name="parent_element">
                                                <option value=""></option>
                                                <?php
                                                foreach ($sku_hierarchy_elements as $sku_elem) {
                                                    echo '<option value="' . $sku_elem['id'] . '">' . $sku_elem['element_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--</div>-->
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue">Save</button>
                                <button type="button" class="btn default" onclick="document.location.href = '<?php echo site_url('sku/skuHierarchyElementIndex'); ?>'">Cancel</button>
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
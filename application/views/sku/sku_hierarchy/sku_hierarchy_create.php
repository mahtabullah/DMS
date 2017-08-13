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
                    Product Hierarchy
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sku/skuHierarchyIndex'); ?>">Product Hierarchy</a>
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
                        <form role="form" action="<?php echo site_url('sku/saveSkuHierarchy'); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder=" Enter Product Hierarchy Name " required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code">Code<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="code" name="code" placeholder=" Enter Product Hierarchy Code " required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" rows="3" id="description" name="description" placeholder=" Enter Product Hierarchy Description "></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_layer">Parent Layer</label>
                                            <select class="form-control input-xlarge select2me" data-placeholder="Select Parent Product Layer " id="parent_layer" name="parent_layer">
                                                <option value=""></option>
                                                <?php
                                                foreach ($sku_hierarchy as $sku) {
                                                    echo '<option value="' . $sku['id'] . '">' . $sku['layer_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="help-block">
                                                <p>select Parent Product Layer</p>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue">Save</button>
                                <button type="button" class="btn default" onclick="document.location.href='<?php echo site_url('sku/skuHierarchyIndex');?>'">Cancel</button>
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
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
                    Product Unit Configuration
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sku/SkuUnitIndex'); ?>">Product Unit Configuration  </a>
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
            <div class="col-md-12">
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
                        <form role="form" action="<?php echo site_url('sku/saveSkuUnit'); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="unit_name">Product Unit Name <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Product Unit Name" name="unit_name" id="unit_name" required />
                                    </div>

                                    <div class="col-md-6">
                                        <label for="unit_short_name">Product Unit Short Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Product Unit Short Name" name="unit_short_name" id="unit_short_name">
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                    <div class="col-md-6">
                                        <label for="unit_code">Product Unit Code <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Product Unit Code" name="unit_code" id="unit_code" required>
                                    </div>                       
                                    <div class="col-md-6">
                                        <label for="unit_description">Product Unit Description</label>
                                        <input type="text" class="form-control" placeholder="Enter Product Unit Description" name="unit_description" id="unit_description">
                                    </div>

                                </div>
                                <br>
<!--                                <div class="row"> 
                                    <div class="col-md-6">
                                        <label for="height">Height <span style="color: red">*</span></label>
                                        <input type="text" class="form-control float-input" placeholder="Enter Product height" name="height" id="height" required />
                                    </div>                       
                                    <div class="col-md-6">
                                        <label for="width">Width <span style="color: red">*</span></label>
                                        <input type="text" class="form-control float-input" placeholder="Enter Product width" name="width" id="width" required />
                                    </div>

                                </div>
                                <br>
                                <div class="row"> 
                                    <div class="col-md-6">
                                        <label for="length">Length <span style="color: red">*</span></label>
                                        <input type="text" class="form-control float-input" placeholder="Enter Product length" name="length" id="length" required />
                                    </div>                       
                                    <div class="col-md-6">
                                        <label for="weight">Weight <span style="color: red">*</span></label>
                                        <input type="text" class="form-control float-input" placeholder="Enter Product weight" name="weight" id="weight" required />
                                    </div>

                                </div>
                                <br>-->
                                <div class="row"> 
                                    <div class="col-md-6">
                                        <label for="unit_code" for="qty">Quantity <span style="color: red">*</span></label>
                                        <input type="text" class="form-control integer-input" placeholder="Enter Product Quantity" name="qty" id="qty">
                                    </div>  
                                </div>
                                <br>
                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Save</button>
                                    <a href="<?php echo site_url('sku/SkuUnitIndex');?>"><button type="button" class="btn default">Cancel</button></a>
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
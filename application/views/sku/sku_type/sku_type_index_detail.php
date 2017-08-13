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
                    Product Type
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>    
                    <li>
                        <a href="<?php echo site_url('sku/skuTypeIndex'); ?>">Product Type</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Edit</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
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
            foreach ($tbld_sku_type as $key) {
                $id = $key['id'];
                $sku_type_name =$key['sku_type_name'];
                $sku_type_code =$key['sku_type_code'];
                $sku_type_description = $key['sku_type_description'];                
            }?>
            <div class="portlet-body form">
                <form role="form" action="<?php $segments = array('sku', 'skuTypeUpdateById', $id); echo site_url($segments); ?>" method="post">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="sku_type_name">Product Type Name<span style="color: red;">*</span></label>
                                <input type="text" class="form-control"  placeholder="Enter Product Type Name" name="sku_type_name" id="sku_type_name" required value="<?php echo $sku_type_name;?>" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="sku_type_code">Product Type Code<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Product Type Code" name="sku_type_code" id="sku_type_code" required value="<?php echo $sku_type_code;?>"  readonly>
								
								
                            </div>
                        </div>                        
                        <div class="row" style="margin-top: 3%">                        
                            <div class="col-md-6">
                                <label for="sku_type_description">Product Type Description</label>
				<textarea class="form-control" rows="3" id="sku_type_description" name="sku_type_description"  placeholder="Enter Product Type Description"  readonly><?php echo $sku_type_description;?></textarea>
                            </div>
                        </div>
                        <div class="form-actions" style="margin-top: 3%">
                            <!--<button type="submit" class="btn blue">Update</button>-->
                            <a class="btn red" href="<?php echo base_url()?>sku/skuTypeDeleteById/<?php echo $sku_type_id;?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                            <a href="<?php echo site_url('sku/skuTypeIndex');?>"><button type="button" class="btn default">Cancel</button></a>
                        </div>
                        <!-- END SAMPLE FORM PORTLET-->
                    </div>
                </form>
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
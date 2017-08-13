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
                    External Product
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sku/externalSkuIndex'); ?>">External Product</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <P>Create</p>
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
                        <form role="form" action="<?php echo site_url('sku/saveExternalSku'); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Creation Date<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="date" name="date" value="<?php echo date("Y-m-d"); ?>" readonly required>
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
                                            <label for="unit">UOM<span style="color: red;">*</span></label>                                            
                                            <select class="form-control select2me" data-placeholder="Select..." id="unit" name="unit" required>
                                                <option value=""></option>
                                                <?php
                                                foreach ($sku_unit_info as $uomunit) {
                                                    echo '<option value="' . $uomunit['id'] . '">' . $uomunit['unit_name'] . '</option>';
                                                }
                                                ?>
                                            </select>                                           
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status<span style="color: red;">*</span></label>                                            
                                            <select class="form-control select2me" data-placeholder="Select..." id="status" name="status" required>
                                                <option value=""></option>
                                                <?php
                                                foreach ($sku_unit_status as $active_inactive) {
                                                    echo '<option value="' . $active_inactive['id'] . '">' . $active_inactive['sku_active_status_name'] . '</option>';
                                                }
                                                ?>
                                            </select>                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue">Save</button>
                                <button type="button" class="btn default" onclick="document.location.href='<?php echo site_url('sku/externalSkuIndex');?>'">Cancel</button>
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
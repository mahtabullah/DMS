<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');
$this->load->view('left/left',$data);
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
                        <a href="<?php echo site_url('Sku/externalSkuIndex'); ?>">External Product</a>
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
                        foreach ($external_sku as $key) {
                            $id = $key['id'];
                            $name = $key['sku_name'];
                            $c_date = $key['sku_creation_date'];
                            $description = $key['sku_description'];
                            $status_id = $key['sku_active_status_id'];
                            $unit = $key['mou_id'];

                        }
                    ?>
                    <div class="portlet-body form">
                        <form role="form" action="<?php $segments = array('Sku', 'externalSkuUpdateById', $id); echo site_url($segments); ?>" method="post" novalidate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Creation Date</label>
                                            <input type="text" class="form-control" id="date" name="date" value="<?php echo $c_date; ?>" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" rows="3" id="description" name="description" placeholder="Description"><?php echo $description;?></textarea>
                                        </div>
                                    </div>                                  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="unit">UOM</label>                                          
                                            <select class="form-control select2me" data-placeholder="Select..." id="unit" name="unit">
                                                <option value=""></option>                                                
                                                    <?php                                                

                                                    foreach ($tbld_unit as $key) {
                                                        $selected_owner = ($key['id'] == $unit) ? " selected='selected'" : "";
                                                        echo '<option value="'.$key['id'].'"'.$selected_owner.'>'.$key['unit_name'].'</option>';
                                                    }
                                                    ?>
                                            </select>
                                         
                                        </div>
                                        <div class="form-group">
                                            <label for="unit">Status</label>                                            
                                            <select class="form-control select2me" data-placeholder="Select..." id="status" name="status">
                                                <option value=""></option>                                                
                                                <?php                                               
                                                
                                                foreach ($status as $key) {
                                                    $selected_owner = ($key['id'] == $status_id) ? " selected='selected'" : "";
                                                    echo '<option value="'.$key['id'].'"'.$selected_owner.'>'.$key['sku_active_status_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                         
                                        </div>
                                     </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue">Update</button>
                                <button type="button" class="btn default" onclick="document.location.href='<?php echo site_url('Sku/externalSkuIndex');?>'">Cancel</button>
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
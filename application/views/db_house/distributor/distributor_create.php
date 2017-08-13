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
                    Distributor
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('db_house/distributorIndex'); ?>">Distributor</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Create</p>
                    </li>
                </ul>
            </div>
        </div>        
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i>Create
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"></a>                           
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form role="form" action="<?php echo site_url('db_house/saveDistributor'); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="distributor_name">Distributor Name<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Distributor Name" id="distributor_name" name="distributor_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="distributor_code">Distributor Code</label>
                                        <input type="text" class="form-control" placeholder="Enter Distributor Code" id="distributor_code" name="distributor_code">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                            <label for="distributor_address">Address</label>
                                            <input type="text" class="form-control" placeholder="Enter Distributor Address" id="distributor_address" name="distributor_address">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mobile_no">Mobile Number</label>
                                        <input type="text" class="form-control integer-input" placeholder="Enter Distributor Mobile Number " id="mobile_no" name="mobile_no">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="distributor_description">Distributor Description</label>
                                        <textarea  class="form-control" rows="4"  placeholder="Enter Distributor Description" id="distributor_description" name="distributor_description"></textarea>
                                    </div>                                    
                                </div>                    
                                <br>
                                <br>
                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Save</button>
                                    <button type="button" class="btn default" onclick="document.location.href='<?php echo site_url('db_house/distributorIndex');?>'">Cancel</button>
                                </div>
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
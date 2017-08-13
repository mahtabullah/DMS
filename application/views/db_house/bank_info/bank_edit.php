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
                    Bank Info
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('db_house/bankIndex'); ?>"> Bank Info</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Edit</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <?php
        foreach ($bank as $key) {
            $id = $key['id'];
            $name = $key['name'];
            $account_no = $key['account_no'];
            $bank_name = $key['bank_name'];
            $branch_name = $key['branch_name'];
            $routing_number = $key['routing_number'];
        }
        ?>
        <div class="row"> 
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i>Edit
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"></a>                           
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form role="form" action="<?php $segments = array('db_house', 'bankUpdateById', $id); echo site_url($segments); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name">Account Holder Name <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Account Holder Name" id="name" name="name" value="<?php echo $name;?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="account_no">Account No <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Account No" id="account_no" name="account_no" value="<?php echo $account_no;?>" required>

                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="bank_name">Bank Name<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Bank Name" id="bank_name" name="bank_name" value="<?php echo $bank_name;?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="branch_name">Branch Name<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Branch Name" id="branch_name" name="branch_name" value="<?php echo $branch_name;?>" required>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="routing_number">Routing Number<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Routing Number " id="routing_number" name="routing_number" value="<?php echo $routing_number;?>" required>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Update</button>
                                    <button type="button" class="btn default" onclick="document.location.href='<?php echo site_url('db_house/bankIndex');?>'">Cancel</button>
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
<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    Change Password
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Change My Password</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i>Change My Password
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"></a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form role="form" action="<?php echo site_url('user/update_user_pass'); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="competitor_name"><h5>Previous Password</h5></label>
                                        <input type="text" class="form-control" id="prev_pass" name="prev_pass" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="competitor_name"><h5>New Password</h5></label>
                                        <input type="text" class="form-control" id="new_pass" name="new_pass" required>
                                    </div>
                                </div>    
                            </div>    
                            <div class="form-actions">
                                <button type="submit" class="btn blue">Save</button>
                                <a href="<?php echo site_url('user/passsChangeIndex'); ?>"><button type="button" class="btn default">Cancel</button></a>
                            </div>                                                        
                            <?php
                            if (isset($msg)) {
                                echo "<label style='color:red;'>" . $msg . "</label>";
                            }
                            ?>
                        </form>
                    </div>        
                </div>    
            </div>
        </div>
    </div>
</div>
<script>
//    $.document.ready(function() {
//        var msg =<?php // echo $msg; ?>;
//        if (msg == "") {
//            alert("Password Updated");
//        }
//    });
</script>

<?php
$this->load->view('footer/footer');
?>
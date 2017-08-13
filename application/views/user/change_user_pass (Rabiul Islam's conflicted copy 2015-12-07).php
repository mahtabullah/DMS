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
                        <a href="">Change My Password</a>
                    </li>
                </ul>
            </div>
        </div>
        <form role="form" action="<?php echo site_url('user/update_user_pass'); ?>" method="post">
            <div class="row">
                <div class="col-md-12">
                    <label for="competitor_name"><h5>Previous Password</h5></label>
                    <input type="text" class="form-control" id="prev_pass" name="prev_pass" required>
                </div>
                <br>
                <div class="col-md-12">
                    <label for="competitor_name"><h5>New Password</h5></label>
                    <input type="text" class="form-control" id="new_pass" name="new_pass" required>
                </div>
            </div>
            <br>
            <br>

            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn blue">Save</button>
                    <a href="<?php echo site_url('user/passsChangeIndex'); ?>"><button type="button" class="btn default">Cancel</button></a>
                </div>
            </div>
            <br><br>
            <?php
            if (isset($msg)) {
                echo "<label style='color:red;'>" . $msg . "</label>";
            }
            ?>
        </form>
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
<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);


?>
<script>
    
</script>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    User Profile
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>

                    <li>
                        <label>User Profile <label>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="tools">
            <a href="" class="collapse"></a>            
        </div>        
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i>Profile
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                </div>
            </div>
            <div style="color: red;">    
                <?php $error_mg= $this->session->userdata('message');
                    if(isset($error_mg)){
                        echo $error_mg;
                        $this->session->unset_userdata('message');
                    }
                ?>
            </div>
            <!--<pre>
                <?php /*print_r($user_details);*/?>
            </pre>-->
        <div class="portlet-body form">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="user_name">User Name </label>
                            <input type="text" class="form-control" readonly value="<?php echo $user_details[0]['user_name']?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="user_id">User Login ID </label>
                            <input type="text" class="form-control" readonly value="<?php echo $user_details[0]['user_id']?>">
                        </div>
                    </div>

                    <div class="row">                        
                        <div class="col-md-6 form-group">
                            <label for="user_id">User Role </label>
                            <input type="text" class="form-control" readonly value="<?php echo $user_details[0]['user_role_name']?>" >
                        </div>
                    </div>

                    <!-- END SAMPLE FORM PORTLET-->
                </div>

        </div>
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
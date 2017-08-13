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
                    DB Type Info
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('db_house/dbTypeIndex'); ?>"> DB Type Info</a>
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
        foreach ($type as $key) {
            $id = $key['id'];
            $name = $key['name'];
            $code = $key['code'];
            $description = $key['description'];
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
                        <form role="form" action="<?php $segments = array('db_house', 'dbTypeUpdateById', $id); echo site_url($segments); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name">Type name<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Account Holder Name" id="name" name="name" value="<?php echo $name;?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="code">Code<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Account No" id="code" name="code" value="<?php echo $code;?>" required>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="description">Description</label>                                        
                                        <textarea class="form-control" rows="3" id="description" name="description" ><?php echo $description;?></textarea>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Update</button>
                                    <button type="button" class="btn default" onclick="document.location.href='<?php echo site_url('db_house/dbTypeIndex');?>'">Cancel</button>
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
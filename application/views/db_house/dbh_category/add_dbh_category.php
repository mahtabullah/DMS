<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Add DBH Category
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('db_house/dbh_category'); ?>">View DBH Category</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="">Add DBH Category</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="tools">
            <a href="" class="collapse"></a>
            <a href="#portlet-config" data-toggle="modal" class="config"></a>
            <a href="" class="reload"></a>
            <a href="" class="remove"></a>
        </div>
        <!--</div>-->
        <div class="portlet-body form">

            <form role="form" action="<?php echo site_url('db_house/dbh_category_add_done'); ?>" method="post">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name">Category Name<span style="color: red">*</span></label>
                            <input type="text" class="form-control" required placeholder="Enter Category Name" name="name" id="name" required />
                        </div>

                        <div class="col-md-6">
                            <label for="code">Category Code<span style="color: red">*</span></label>
                            <input type="text" class="form-control" required placeholder="Enter Category Code" name="code" id="name" required />
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name">Category Description</label>
                            <input type="text" class="form-control" required placeholder="Enter some Description in here.." name="description" id="name" />
                        </div>
                    </div>
                    
                </div>
        
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Add Category</button>
                        <a href="<?php echo site_url('db_house/dbh_category');?>"><button type="button" class="btn default">Cancel</button></a>
                    </div>

        </form>    
        </div>
            
                

        </div>
</div>
<!--        </div>
    </div>
</div>-->

<?php
$this->load->view('footer/footer');
?>
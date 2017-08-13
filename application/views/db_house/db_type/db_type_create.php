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
                            <p>Create</p>
                        </li>
                    </ul>
                    <!-- END PAGE TITLE & BREADCRUMB-->
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
                            <form role="form" action="<?php echo site_url('db_house/saveDbType'); ?>" method="post">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name">Type Name<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Type Name" id="name" name="name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="code">Code<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Code" id="code" name="code" required>

                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="description">Description</label>
                                            <input type="text" class="form-control" placeholder="Enter Description" id="description" name="description">
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="form-actions">
                                        <button type="submit" class="btn blue">Save</button>
                                        <button type="button" class="btn default" onclick="document.location.href='<?php echo site_url('db_house/dbTypeIndex'); ?>'">
                                            Cancel
                                        </button>
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
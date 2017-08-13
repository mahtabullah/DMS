<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>


       
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">Dashboard <small>statistics and more</small></h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li class="pull-right">
                        <div id="dashboard-report-range" class="dashboard-date-range tooltips" data-placement="top" data-original-title="Change dashboard date range">
                            <i class="fa fa-calendar"></i>
                            <span>
                            </span>
                            <i class="fa fa-angle-down"></i>
                            <p id="date_frm" style="visibility: hidden; height: 0px; width: 0px; margin: 0px; padding: 0px;"></p>
                            <p id="date_to" style="visibility: hidden; height: 0px; width: 0px; margin: 0px; padding: 0px;"></p>
                        </div>
                    </li>

                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN DASHBOARD STATS -->

        
       

        
        <?php $this->load->view('footer/footer');?>
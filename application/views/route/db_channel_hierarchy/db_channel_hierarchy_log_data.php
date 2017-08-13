<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    Distribution Channel Hierarchy Log Data
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Distribution Channel Hierarchy Log Data</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>   
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Distribution Channel Hierarchy [Click the table row to show details log]
                </div>
                
            </div>
            <div class="portlet-body">    
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                        <thead>
                            <tr>
                                <th>
                                   Module Name
                                </th>
                                <th>
                                    User Name
                                </th>
                                <th>
                                    User Role Name
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($db_channel_hierarchy_log_data as $keys){ ?>
                            <tr onclick="viewDetails(<?php echo $keys['id']; ?>)">
                                    <td>
                                        <?php echo $keys['object_name']; ?>
                                    </td>
                                    <td>	
                                        <?php 
                                           if(empty($keys['user_name'])){
                                               echo 'Unknown Person';
                                           }else {
                                               echo $keys['user_name']; 
                                           }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        if(empty($keys['user_role_name'])){
                                               echo 'Unknown Role';
                                           }else {
                                               echo $keys['user_role_name']; 
                                           }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $keys['action']; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>   
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<?php
$this->load->view('footer/footer');
?>

<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    Distribution Employee Hierarchy
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Distribution Employee Hierarchy</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Distribution Employee Hierarchy
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('db_house/createDistributionEmployeeHierarchy');?>" class="btn green" id="add_route"><i class="fa fa-plus"></i> Create a Layer</a>
                </div>
            </div>
            <div class="portlet-body">  
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                        <thead>
                            <tr>
                                <th class="bold">
                                    SL No.
                                </th>
                                <th class="bold">
                                    Name
                                </th>
                                <th class="bold">
                                    Code
                                </th>
                                <th class="bold">
                                    Parent
                                </th>
                                <th class="bold">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach ($dist_role_name as $dist_role_names) { $i++; ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php echo $dist_role_names['dist_role_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $dist_role_names['dist_role_code']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (empty($dist_role_names['parent_role_name'])) {
                                            echo "No parent";
                                        } else {
                                            echo $dist_role_names['parent_role_name'];
                                        }                                        
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'db_house/distributionEmployeeHierarchyEditById/'.$dist_role_names['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>
                                        <button class="btn btn-xs red" onclick="ConfirmationWindow('Delete',<?php echo '\''.base_url().'db_house/distributionEmployeeHierarchyDeleteById/'.$dist_role_names['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Delete </button>
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
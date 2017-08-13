<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    DB Journey Plan Hierarchy
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Journey Plan Hierarchy</p>
                    </li>
                    <a href="<?php echo site_url('distribution_channel/dbChannelHierarchyLogData'); ?>">
                    <button class="btn blue" style="float: right;margin-right: -20px;">Log Details</button>
                    </a>
                </ul>
                
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Journey Plan Hierarchy 
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('distribution_channel/createDbChannelHierarchy'); ?>" class="btn green" id="add_route"><i class="fa fa-plus"></i> Create Journey Plan Hierarchy</a>                    
                </div>
            </div>
            <div class="portlet-body">    
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                        <thead>
                            <tr>
                                <th>
                                    Sl No.
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Code
                                </th>
                                <th>
                                    Description
                                </th>

                                <th>
                                    Parent Layer
                                </th>
                                <th>
                                    Action
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sl=1;
                            foreach ($distribution_channel as $keys) { ?>
                            <tr>
                                    <td>
                                        <?php echo $sl; $sl++; ?>
                                    </td>
                                    <td>
                                        <?php echo $keys['distribution_channel_name']; ?>
                                    </td>
                                    <td>	
                                        <?php echo $keys['distribution_channel_code']; ?>
                                    </td>
                                    <td>
                                        <?php echo $keys['distribution_channel_description']; ?>
                                    </td>
                                    <td>
                                        <?php
                                            if(empty($keys['parent_channel_name'])){                                                
                                                echo 'No Parent';
                                            }else {
                                                echo $keys['parent_channel_name'];                                        
                                            }                                            
                                        ?>
                                    </td>
                                    <td class="center">                                       
                                            <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'distribution_channel/distributionChannelEditById/'.$keys['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>                                                                        
                                            <button class="btn btn-xs red" onclick="ConfirmationWindow('Delete',<?php echo '\''.base_url().'distribution_channel/distributionChannelDeleteById/'.$keys['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Delete </button>                                                                        
                                            <!-- ConfirmationWindow function footer/footer.php -->
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

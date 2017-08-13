<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    User Configuration
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>All User </p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>ALL user
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('user/user_add'); ?>" class="btn green" id="add_route"><i class="fa fa-plus"></i> Create User</a>
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
                                    Email
                                </th>                            
                                <th class="bold">
                                    User Role
                                </th>
                                <th class="bold">
                                    User ID
                                </th>
                                <th class="bold">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach ($tbld_user as $key) { $i++; ?>
                                <tr>
                                    <td>
                                          <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php 
                                        echo $key['user_name'];

                                        ?>
                                    </td>
                                    <td>    
                                        <?php 
                                        echo $key['user_email'];                                
                                        ?>
                                    </td>                               
                                    <td>
                                        <?php
                                        $id = $key['id'];
                                        $user_role_by_id = $this->method_call->get_user_role_by_id($id);
                                        if(empty($user_role_by_id)){
                                            $user_role_by_ids = "No Role";
                                        }else{
                                            $user_role_by_ids = $user_role_by_id;
                                        }
                                        echo $user_role_by_ids;
                                        ?>
                                    </td>
                                    <td>    
                                        <?php 
                                        echo $key['user_id'];                                      
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'user/user_view_edit/'.$key['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>
                                        <button class="btn btn-xs red" onclick="ConfirmationWindow('Delete',<?php echo '\''.base_url().'user/user_view_delete/'.$key['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Delete </button>
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

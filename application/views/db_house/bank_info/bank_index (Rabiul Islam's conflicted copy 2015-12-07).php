<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    Bank Info
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Bank Info</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="col-md-4" id="filter">
            
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Bank Info
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('db_house/createBank'); ?>" class="btn green" id="add_route"><i class="fa fa-plus"></i>Create Bank Account</a>
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
                                    Account Holder Name
                                </th>
                                <th class="bold">
                                    Bank Name
                                </th>
                                <th class="bold">
                                    Account No
                                </th>
                                <th class="bold">
                                    Branch Name
                                </th>
                                <th class="bold">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach($bank as $bank_name){ $i++; ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php echo $bank_name['name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $bank_name['bank_name']; ?>
                                    </td>
                                    <td>	
                                        <?php echo $bank_name['account_no']; ?>
                                    </td>
                                    <td>
                                        <?php echo $bank_name['branch_name']; ?>
                                    </td>                               
                                    <td>
                                        <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'db_house/bankEditById/'.$bank_name['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>
                                        <button class="btn btn-xs red" onclick="ConfirmationWindow('Delete',<?php echo '\''.base_url().'db_house/bankDeleteById/'.$bank_name['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Delete </button>
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

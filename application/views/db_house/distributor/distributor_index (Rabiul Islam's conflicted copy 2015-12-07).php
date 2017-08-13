<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    Distributor
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Distributor</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Distributor
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('db_house/createDistributor'); ?>" class="btn green" id="add_route"><i class="fa fa-plus"></i>Create Distributor</a>
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
                                    Address
                                </th>
                                <th class="bold">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>                      
                           
                            <?php  $i=0; foreach ($distributor as $distributor_name) { $i++; ?>
                            
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php echo $distributor_name['distributor_name']; ?>
                                    </td>
                                    <td>
                                        <?php   echo $distributor_name['address_name']; ?>
                                    </td>                                
                                    <td>
                                        <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'db_house/distributorEditById/'.$distributor_name['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>
                                        <button class="btn btn-xs red" onclick="ConfirmationWindow('Delete',<?php echo '\''.base_url().'db_house/distributorDeleteById/'.$distributor_name['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Delete </button>
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
<script type="text/javascript">
    $.ajax({
        type: "POST",
        url: "<?php  echo base_url();  ?>dynamic_filter/load/",
        data: {type: 'geography', target: 'dbhouse'},
        success: function(data) {
            $('#filter').append(data);
        }
    });
</script>
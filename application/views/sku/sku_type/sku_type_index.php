<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    Product Type
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>                    
                    <li>
                        <p>Product Type</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Product Types
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('sku/createSkuType'); ?>" class="btn green" id="add_route"><i class="fa fa-plus"></i> Create Product Type</a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                        <thead>
                            <tr>
                                <th class="center Bold">
                                    SL No.
                                </th>
                                <th class="center Bold">
                                    Name
                                </th>
                                <th class="center Bold">
                                    Code
                                </th>
                                <th class="center Bold">
                                    Description
                                </th>                            
                                <th class="center Bold">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sl=1;
                            foreach ($sku_type as $sku_types) { ?>
                                <tr>
                                    <td class="center">
                                        <?php echo $sl; $sl++;?>
                                    </td>
                                    <td class="center">
                                        <?php echo $sku_types['sku_type_name']; ?>
                                    </td>
                                    <td class="center">	
                                        <?php echo $sku_types['sku_type_code']; ?>
                                    </td>
                                    <td class="center">
                                        <?php echo $sku_types['sku_type_description']; ?>
                                    </td>                                
                                    <td class="center">
                                        <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'sku/skuTypeEditById/'.$sku_types['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>                                    
                                        
                                        <a class="btn btn-xs green" href="<?php echo base_url()?>sku/skuTypeDetailById/<?php echo $sku_types['id'];?>" >Detail</a>
                                        <!--<button  class="btn btn-xs red" onclick="ConfirmationWindow('Delete',<?php echo '\''.base_url().'sku/skuTypeDeleteById/'.$sku_types['id'].'\''; ?>);" ><i class="fa fa-times"></i> Delete</button>-->
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

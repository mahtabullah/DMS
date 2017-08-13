<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    Product Hierarchy Elements
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="">Product Hierarchy ELements</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>        
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Product Hierarchy Elements
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('sku/createSkuHierarchyElement');?>" class="btn green" id="add_route"><i class="fa fa-plus"></i> Create Product Hierarchical Element</a>                    
                </div>
            </div>
                     
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                        <thead>
                            <tr>
                                <th class="center Bold">
                                    SI No
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
                                    Product Layer
                                </th>
                                <th class="center Bold">
                                    Parent
                                </th>
                                <th class="center Bold">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($sku_hierarchy_elements as $sku) { ?>
                                <tr>
                                    <td class="center">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class="center">
                                        <?php echo $sku['element_name']; ?>
                                    </td>
                                    <td class="center">
                                        <?php echo $sku['element_code']; ?>
                                    </td>
                                    <td class="center">
                                        <?php echo $sku['element_description']; ?>                                   
                                    </td>
                                    <td class="center">                                     
                                        <?php
                                          if (empty($sku['parent_element_name'])) {
                                                echo "No parent";
                                            }else{
                                                echo $sku['element_category'];
                                            }
                                        ?>                                   
                                    </td>
                                    <td class="center">                                    
                                        <?php                                   
                                            if (empty($sku['parent_element_name'])) {
                                                echo "No parent";
                                            }else{
                                                echo $sku['parent_element_name'];
                                            }
                                        ?>
                                    </td>
                                    <td class="center">
                                        <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'sku/skuHierarchyElementEditById/'.$sku['sku_hierarchy_element_by_id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>                                    
                                        <button  class="btn btn-xs red" onclick="ConfirmationWindow('Delete',<?php echo '\''.base_url().'sku/skuHierarchyElementDeleteById/'.$sku['sku_hierarchy_element_by_id'].'\''; ?>);" ><i class="fa fa-times"></i> Delete</button>
                                    </td>
                                </tr>
                            <?php $i++;} ?>
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
<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    Product Hierarchy
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Product Hierarchy</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-outdent"></i>Product Hierarchy
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('sku/createSkuHierarchy'); ?>" class="btn green" id="add_product_hierarchy_layer"><i class="fa fa-plus"></i> Create A Product Hierarchy Layer</a>
                </div>
            </div>            
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                        <thead>
                            <tr>
                                <th  class="center bold">
                                    SI No
                                </th>
                                <th  class="center bold">
                                    Name
                                </th>
                                <th  class="center bold">
                                    Code
                                </th>
                                <th  class="center bold">
                                    Description
                                </th>
                                <th  class="center bold">
                                    Parent
                                </th>
                                <th  class="center bold">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($sku_hierarchy as $sku) { ?>
                                <tr>
                                    <td class="center">
                                        <?php echo $i; ?>
                                    </td>
                                    <td  class="center">
                                        <?php echo $sku['layer_name']; ?>
                                    </td>
                                    <td  class="center">
                                        <?php echo $sku['layer_code']; ?>
                                    </td>
                                    <td  class="center">
                                        <?php echo $sku['layer_description']; ?>
                                    </td>
                                    <td  class="center">
                                        <?php
                                        if (empty($sku['parent_layer_name'])) {
                                            echo "No parent";
                                        } else {
                                            echo $sku['parent_layer_name'];
                                        }
                                        ?>
                                    </td>
                                    <td  class="center">                                    
                                        <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'sku/skuHierarchyEditById/'.$sku['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>                                    
                                        <button class="btn btn-xs green" onclick="ConfirmationWindow('See Detail',<?php echo '\''.base_url().'sku/skuHierarchyDetailById/'.$sku['id'].'\''; ?>);" ><i class="fa fa-outdent"></i> Detail </button>                                    
                                        <!--<button  class="btn btn-xs red" onclick="ConfirmationWindow('Delete',<?php echo '\''.base_url().'sku/skuHierarchyDeleteById/'.$sku['id'].'\''; ?>);" ><i class="fa fa-times"></i> Delete</button>-->
                                        <!-- ConfirmationWindow function footer/footer.php -->
                                    </td>
                                </tr>
                                <?php $i++;
                            } ?>
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

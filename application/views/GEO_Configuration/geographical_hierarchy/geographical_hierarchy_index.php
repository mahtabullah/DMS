<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    Geographical Hierarchy
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Geographical Hierarchy</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Geographical Hierarchy
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('geographical/createGeoGraphicalHierarchy');?>" class="btn green" id="add_route"><i class="fa fa-plus"></i> Create Graphical Hierarchy</a>
                    
                </div>
            </div>
            <div class="portlet-body">
               
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
                        <?php $i=1; foreach ($biz_zone as $biz) { ?>
                            <tr>
                                <td>
                                    <?php echo $i; ?>
                                </td>
                                <td>
                                    <?php echo $biz['biz_zone_category_name']; ?>
                                </td>
                                <td>
                                    <?php echo $biz['biz_zone_category_code']; ?>
                                </td>
                                <td>
                                    <?php
                                    
                                        if(empty($biz['parent_category_name'])){
                                            echo "No parent";
                                        }else{
                                            echo $biz['parent_category_name'];
                                        }
                                      
                                    ?>
                                </td>
                                <td class="">                                       
                                    <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'geographical/geoGraphicalHierarchyEditById/'.$biz['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>                                    
                                    <!--<button  class="btn btn-xs red" onclick="ConfirmationWindow('Delete',<?php echo '\''.base_url().'geographical/geoGraphicalHierarchyDeleteById/'.$biz['id'].'\''; ?>);" ><i class="fa fa-times"></i> Delete</button>-->
                                    <!-- ConfirmationWindow function footer/footer.php -->
                                </td>
                            </tr>
                        <?php $i++;} ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<?php
$this->load->view('footer/footer');
?>
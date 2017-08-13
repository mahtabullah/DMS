<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');
$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    Geographical Master
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Geographical Master</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <select class="form-control input-xlarge select2me" data-placeholder="Select..." id="biz_zones" onchange="get_data();">
                    <option value="">All</option>
                    <?php foreach ($biz_zone as $biz_zones) { ?>
                        <option value="<?php echo $biz_zones['id'] ?>"><?php echo $biz_zones['biz_zone_category_name'] ?></option>
                    <?php } ?>
                </select>
                <span class="help-block">
                    Select Business Zone Layer
                </span>
                <br>
            </div>
        </div>
        <div class="row">
            <div id="exp"></div>
        </div>
        
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Geographical Master
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('geographical/createGeoGraphicalMaster'); ?>" class="btn green" id="add_route"><i class="fa fa-plus"></i> Create Graphical Master</a>                   
                </div>
            </div>

            <div class="portlet-body">                
                <div id="table_data">
                    <div class="table-scrollable">
                        <table id = "sample_2" class="table table-striped table-bordered table-hover table-full-width">
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
                                        Geographical Layer
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
                                <?php 
                                    $i=0;
                                foreach ($biz_zone_name as $biz) { $i++;
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <?php echo $biz['ZONE_NAME']; ?>
                                        </td>
                                        <td>
                                            <?php echo $biz['biz_zone_code']; ?>
                                        </td>
                                        <td>
                                            <?php                                    
                                                if(empty($biz['biz_zone_category_name'])){
                                                    echo 'No Layer';                                        
                                                }else{
                                                    echo $biz['biz_zone_category_name'];
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if(empty($biz['biz_zone_name'])){
                                                    echo 'No Parent Zone';                                        
                                                }else{
                                                    echo $biz['biz_zone_name'];
                                                }
                                            ?>
                                        </td>                                
                                        <td>                                       
                                            <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'geographical/geoGraphicalMasterEditById/'.$biz['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>                                    
                                            <button class="btn btn-xs green" onclick="ConfirmationWindow('See Detail',<?php echo '\''.base_url().'geographical/geoGraphicalMasterDetailById/'.$biz['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Detail </button>                                    
                                            <!--<button  class="btn btn-xs red" onclick="ConfirmationWindow('Delete',<?php echo '\''.base_url().'geographical/geoGraphicalMasterDeleteById/'.$biz['id'].'\''; ?>);" ><i class="fa fa-times"></i> Delete</button>-->
                                            <!-- ConfirmationWindow function footer/footer.php -->
                                        </td>
                                    </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>        
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<?php
$this->load->view('footer/footer');
?>
<script>
    function get_data(){
       var geo_id = $('#biz_zones').val();
       $('#ajax_load').css("display","block");
        $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>geographical/getFilterData/",
                data: {geo_id: geo_id},
                success: function(data) {
                    $('#table_data').empty();
                    $('#table_data').append(data);
                    $('#ajax_load').css("display","none");
                }
            });
    }
 	
</script>
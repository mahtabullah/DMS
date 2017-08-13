<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    Product Unit Configuration 
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Product Unit Configuration </p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Product Unit
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('sku/createSkuUnit'); ?>" class="btn green" id="add_route"><i class="fa fa-plus"></i> Create Product Package</a>                   
                </div>
            </div>
            <div class="portlet-body"> 
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                        <thead>
                            <tr>
                                <th class="Bold">
                                    SL No.
                                </th>
                                <th class="Bold">
                                    Name
                                </th>
                                <th class="Bold">
                                    Short Name
                                </th>
                                <th class="Bold">
                                    Code
                                </th>
                                <th class="Bold">
                                    Description
                                </th>
                                <th class="Bold">
                                    Quantity
                                </th>
<!--                                <th class="Bold">
                                    Height
                                </th>
                                <th class="Bold">
                                    Width
                                </th>
                                <th class="Bold">
                                    Length
                                </th>
                                <th class="Bold">
                                    Weight
                                </th>-->
                                <th class="Bold">
                                    Action
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach ($sku_unit as $key) { $i++; ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php echo $key['unit_name']; ?>
                                    </td>
                                    <td>	
                                        <?php echo $key['unit_short_name']; ?>
                                    </td>
                                    <td>    
                                        <?php echo $key['unit_code']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $key['unit_description'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $key['qty']; ?>
                                    </td>                                 
<!--                                    <td>
                                        <?php //echo $key['height']; ?>
                                    </td>                                 
                                    <td>
                                        <?php //echo $key['width']; ?>
                                    </td>                                 
                                    <td>
                                        <?php //echo $key['length']; ?>
                                    </td>                                 
                                    <td>
                                        <?php //echo $key['weight']; ?>
                                    </td>                                 -->
                                    <td  class="center">                                    
                                        <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'sku/skuUnitEditById/'.$key['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>                                    
                                        <button  class="btn btn-xs red" onclick="ConfirmationWindow('Delete',<?php echo '\''.base_url().'sku/skuUnitDeleteById/'.$key['id'].'\''; ?>);" ><i class="fa fa-times"></i> Delete</button>
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
<script type="text/javascript">
    $.ajax({
        type: "POST",
        url: "<?php  echo base_url();  ?>dynamic_filter/load/",
        data: {type: 'geography', target: 'none'},
        success: function(data) {
            $('#filter').prepend(data);
        }
    });
    
    function get_filter_data(){
        $('#view-table tbody').empty();
        var num = $('#select_count').val();
        alert(num);
        alert($('#layer'+num+'').val());
//            $.ajax({
//                type: "POST",
//                url: "<?php echo base_url(); ?>distribution_house/getFilterData/",
//                data: {id: $('#layer'+num+'').val()},
//                success: function(data) {
//                    $('#view-table').append(data);
//                }
//            });
    }
</script>
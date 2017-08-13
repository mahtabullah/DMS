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
                    View DBH Categories
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="">View DBH Categories</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>View DBH Categories
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('db_house/dbh_category_add'); ?>" class="btn green" id="add_route"><i class="fa fa-plus"></i> Add Categories</a>
                    <!--<a href="#" class="btn yellow"><i class="fa fa-print"></i> Print</a>-->
                </div>
            </div>
            <div class="portlet-body">
               
                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                    <thead>
                        <tr>
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
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($category as $key) { ?>
                            <tr>

                                <td>
                                    <?php echo $key['name']; ?>
                                </td>
                                <td>	
                                    <?php echo $key['code']; ?>
                                </td>
                                <td>    
                                    <?php echo $key['description']; ?>
                                </td>
                                
                                <td class="">
                                    <a href="<?php
                                    $segments = array('db_house', 'dbh_category_edit',$key['id']);
                                    echo site_url($segments);
                                    ?>" data-id="1" class="btn btn-xs blue btn-editable" onclick="return confirm('Are you sure Edit this item?')"><i class="fa fa-pencil"></i> Edit</a>
                                    <a href="<?php
                                    $segments = array('db_house', 'dbh_category_delete',$key['id']);
                                    echo site_url($segments);
                                    ?>" data-id="1" class="btn btn-xs red btn-editable" onclick="return confirm('Are you sure you want to delete this item?')"><i class="fa fa-times"></i> Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
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
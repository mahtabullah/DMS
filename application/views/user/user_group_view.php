<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);

?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h3 class="page-title">
                    ALL User Group
                </h3>
                <!-- END PAGE TITLE & BREADCRUMB-->
               
                
            </div>
        </div>
        <div class="col-md-4" id="filter" style="margin-bottom: 5%;">
            <a href="javascript:;" data-id="1" class="btn btn-xs blue btn-editable" onclick="get_filter_data()"> Search</a>
        </div>

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>ALL User Group
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('user/user_group_add'); ?>" class="btn green" id="add_route"><i class="fa fa-plus"></i> Create User Group</a>
                    <!--<a href="#" class="btn yellow"><i class="fa fa-print"></i> Print</a>-->
                </div>
            </div>
            <div class="portlet-body">
             
                <table class="table table-striped table-bordered table-hover" id="view-table">
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
                        <?php foreach ($tbld_user_group as $tbld_user_group_row) { ?>
                            <tr>

                                <td>
                                    <?php echo $tbld_user_group_row['user_group_name']; ?>
                                </td>
                                <td>    
                                    <?php echo $tbld_user_group_row['user_group_code']; ?>
                                </td>

                                <td>
                                    <?php
                                    echo $tbld_user_group_row['user_group_description'];
                                    
                                    ?>
                                </td>
                                
                                

                                <td class="">
                                    <a href="<?php
            $segments = array('user', 'user_group_view_edit',$tbld_user_group_row['id']);
            echo site_url($segments);
            ?>" data-id="1" class="btn btn-xs blue btn-editable" onclick="return confirm('Are you sure Edit this item?')"><i class="fa fa-pencil"></i> Edit</a>
            <a href="<?php
            $segments = array('user', 'user_group_view_delete',$tbld_user_group_row['id']);
            echo site_url($segments);
            ?>" data-id="1" class="btn btn-xs blue btn-editable" onclick="return confirm('Are you sure you want to delete this item?')"><i class="fa fa-times"></i> Delete</a>
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
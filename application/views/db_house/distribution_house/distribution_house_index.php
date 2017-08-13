<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <h3 class="page-title">
                    DB House Configuration
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Distribution House</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Distribution House
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('db_house/createDistributionHouse'); ?>" class="btn green" id="add_route"><i class="fa fa-plus"></i> Create Distribution House</a>                   
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
                                Code
                            </th>
                            <th class="center Bold">
                                Name
                            </th>
                            <th class="center Bold">
                                Owner
                            </th>
                            <th class="center Bold">
                                Address
                            </th>
                            <th class="center Bold">
                                Mobile No.
                            </th>
                            <th class="center Bold">
                                Create Date
                            </th>
                            <th class="center Bold">
                                Status
                            </th>
                            <th class="center Bold">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  $sl = 1;
                        foreach ($db_house as $db_house_name) { ?>
                            <tr>
                                <td class="center">
                                    <?php echo $sl; $sl++;?>
                                </td>
                                <td class="center">	
                                    <?php echo $db_house_name['dbhouse_code']; ?>
                                </td>
                                <td class="center">
                                    <?php echo $db_house_name['dbhouse_name']; ?>
                                </td>
                                <td class="center">
                                    <?php echo $db_house_name['distributor_name']; ?>
                                </td>
                                <td class="center">
                                    <?php echo $db_house_name['address_name']; ?>
                                </td>
                                <td class="center">
                                    <?php echo $db_house_name['mobile1']; ?>
                                </td>
                                <td class="center">
                                    <?php  echo $db_house_name['create_date'];?>
                                </td>
                                <td class="center">
                                    <?php  echo $db_house_name['db_house_status_name'];  ?>
                                </td>
                                <td class="center">                                       
                                    <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'db_house/dbHouseEditById/'.$db_house_name['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button><br />
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
                    url: "<?php echo base_url(); ?>dynamic_filter/load/",
                    data: {type: 'geography', target: 'none'},
                    success: function(data) {
                        $('#filter').prepend(data);
                    }
                });

                function get_filter_data() {
                    $('#view-table tbody').empty();
                    var num = $('#select_count').val();
                    var id = $('#layer' + num + '').val();
                    var id_int = parseInt(num) - 1;
                    if (id == '') {
                        id = $('#layer' + id_int + '').val();
                    }

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>distribution_house/getFilterData/",
                        data: {id: id},
                        success: function(data) {
                            $('#view-table').append(data);
                        }
                    });
                }
</script>
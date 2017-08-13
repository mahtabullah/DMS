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
                    Sales Employees
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="">Sales Employees</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!--        <div class="row">
                    <div class="col-md-4">
                        <select class="form-control input-xlarge select2me" data-placeholder="Select..." id="biz_zones">
                            <option value="">All</option>
        <?php // foreach ($biz_zone as $biz_zones) {  ?>
                                <option value="<?php // echo $biz_zones['id']   ?>"><?php // echo $biz_zones['biz_zone_category_name']   ?></option>
        <?php // }  ?>
                        </select>
                        <span class="help-block">
                            Select Business Zone Layer
                        </span>
                        <br>
                    </div>
                </div>-->
        <div class="row">
            <div id="exp"></div>
        </div>
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Sales Employees
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('sales_employee/create_sales_emp'); ?>" class="btn green"><i class="fa fa-plus"></i> Create HO Employee</a>
                    <!--<a href="#" class="btn yellow"><i class="fa fa-print"></i> Print</a>-->
                </div>
            </div>
            <div class="portlet-body">
                
                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                    <thead>
                        <tr>
                            <th>
                                SL No.
                            </th>
                            <th>
                                First Name
                            </th>
                            <th>
                                Employee Code
                            </th>
                            <th>
                                Address
                            </th>
                            <th>
                                Role
                            </th>
                            <th>
                                Manager
                            </th>
                            <th>
                                User Login ID
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0; $sl = 1;
                        foreach ($sales_emp as $emp) {
                            ?>
                            <tr>
                                <td class="center">
                                    <?php echo $sl; $sl++;?>
                                </td>
                                <td>
                                    <?php echo $emp['first_name']; ?>
                                </td>
                                <td>
                                    <?php echo $emp['sales_emp_code']; ?>
                                </td>
                                <td>
                                    <?php echo $emp['sales_emp_address']; ?>
                                </td>
                                <td>
                                    <?php
                                    $role_id = $this->method_call->getEmpRoleById($emp['sales_role_id']);
                                    foreach ($role_id as $role) {
                                        echo $role['sales_role_name'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $manager_id = $this->method_call->getSalesEmpNameById($emp['sales_manager_id']);
                                    foreach ($manager_id as $mn) {
                                        echo $mn['first_name'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $user_id = $this->method_call->getUserById($emp['login_user_id']);
                                    foreach ($user_id as $usr) {
                                        echo $usr['user_name'];
                                    }
                                    ?>
                                </td>

                                <td class="">
                                    <a href="<?php
                                    $segments = array('sales_employee', 'sales_emp_index_edit',$emp['id']);
                                    echo site_url($segments);
                                    ?>" data-id="1" class="btn btn-xs blue btn-editable" onclick="return confirm('Are you sure Edit this item?')"><i class="fa fa-pencil"></i> Edit</a>
                                    <a href="<?php
                                    $segments = array('sales_employee', 'sales_emp_index_delete',$emp['id']);
                                    echo site_url($segments);
                                    ?>" data-id="1" class="btn btn-xs red btn-editable" onclick="return confirm('Are you sure you want to delete this item?')"><i class="fa fa-times"></i> Delete</a>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
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
<script>
    $('#biz_zones').change(function() {
        $('#view-table tbody').empty();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>geographical_master/getFilterData/",
            data: {id: $('#biz_zones').val()},
            success: function(data) {
                $('#view-table').append(data);
            }
        });
//            $.ajax({
//                type: "POST",
//                url: "<?php // echo base_url();    ?>dynamic_filter/load/",
//                data: {type:'geography',target: 'dbhouse'},
//                success: function(data) {
//                    $('#exp').append(data);
//                }
//            });
    });
</script>
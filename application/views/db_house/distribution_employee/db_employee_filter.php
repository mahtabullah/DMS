<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/30/17
 * Time: 5:33 PM
 */
?>



<div class="portlet box purple">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>Distribution Employees
        </div>

        <div class="actions">
            <a href="<?php echo site_url( 'db_house/createDistributionEmployee' ); 
			$user_role_code = $this->session->userdata('user_role_code');
			?>" class="btn green"><i
                    class="fa fa-plus"></i> Create Distribution Employee</a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="table-scrollable">


            <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                <thead>
                <tr>
                    <th class="bold">
                        SL No.
                    </th>
                    <th class="bold">
                        CE Area
                    </th>
                    <th class="bold">
                        CE Name
                    </th>
                    <th class="bold">
                        Distributor Name
                    </th>
                    <th class="bold">
                        Employee Name
                    </th>
                    <th class="bold">
                        Employee Type
                    </th>
                    <th class="bold">
                        User Name
                    </th>
                    <th class="bold">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php $sl = 1;
                foreach ( $dist_emp as $emp ) { ?>
                    <tr>
                        <td>
                            <?php echo $sl;
                            $sl++; ?>
                        </td>
                        <td>
                            <?php echo $emp[ 'ce_area' ]; ?>
                        </td>
                        <td>
                            <?php echo $emp[ 'ce_name' ]; ?>
                        </td>
                        <td>
                            <?php echo $emp[ 'dbhouse_name' ]; ?>
                        </td>
                        <td>
                            <?php echo $emp[ 'distributor_employee_name' ]; ?>
                        </td>
                        <td>
                            <?php echo $emp[ 'employee_type' ]; ?>
                        </td>
                        <td>
                            <?php echo $emp[ 'user_name' ]; ?>
                        </td>
                        <td>
						<?php if($user_role_code =='MIS'){ ?>
                            <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'db_house/distributionEmployeeEditById/'.$emp['id'].'\'';  ?>);" ><i class="fa fa-pencil"></i> Edit </button>
						<?php }?>
                            <button class="btn btn-xs green" onclick="ConfirmationWindow('See Detail',<?php echo '\''.base_url().'db_house/distributionEmployeeDetailById/'.$emp['id'].'\'';  ?>);" ><i class="fa fa-outdent"></i> Detail </button>
                            <?php if($emp['id'] <> $emp_id){?>
                                <!--                                        <button class="btn btn-xs red"
                                                onclick="ConfirmationWindow('Delete',<?php echo '\'' . base_url() . 'db_house/distributionEmployeeDeleteById/' . $emp[ 'id' ] . '\''; ?>);">
                                            <i class="fa fa-pencil"></i> Delete
                                        </button>-->
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

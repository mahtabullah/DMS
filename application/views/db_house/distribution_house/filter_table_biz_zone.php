<tbody>
    <?php
//    if (isset($dbhouse)) {
    for ($i = 0; $i < count($dbhouse); $i++) {
        foreach ($dbhouse[$i] as $db) {
            ?>
            <tr>
                <td>
                    <?php echo $db['dbhouse_name']; ?>
                </td>
                <td>
                    <?php echo $db['dbhouse_code']; ?>
                </td>
                <td>
                    <?php
                    $distributor_id = $db['distributor_id'];
                    $distributor_name = $this->method_call->Get_Dbhouse_owner_name($distributor_id);
                    foreach ($distributor_name as $distributor_names) {
                        echo $distributor_names['distributor_name'];
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $id = $db['id'];
                    //echo $id;
                    $Biz_zone_name = $this->method_call->Get_Dbhouse_Biz_zone_name($id);
                    foreach ($Biz_zone_name as $Biz_zone_names) {
                        echo $Biz_zone_names['biz_zone_name'];
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $status_id = $db['db_house_status'];
                    $Dbhouse_Status = $this->method_call->Get_Dbhouse_Status($status_id);
                    foreach ($Dbhouse_Status as $Dbhouse_Status_names) {
                        echo $Dbhouse_Status_names['db_house_status_name'];
                    }
                    ?>
                </td>
                <td>
                    <?php echo $db['db_credit_limit']; ?>
                </td>
                <td>
                    <?php
                    $status_id = $db['db_house_status'];
                    $Dbhouse_Status = $this->method_call->Get_Dbhouse_Status($status_id);
                    foreach ($Dbhouse_Status as $Dbhouse_Status_names) {
                        echo $Dbhouse_Status_names['db_house_status_name'];
                    }
                    ?>
                </td>

                <td class="">
                    <a href="<?php
                    $segments = array('distribution_house', 'edit', $db['id']);
                    echo site_url($segments);
                    ?>" data-id="1" class="btn btn-xs blue btn-editable"><i class="fa fa-pencil"></i> Edit</a>
                    <a href="<?php
                    $segments = array('distribution_house', 'del', $db['id']);
                    echo site_url($segments);
                    ?>" data-id="1" class="btn btn-xs red btn-removable" onclick="return confirm('Are you sure Delete this item?')"><i class="fa fa-times"></i> Delete</a>
                </td>
            </tr>
            <?php
        }
    }
    ?>
</tbody>
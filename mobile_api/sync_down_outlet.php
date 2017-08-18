<?php

//sync_down_outlet.php
include_once('config.php');
if (isset($_POST["PSR_id "])) {
    $PSR_id = $_POST["PSR_id "];
}

//$PSR_id = 89;
if (!empty($PSR_id)) {
    $sql = 'SELECT route_id FROM tblt_route_plan_detail` where dist_emp_id=' . $PSR_id . ' and planned_visit_date =CURDATE());';
    $sql_query = mysql_query($sql);


    $result_array = mysql_fetch_assoc($sql_query);
    $route = $result_array["route_id"];

    $sql = 'select id AS outlet_id,outlet_code,outlet_name,parent_id As Route_id,channel,visicooler  FROM tbld_outlet as t1  where t1.parent_id in(' . $route . ')';
    $qur = mysql_query($sql);
    $num_rows = mysql_num_rows($qur);
    $outlet_list = array();
    if ($num_rows > 0) {

        while ($result_array = mysql_fetch_array($qur)) {


            $outlet_list[] = array(
                'outlet_id' => $result_array[0],
                'outlet_code' => $result_array[1],
                'outlet_name' => $result_array[2],
                'Route_id' => $result_array[3],
                'channel' => $result_array[4],
                'visicooler' => $result_array[5]
            );
        }
        header('Content-type: application/json');
        echo json_encode($outlet_list, JSON_PRETTY_PRINT);
    } else {
        echo '-1';
    }
} else {
echo "Dur gia mor";    
}
@mysql_close($conn);



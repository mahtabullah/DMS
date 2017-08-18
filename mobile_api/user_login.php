<?php

include_once('config.php');
if (isset($_POST["user"])) {
    $userName = $_POST["user"];
    //  $userPass = "PSR0087";
}
if (isset($_POST["password"])) {
    $userPass = $_POST["password"];
}
//$userName="PSR0087";
//$userPass="12345";
//$userName="";
//$userPass="";

if (!empty($userName) && !empty($userPass)) {
    $sql = 'SELECT t1.id AS PSR_id,t1.first_name As Name,t1.distribution_house_id As db_id FROM `tbld_distribution_employee` As t1
            inner join tbld_user AS t2 on t1.login_user_id=t2.id 
            where t1.dist_role_id=2 and t2.user_id="' . $userName . '" and t2.user_password="' . $userPass . '" LIMIT 1;';
    $qur = mysql_query($sql);
    $num_rows = mysql_num_rows($qur);

    if ($num_rows == 1) {
        $result_array = mysql_fetch_assoc($qur);
        // var_dump($result_array);
        // header('Content-type: application/json');
        echo json_encode($result_array);
    } else {
        echo '-1';
    }
}
@mysql_close($conn);



<?php

include_once('config.php');
if (isset($_POST["psrid"])) {
    echo $psrid = $_POST["psrid"];
    //  $userPass = "PSR0087";
}
@mysql_close($conn);



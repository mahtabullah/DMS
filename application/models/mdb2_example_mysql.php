<?php
require_once 'MDB2.php';

$dsn= array(
 'phptype' => 'mysql',
 'username' => 'root',
 'password' => 'ba!2345',
 'hostspec' => "localhost",
 'database' => 'es_transcom_qc'
);

$mdb2= MDB2::factory($dsn);
$conn=$mdb2->connect($dsn);
//echo $conn;
$pear= new PEAR;
//var_dump($conn);

if($pear->isError($conn))
{
die($conn->getMessage());
}

//for testing connection
//$res= $conn->query('SELECT * FROM tbl_test');

//while(($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC))) 
//{
//echo $row['id']." # ".$row['name']."<br/>";
//}
?>

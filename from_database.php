<?php
require_once "connect.php";


$mysqlConnection = @new mysqli($host, $db_user, $db_password, $db_name)or die($mysql_error());

$result = $mysqlConnection->query("SELECT * FROM tab1");


$data_array = array();
while($rows = mysqli_fetch_row($result))
    {
        $data_array[] = $rows;       

    }
    echo json_encode($data_array);
$mysqlConnection -> close();
?>

<?php
require_once('connect.php');
$thisId = $_POST['thisId'];

$mysqlConnection = @new mysqli($host, $db_user, $db_password, $db_name) or die($mysql_error());
$mysqlConnection->query('DELETE FROM tab1 WHERE id = '.$thisId.'');
$mysqlConnection -> close();
?>
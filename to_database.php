<?php
require_once('connect.php');
$mysqlConnection = @new mysqli($host, $db_user, $db_password, $db_name) or die($mysql_error());
$fname = $mysqlConnection -> real_escape_string($_POST['fname']);
$lname = $mysqlConnection -> real_escape_string($_POST['lname']);
$salt = "jtYHTYyjky76&%#dfJyreX2!";
$pass_with_salt = $_POST['pass'].$salt;
$pass = hash('sha512', $pass_with_salt);

$mysqlConnection->query("INSERT INTO tab1 (fname, lname, pass) VALUES ('$fname', '$lname', '$pass')");
$mysqlConnection -> close();
?>
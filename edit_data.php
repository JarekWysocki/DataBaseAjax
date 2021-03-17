<?php
require_once('connect.php');
$thisId = $_POST['thisId'];
$newFname = $_POST['newFname'];
$newLname = $_POST['newLname'];
$newPass = $_POST['newPass'];
$pass_with_salt = $_POST['newPass'].$salt;
$pass = hash('sha512', $pass_with_salt);
$mysqlConnection = @new mysqli($host, $db_user, $db_password, $db_name) or die($mysql_error());
if (isset($_POST['newFname'])) {
$mysqlConnection->query('UPDATE tab1 SET fname = "'.$newFname.'" WHERE id = '.$thisId.'');
}
    if (isset($_POST['newLname'])) {
        $mysqlConnection->query('UPDATE tab1 SET lname = "'.$newLname.'" WHERE id = '.$thisId.'');
        }
        if (isset($_POST['newPass'])) {
            $mysqlConnection->query('UPDATE tab1 SET pass = "'.$pass.'" WHERE id = '.$thisId.'');
            }
$mysqlConnection -> close();
?>
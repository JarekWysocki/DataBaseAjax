<?php 
  require_once 'connect.php';
  if ($_POST['choice'] == "random") {
    include 'randomPass.php';
    echo new Pass(10);
    exit();
  }
  if ($_POST['choice'] == "get") {
  include 'from_database.php';
  $db = new FromDatabase($pdo);
  echo json_encode($db->getData());
  exit();
  }
  if ($_POST['choice'] == "send") {
    include 'to_database.php';
    $DataSend = new DataSend($pdo, $_POST['fname'], $_POST['lname'], $_POST['pass'], $_FILES['name']);
    $DataSend->sendData();
    exit();
    }
  if ($_POST['choice'] == "delete") {
  include 'data_delete.php';
  $db = new DataDelete($pdo, $_POST['thisId']);
  $db->deleteData();
  }
  if ($_POST['choice'] == "edit") {
    include 'edit_data.php';
    $DataEdit = new DataEdit($pdo, $_POST['thisId'], $_POST['newFname'], $_POST['newLname'], $_POST['newPass']);
    $DataEdit->editData();
  }
?>
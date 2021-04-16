<?php
include 'connect.php';
$myname = $_POST['myname'];
if (($_POST['status'] == 0)) {
    $activ = $pdo->prepare("UPDATE tab1 SET online=0 WHERE fname='$myname'"); 
    $activ->execute();    
}
if (($_POST['status'] == 1)) {
    $activ = $pdo->prepare("UPDATE tab1 SET online=1 WHERE fname='$myname'"); 
    $activ->execute();    
}
?>
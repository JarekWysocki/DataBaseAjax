<?php
include 'connect.php';
$myname = $_POST['myname'];
$time = time();

$activ = $pdo->prepare("UPDATE tab1 SET online=$time WHERE fname='$myname'"); 
$activ->execute();    


?>
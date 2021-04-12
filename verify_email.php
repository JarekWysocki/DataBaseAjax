<?php
 include 'connect.php';
$token = $_GET['token'];
$result = $pdo->prepare("UPDATE tab1 SET verified=1 WHERE token='$token'");
if($result->execute()) exit ('<h1>Your Email is verifed</h1>');

?>
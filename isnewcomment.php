<?php
require_once 'connect.php';
$postId = $_POST['postId'];
$conn = $pdo->prepare("SELECT * FROM comments WHERE post_id = $postId");
$conn -> execute();
   $count = 0;
   while($fetch = $conn->fetch(PDO::FETCH_ASSOC)){
      $count++;
   }
   echo $count;
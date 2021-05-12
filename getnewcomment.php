<?php
require_once 'connect.php';
$postId = $_POST['postId'];
$limit = $_POST['value'];
$conn = $pdo->prepare("SELECT * FROM comments WHERE post_id = $postId ORDER BY id DESC LIMIT $limit");
$conn -> execute();
   while($fetch = $conn->fetch(PDO::FETCH_ASSOC)){
    $comment = $fetch['comment'];
    $who = $fetch['who_comment'];
       echo "<p>$comment</p>";
   }
<?php
require_once 'connect.php';
$conn = $pdo->prepare("SELECT * FROM likes");
$conn->execute();
while ($fetch = $conn->fetch(PDO::FETCH_ASSOC))
{
    $postId = $fetch['post_id'];
    echo "$postId,";
}
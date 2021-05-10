<?php
require_once 'connect.php';
$postId = $_POST['postId'];
$text = $_POST['text'];
$fromUser = $_POST['fromUser'];
$stmt = $pdo->prepare("INSERT INTO comments (post_id, who_comment, comment) VALUES (:postId, :fromUser, :text)");
        $stmt->bindParam(':postId', $postId);
        $stmt->bindParam(':fromUser', $fromUser);
        $stmt->bindParam(':text', $text);
        $stmt->execute();
<?php
include 'connect.php';
$postId = strip_tags(stripslashes($_POST['postId']));
$fromUser = strip_tags(stripslashes($_POST['fromUser']));
$query = $pdo->prepare("SELECT * FROM likes WHERE post_id = $postId && who_like_id = $fromUser");
$query ->execute();
$count = 0;
while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
++$count;
}
if ($count == 0) {
$stmt = $pdo->prepare("INSERT INTO likes (post_id, who_like_id) VALUES (:postId, :fromUser)");
        $stmt->bindParam(':postId', $postId);
        $stmt->bindParam(':fromUser', $fromUser);
        $stmt->execute();
}
?>
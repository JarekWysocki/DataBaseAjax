<?php
include 'connect.php';
$postId = strip_tags(stripslashes($_POST['postId']));
$query = $pdo->prepare("SELECT tab1.fname FROM likes INNER JOIN tab1 ON tab1.id=likes.who_like_id WHERE post_id = $postId");
$query->execute();
while ($fetch = $query->fetch(PDO::FETCH_ASSOC))
{
    $person = $fetch['fname'];
    echo "<p>$person</p>";
}
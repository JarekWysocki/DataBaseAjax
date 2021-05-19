<?php
require_once 'connect.php';
$postId = $_POST['postId'];
$limit = $_POST['value'];
$conn = $pdo->prepare("SELECT tab1.fname, tab1.img, comments.comment, comments.create FROM comments INNER JOIN tab1 ON tab1.id=comments.who_comment WHERE post_id = $postId ORDER BY comments.id DESC LIMIT $limit");
$conn -> execute();
   while($fetch = $conn->fetch(PDO::FETCH_ASSOC)){
    $comment = $fetch['comment'];
    $who = $fetch['fname'];
    $img = $fetch['img'];
    $time = $fetch['create'];
    if ($img) {
       echo "<div class='comment'>
       <img src='/img/$img'>
       <p class='whois'>$who</p><p>$comment</p><p class='time'>$time</p>
       </div>";}
       else {
         echo "<div class='comment'>
         <img src='/img/noimg.jpg'>
         <p class='whois'>$who</p><p>$comment</p><p class='time'>$time</p>
         </div>";  
       }
   }
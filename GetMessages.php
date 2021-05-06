<?php
require_once 'connect.php';


  $query = $pdo->prepare("SELECT * FROM messages ORDER BY id DESC");
  $query ->execute();
  while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
    $nameid = $fetch['name'];
    $data = $pdo->prepare("SELECT * FROM tab1 WHERE id = '$nameid'");
    $data ->execute();
    $fetch1 = $data->fetch(PDO::FETCH_ASSOC);
    $img = $fetch1['img'];
    $image = $fetch['image'];
    $message = $fetch['message'];
    $time = $fetch['time'];
    $name = $fetch1['fname'];
    $idOfPost = $fetch['id'];
    $conn = $pdo->prepare("SELECT tab1.fname FROM likes INNER JOIN tab1 ON tab1.id=likes.who_like_id WHERE post_id = $idOfPost");
    $conn -> execute();
    $howmuchlikes = 0;
    while($fetch2 = $conn->fetch(PDO::FETCH_ASSOC)){
    ++$howmuchlikes;
    }
   
    if($nameid) {
      if($img && $image) {
        if ($howmuchlikes > 0) {
            echo "<div class='container' id='$idOfPost'>
            <img src='/img/$img'>
            <p>$name</p>
            <div>
            <p>$message</p>
            <img class='myphoto' src='/img/$image'>
            <p class='like'>&#9733 like $howmuchlikes</p>
            <p class='who'>check who</p>
            <span class='time-right'>$time</span>
            </div>
            <form class='comments' onsubmit='return false;'><input class='comment' type='text'></form> 
            </div>";}
            else {
              echo "<div class='container' id='$idOfPost'>
            <img src='/img/$img'>
            <p>$name</p>
            <div>
            <p>$message</p>
            <img class='myphoto' src='/img/$image'>
            <p class='like'>&#9733 like $howmuchlikes</p>
            <span class='time-right'>$time</span>
            </div>
            <form class='comments' onsubmit='return false;'><input class='comment' type='text'></form> 
            </div>";
            }
      }
      if(!$img && $image) {
        if ($howmuchlikes > 0) {
        echo "<div class='container' id='$idOfPost'>
            <img src='/img/noimg.jpg'>
            <p>$name</p>
            <div>
            <p>$message</p>
            <img class='myphoto' src='/img/$image'>
            <p class='like'>&#9733 like $howmuchlikes</p>
            <p class='who'>check who</p>
            <span class='time-right'>$time</span>
            </div>
            <form class='comments' onsubmit='return false;'><input class='comment' type='text'></form> 
            </div>";}
            else {
              echo "<div class='container' id='$idOfPost'>
              <img src='/img/noimg.jpg'>
              <p>$name</p>
              <div>
              <p>$message</p>
              <img class='myphoto' src='/img/$image'>
              <p class='like'>&#9733 like $howmuchlikes</p>
              <span class='time-right'>$time</span>
              </div>
              <form class='comments' onsubmit='return false;'><input class='comment' type='text'></form> 
              </div>";
            }
      }
      if ($img && !$image) {
        if ($howmuchlikes > 0) {
        echo "<div class='container' id='$idOfPost'>
            <img src='/img/$img'>
            <p>$name</p>
            <div>
            <p>$message</p>
            <p class='like'>&#9733 like $howmuchlikes</p>
            <p class='who'>check who</p>
            <span class='time-right'>$time</span>
            </div>
            <form class='comments' onsubmit='return false;'><input class='comment' type='text'></form> 
            </div>";}
            else {
              echo "<div class='container' id='$idOfPost'>
              <img src='/img/$img'>
              <p>$name</p>
              <div>
              <p>$message</p>
              <p class='like'>&#9733 like $howmuchlikes</p>
              <span class='time-right'>$time</span>
              </div>
              <form class='comments' onsubmit='return false;'><input class='comment' type='text'></form> 
              </div>";
            }
      }
      if (!$img && !$image) {
        if ($howmuchlikes > 0) {
        echo "<div class='container' id='$idOfPost'>
            <img src='/img/noimg.jpg'>
            <p>$name</p>
            <div>
            <p>$message</p>
            <p class='like'>&#9733 like $howmuchlikes</p>
            <p class='who'>check who</p>
            <span class='time-right'>$time</span>
            </div>
            <form class='comments' onsubmit='return false;'><input class='comment' type='text'></form> 
            </div>";}
            else {
              echo "<div class='container' id='$idOfPost'>
            <img src='/img/noimg.jpg'>
            <p>$name</p>
            <div>
            <p>$message</p>
            <p class='like'>&#9733 like $howmuchlikes</p>
            <span class='time-right'>$time</span>
            </div>
            <form class='comments' onsubmit='return false;'><input class='comment' type='text'></form> 
            </div>";
            }
      }
    }
  }
?>

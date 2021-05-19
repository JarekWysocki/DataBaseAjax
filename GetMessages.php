<?php
require_once 'connect.php';
  $limit = $_POST['n'];
  $limit = 4 * $limit;
  $query = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $limit, 4");
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
   
  
    if($nameid) {
      if($img && $image) {
            echo "<div class='container' id='$idOfPost'>
            <img src='/img/$img'>
            <p>$name</p>
            <div>
            <p>$message</p>
            <img class='myphoto' src='/img/$image'>
            <p class='like'>&#9733 like </p>
            <p class='who'></p>
            <span class='time-right'>$time</span>
            </div>
            <form class='comments' onsubmit='return false;'><input placeholder='Your comment...' class='comment' type='text'></form> 
            <div class='comments'></div>
            </div>";
            }
      if(!$img && $image) { 
        echo "<div class='container' id='$idOfPost'>
            <img src='/img/noimg.jpg'>
            <p>$name</p>
            <div>
            <p>$message</p>
            <img class='myphoto' src='/img/$image'>
            <p class='like'>&#9733 like </p>
            <p class='who'></p>
            <span class='time-right'>$time</span>
            </div>
            <form class='comments' onsubmit='return false;'><input placeholder='Your comment...' class='comment' type='text'></form> 
            <div class='comments'></div>
            </div>";  
      }
      if ($img && !$image) {
        echo "<div class='container' id='$idOfPost'>
            <img src='/img/$img'>
            <p>$name</p>
            <div>
            <p>$message</p>
            <p class='like'>&#9733 like </p>
            <p class='who'></p>
            <span class='time-right'>$time</span>
            </div>
            <form class='comments' onsubmit='return false;'><input placeholder='Your comment...' class='comment' type='text'></form> 
            <div class='comments'></div>
            </div>";   
      }
      if (!$img && !$image) {
        echo "<div class='container' id='$idOfPost'>
            <img src='/img/noimg.jpg'>
            <p>$name</p>
            <div>
            <p>$message</p>
            <p class='like'>&#9733 like </p>
            <p class='who'></p>
            <span class='time-right'>$time</span>
            </div>
            <form class='comments' onsubmit='return false;'><input placeholder='Your comment...' class='comment' type='text'></form> 
            <div class='comments'></div>
            </div>";
      }
  }
  
  }
?>

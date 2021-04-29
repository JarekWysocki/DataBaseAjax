<?php
require_once 'connect.php';


  $query = $pdo->prepare("SELECT * FROM messages ORDER BY id DESC");
  $query ->execute();

  while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
    $name = $fetch['name'];
    $data = $pdo->prepare("SELECT * FROM tab1 WHERE fname = '$name'");
    $data ->execute();
    $fetch1 = $data->fetch(PDO::FETCH_ASSOC);
    $img = $fetch1['img'];
    $image = $fetch['image'];
    $message = $fetch['message'];
    $time = $fetch['time'];
    if($name) {
      if($img && $image) {
            echo "<div class='container'>
            <img src='/img/$img'>
            <img class='myphoto' src='/img/$image'>
            <p>$message</p>
            <span class='time-right'>$time</span>
            </div>";
      }
      if(!$img && $image) {
        echo "<div class='container'>
            <img src='/img/noimg.jpg'>
            <img class='myphoto' src='/img/$image'>
            <p>$message</p>
            <span class='time-right'>$time</span>
            </div>";
      }
      if ($img && !$image) {
        echo "<div class='container'>
            <img src='/img/$img'>
            <p>$message</p>
            <span class='time-right'>$time</span>
            </div>";
      }
      if (!$img && !$image) {
        echo "<div class='container'>
            <img src='/img/noimg.jpg'>
            <p>$message</p>
            <span class='time-right'>$time</span>
            </div>";
      }
    }
  }
?>

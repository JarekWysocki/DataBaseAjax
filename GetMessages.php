<?php
require_once 'connect.php';


  $query = $pdo->prepare("SELECT * FROM messages");
  $query ->execute();

  while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
    $name = $fetch['name'];
    $data = $pdo->prepare("SELECT * FROM tab1 WHERE fname = '$name'");
    $data ->execute();
    $fetch1 = $data->fetch(PDO::FETCH_ASSOC);
    $img = $fetch1['img'];
    $message = $fetch['message'];
    $id = $fetch['id'];
    $time = $fetch['time'];
    //echo "<li id='$id' class='msg'>$name<b>".$time.":</b> ".$message."</li>";

    echo "<div class='container' id='$id'>
  <img src='/img/$img'>
  <p>$message</p>
  <span class='time-right'>$time</span>
</div>";
  }
?>

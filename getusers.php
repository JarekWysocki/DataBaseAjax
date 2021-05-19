<?php
require_once 'connect.php';
$conn = $pdo->prepare("SELECT * FROM tab1 WHERE verified = '1'");
  $conn ->execute();
  while($result = $conn->fetch(PDO::FETCH_ASSOC)){
    $username = $result['fname'];
    $userimg = $result['img'];
    $id = $result['id'];
    $calculateTime = time() - $result['online'];
    if ($calculateTime > 5) {$isonline = "off";};
    if ($calculateTime < 5) {$isonline = "on";};
    if (!$userimg) {
      echo "<div class='user'>
  <img  id='$id' class = '$isonline' src='/img/noimg.jpg'>
  <p>$username</p>
  </div>";
    }
    else {
  echo "<div class='user'>
  <img  id='$id' class = '$isonline' src='/img/$userimg'>
  <p>$username</p>
  </div>";
  }}
?>
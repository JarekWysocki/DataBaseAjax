<?php
require_once 'connect.php';
echo '<p>Users:</p>';
$conn = $pdo->prepare("SELECT * FROM tab1 WHERE verified = '1'");
  $conn ->execute();
  while($result = $conn->fetch(PDO::FETCH_ASSOC)){
    $username = $result['fname'];
    $userimg = $result['img'];
    if ($result['online'] == 0) {$isonline = "off";};
    if ($result['online'] == 1) {$isonline = "on";};
  echo "<div class='user'>
  <img class = '$isonline' src='/img/$userimg'>
  <p>$username</p>
  </div>";
  }
?>
<?php
require_once 'connect.php';
$fromuser = $_POST['fromUser'];
$conn = $pdo->prepare("SELECT * FROM messages WHERE  to_user_id = $fromuser && is_reading = 0");
$conn ->execute();
    while($fetch = $conn->fetch(PDO::FETCH_ASSOC)){
      echo($fetch['from_user_id'].',');
}
?>
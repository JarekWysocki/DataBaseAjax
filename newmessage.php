<?php
require_once 'connect.php';
$fromuser = $_POST['fromUser'];
$query = $pdo->prepare("SELECT * FROM messages WHERE  to_user_id = $fromuser ORDER BY id DESC");
$query ->execute();
$mess = 0;
while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
    $mess = $mess+1;
}
echo $mess.',';

$call = $pdo->prepare("SELECT * FROM messages WHERE  to_user_id = $fromuser ORDER BY id DESC LIMIT 1");
$call ->execute();
while($fetch = $call->fetch(PDO::FETCH_ASSOC)){
    echo $fetch['from_user_id'];
}

?>
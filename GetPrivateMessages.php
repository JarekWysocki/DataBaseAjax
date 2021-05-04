<?php
 require_once 'connect.php';

 if(isset($_POST['toUser']) && isset($_POST['fromUser'])) {
    $fromUser = strip_tags(stripslashes($_POST['fromUser']));
    $toUser = strip_tags(stripslashes($_POST['toUser']));
    $readed = strip_tags(stripslashes($_POST['readed']));
    $query = $pdo->prepare("SELECT * FROM messages WHERE (to_user_id = '$toUser' or to_user_id = '$fromUser') && (from_user_id = '$fromUser' or from_user_id = '$toUser')");
        if ($query ->execute()) {
          $conn = $pdo->prepare("UPDATE messages SET is_reading = '1' WHERE to_user_id = '$fromUser' && from_user_id = '$toUser'");
          $conn ->execute();
        while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
        $newmessage = $fetch['message'];
        if ($fetch['from_user_id'] != $fromUser) {$class = 'in';} else {$class = 'out';};
        echo "<p class='$class'>$newmessage</p>";
  }
};
}
?>
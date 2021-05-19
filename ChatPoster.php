<?php
   require_once 'connect.php';
    if(isset($_POST['text']) && isset($_POST['nameid'])) {
      $text = strip_tags(stripslashes($_POST['text']));
      $nameid = strip_tags(stripslashes($_POST['nameid']));
      $img = $_FILES['img'];
      $expl = explode('.', $img['name']);
      $extension_of_file = array_pop($expl); 
      if ($img['size'] > 5000000) exit('Max size limit exceeded (5Mb)'); 
      $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', '','image/heic', 'image/jpg'];
            if (!in_array($img['type'], $allowedMimeTypes)) exit('Only JPEG, PNG and GIFs are allowed');    
            if ($img['size'] > 1) {
              $new_name = (bin2hex(openssl_random_pseudo_bytes(15, $cstrong))).".".$extension_of_file;
              }
              else {
                $new_name = '';
              }
        @move_uploaded_file($img['tmp_name'], 'img/'.$new_name);
            if(!empty($text) && !empty($nameid)) {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("INSERT INTO posts (name, message, image) VALUES (:name, :message, :image)");
        $stmt->bindParam(':name', $nameid);
        $stmt->bindParam(':message', $text);
        $stmt->bindParam(':image', $new_name);
        $stmt->execute();
      }
    }
    if(isset($_POST['message']) && isset($_POST['toUser']) && isset($_POST['fromUser'])) {
      $message = strip_tags(stripslashes($_POST['message']));
      $fromUser = strip_tags(stripslashes($_POST['fromUser']));
      $toUser = strip_tags(stripslashes($_POST['toUser']));
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("INSERT INTO messages (message, to_user_id, from_user_id ) VALUES (:message, :toUser, :fromUser)");
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':toUser', $toUser);
        $stmt->bindParam(':fromUser', $fromUser);
        $stmt->execute();   
    }
   
 ?>

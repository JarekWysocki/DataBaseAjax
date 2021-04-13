<?php
   require_once 'connect.php';
   
    if(isset($_POST['text']) && isset($_POST['name'])) {
      $text = strip_tags(stripslashes($_POST['text']));
      $name = strip_tags(stripslashes($_POST['name']));

      if(!empty($text) && !empty($name)) {
       


        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("INSERT INTO messages (name, message) VALUES (:name, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':message', $text);
        if($stmt->execute()) {    

          echo "<li class='msg'><b>".ucwords($name).":</b> ".$text."</li>";
        }

        
      }
    }

 ?>

<?php
include 'to_database.php';
class DataEdit extends DataSend {
function editData($newFname, $newLname, $newPass, $id) {
$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (isset($newFname)) {
    $stmt = $this->pdo->prepare('UPDATE tab1 SET fname = :fname WHERE id = '. $id .'');
    $stmt->bindParam(':fname', $newFname);    
}
    if (isset($newLname)) {
        $stmt = $this->pdo->prepare('UPDATE tab1 SET lname = :lname WHERE id = '. $id .'');
        $stmt->bindParam(':lname', $newLname);  
        }
        if (isset($newPass)) {
            $new_pass = $this->set_pass($this->salt, $newPass);
            $stmt = $this->pdo->prepare('UPDATE tab1 SET pass = :pass WHERE id = '. $id .'');
            $stmt->bindParam(':pass', $new_pass); 
            }
            if($stmt->execute()) exit('Changed!');
        }
            function __destruct(){   
                $this->pdo = null;
            }
        }
?>
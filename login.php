<?php
include 'to_database.php';
class Login extends DataSend {
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    function logIn($fname, $pass) {
        $new_pass = $this->set_pass($this->salt, $pass);
        $result = $this->pdo->prepare("SELECT id FROM tab1 WHERE fname = '$fname' and pass = '$new_pass'"); 
        $result->execute();
        $result = json_encode ($result->fetchAll(PDO::FETCH_ASSOC)[0]{'id'});
        if($result == "null") { echo('Error'); } else {
              echo('index.html');
              exit;    
          }
        
    }
}
    





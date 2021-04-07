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
        if($result->fetchAll(PDO::FETCH_ASSOC)) {
            session_start();
            $_SESSION['user_id'] = $fname;
            echo ('dgfsdgfs');
        }
    }
}
    





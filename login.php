<?php
include 'to_database.php';
class Login extends DataSend {
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    function logIn($name, $pass) {
        $new_pass = $this->set_pass($this->salt, $pass);
        $result = $this->pdo->prepare("SELECT * FROM tab1 WHERE BINARY fname = BINARY '$name' and pass = '$new_pass'"); 
        $result->execute();
        $fetch = $result->fetch(PDO::FETCH_ASSOC);
        if ($fetch['verified'] == "null") { exit("Error"); };
        if ($fetch['verified'] == 0) { exit("Error"); };
        if ($fetch['verified'] == 1) { 
            session_start(); 
            $_SESSION['id'] = $fetch['id'];
            echo('loginon.php');
        };
    }
    
}
    





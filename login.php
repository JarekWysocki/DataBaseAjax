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
        $result = json_encode ($result->fetchAll(PDO::FETCH_ASSOC)[0]{'verified'});   
        $result = substr($result, 1, -1);
        if ($result == "ul") { exit("Error"); };
        if ($result == 0) { exit("Confirm your email"); };
        if ($result == 1) { 
            session_start(); 
            $_SESSION['fname'] = $name; 
            $_SESSION['time'] = time();
            echo('loginon.php');
            $activ = $this->pdo->prepare("UPDATE tab1 SET online=1 WHERE fname='$name'"); 
            $activ->execute();
        };
    }
    
}
    





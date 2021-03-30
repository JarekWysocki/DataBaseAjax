<?php
class DataSend {
    protected $salt = 'Taj%of*nzN2KBMFDj2D&!YiF!mGmKS)u&PLRpqCp6WRQ(dOZB6WrgB!)Dzl5ifNYzDJx63g)_wbE*7G1bK|93AA0PRs^!KgKKiU!InuIj5zlhHhit_gm0gl0AQkoS23)';
    public function __construct($pdo, $fname, $lname, $pass, $img) {
        $this->pdo = $pdo;
        $this->fname = $fname;
        $this->lname = $lname;
        $this->pass = $pass;
        $this->img = $img;    
        var_dump($this->img);  
        var_dump($this->img['name']); 
    }
      function set_pass($salt1, $psw) {
        $pass_with_salt = $psw.$salt1;
        $passHash = hash('sha512', $pass_with_salt);
        return $passHash;
      }  
      function sendData() {
        $new_pass = $this->set_pass($this->salt, $this->pass);

        if(!@move_uploaded_file($this->img['tmp_name'], 'img/'.$this->img['name'])) exit($this->img);
        $this->pdo->query("INSERT INTO tab1 (fname, lname, pass, img) VALUES ('$this->fname', '$this->lname', '$new_pass', '$this->img')");
        }
    
        function __destruct(){   
            $this->pdo = null;
        }

}
require_once 'connect.php';
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$pass = $_POST['pass'];
$img = $_FILES['name'];
$DataSend = new DataSend($pdo, $fname, $lname, $pass, $img);
$DataSend->sendData();

?>
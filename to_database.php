<?php
class DataSend {
    protected $salt = 'Taj%of*nzN2KBMFDj2D&!YiF!mGmwbE*7G1bK|93AA0PRs^!KgKKiU!InuIj5zlhHhit_gm0gl0AQkoS23)';
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
      function set_pass($salt1, $psw) {
        $pass_with_salt = $psw.$salt1;
        $passHash = hash('sha512', $pass_with_salt);
        return $passHash;
      }  
      function sendData($fname, $lname, $pass, $img) {
        $bytes = disk_free_space("/"); //Checking disk free space
        $new_pass = $this->set_pass($this->salt, $pass); //Call set_pass function
        $expl = explode('.', $img['name']);
        $extension_of_file = array_pop($expl); 
         
                           
                  //Checking the file size
            if ($img['size'] > 5000000) exit('Max size limit exceeded (5Mb)'); 
                  //Validating the Mime Type
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', '','image/heic', 'image/jpg'];
            if (!in_array($img['type'], $allowedMimeTypes)) exit('Only JPEG, PNG and GIFs are allowed');    
                  //Checking space in server
            if ($bytes < $img['size']) exit('No space in server');
        $token = bin2hex(random_bytes(50));    
        if ($img['size'] > 1) {
        $new_name = (bin2hex(openssl_random_pseudo_bytes(15, $cstrong))).".".$extension_of_file;
        }
        else {
          $new_name = '';
        }
        // Send file to server
        @move_uploaded_file($img['tmp_name'], 'img/'.$new_name);
        // Check for double login
        $result = $this->pdo->prepare("SELECT * FROM tab1 WHERE fname = '$fname'"); 
        $result->execute();
        $result = json_encode ($result->fetchAll(PDO::FETCH_ASSOC)[0]{'fname'});
        $result = substr($result, 1, -1);
        if ($result == $fname) {exit('This nick is taken');}
        else {
        // Send data to database
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $this->pdo->prepare("INSERT INTO tab1 (fname, lname, pass, img, token) VALUES (:fname, :lname, :new_pass, :new_name, :token)");
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':new_pass', $new_pass);
        $stmt->bindParam(':new_name', $new_name);
        $stmt->bindParam(':token', $token);
        if($stmt->execute()) {
          
        include 'mail/email.php';  
        $sendEmail = new SendEmail();
        $sendEmail->send($token, $lname, $fname);
        exit();    
        }
      }}
    
        function __destruct(){   
            $this->pdo = null;
        }

}
?>
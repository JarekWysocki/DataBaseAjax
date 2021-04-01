<?php
class DataSend {
    protected $salt = 'Taj%of*nzN2KBMFDj2D&!YiF!mGmKS)u&PLRpqCp6WRQ(dOZB6WrgB!)Dzl5ifNYzDJx63g)_wbE*7G1bK|93AA0PRs^!KgKKiU!InuIj5zlhHhit_gm0gl0AQkoS23)';
    public function __construct($pdo, $fname, $lname, $pass, $img) {
        $this->pdo = $pdo;
        $this->fname = $fname;
        $this->lname = $lname;
        $this->pass = $pass;
        $this->img = $img;
    }
      function set_pass($salt1, $psw) {
        $pass_with_salt = $psw.$salt1;
        $passHash = hash('sha512', $pass_with_salt);
        return $passHash;
      }  
      function sendData() {
        $bytes = disk_free_space("/"); //Checking disk free space
        $new_pass = $this->set_pass($this->salt, $this->pass); //Call set_pass function
        $expl = explode('.', $this->img['name']);
        $extension_of_file = array_pop($expl); 
         
                  //Checking for the file in
            if (empty($this->img)) exit('Image file is missing'); 
                  //Checking for upload time errors
            if ($this->img['error'] !== 0) exit('Image uploading error: INI Error');
            if ($this->img['error'] === 1) exit('Max upload size exceeded');             
                  //Checking the file size
            if ($this->img['size'] > 2000000) exit('Max size limit exceeded (2Mb)'); 
                  //Validating the Mime Type
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($this->img['type'], $allowedMimeTypes)) exit('Only JPEG, PNG and GIFs are allowed');    
                  //Validating the image
            $imageData = getimagesize($this->img['tmp_name']); 
            if (!$imageData) exit('Invalid image');
                  //Checking space in server
            if ($bytes < $this->img['size']) exit('No space in server');
            
        $new_name = (bin2hex(openssl_random_pseudo_bytes(15, $cstrong))).".".$extension_of_file;
        if(!@move_uploaded_file($this->img['tmp_name'], 'img/'.$new_name)) exit('Error upload');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $this->pdo->prepare("INSERT INTO tab1 (fname, lname, pass, img) VALUES (:fname, :lname, :new_pass, :new_name)");
        $stmt->bindParam(':fname', $this->fname);
        $stmt->bindParam(':lname', $this->lname);
        $stmt->bindParam(':new_pass', $new_pass);
        $stmt->bindParam(':new_name', $new_name);
        if($stmt->execute()) exit('Done!');
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
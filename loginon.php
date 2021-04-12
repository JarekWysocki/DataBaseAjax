<?php
session_start();
if(!isset($_SESSION['fname'])){
header('Location: index.html');
}
if($_SESSION['fname'] == "admin"){
  header('Location: welcome.php');
  }
  include 'connect.php';
  $name = $_SESSION['fname'];
  $img = $pdo->prepare("SELECT * FROM tab1 WHERE fname = '$name'"); 
  $img->execute();
  $img = json_encode ($img->fetchAll(PDO::FETCH_ASSOC)[0]{'img'});
  $img = substr($img, 1, -1);
?>

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8" />
    <title>Login</title>
    <meta name="description" content="Flags" />
    <meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="style.css" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>

  <body>
    <div id="mypage">
     
      <p>Hello <?php echo $name ?></p>
     <img src="http://test.jarek.info.pl/img/<?php echo $img?>">
      <form action="logout.php">
    <input type="submit" value="Logout" />
</form>

    </br>
  </br>
    </div>

   
  <script src="ajax.js"></script>
 
  </body>
</html>

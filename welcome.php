<?php
session_start();
if(!isset($_SESSION['fname'])){
header('Location: index.html');
}

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
    <div id="demo">
     
      <p>Hello <?php echo $_SESSION['fname'] ?></p>
     
      <button id="get">Get Data</button>
      <form action="logout.php">
    <input type="submit" value="Logout" />
</form>

    </br>
  </br>
    </div>

   
  <script src="ajax.js"></script>
 
  </body>
</html>

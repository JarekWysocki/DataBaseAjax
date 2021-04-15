<?php
session_start();
if(isset($_SESSION['fname'])){
header('Location: loginon.php');
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
    <div class="start">
    <div id="demo">
      <p>Register</p>
      <form method="post" enctype="multipart/form-data">
      
        <input type="text" id="fname" name="fname" placeholder="Nick"><br><br>
     
        <input type="email" id="lname" name="lname" placeholder="Email"><br><br>
       
        <input type="password" id="pass" name="pass" placeholder="Password"> <br><br>

        

        <input type='file' id="image" name='file' /><br><br>

        <button id="send">Submit</button><br><br>
      </form> 
     <!--<button id="random">Generate password</button><br><br>--> 
    </div>
    <div id="log">
        <p>LogIn</p>
        <input type="text" id="logNick" name="fname" placeholder="Nick"><br><br>
        <input type="password" id="logPass" name="pass" placeholder="Password"><br><br>
        <button id="login">LogIn</button>
    </div>
  </div>
  <script src="ajax.js"></script>
 
  </body>
</html>
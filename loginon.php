<?php
session_start();
$id = $_SESSION['id'];
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8" />
    <title>My Site</title>
    <meta name="description" content="Flags" />
    <meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="chat.js"></script>
    <script src="ajax.js"></script>
    <script src="script.js"></script>
  </head>
<body>
  <?php
if ($_SESSION['id'] == 501) {
    include 'welcome.php';
}
include 'connect.php';
$query = $pdo->prepare("SELECT * FROM tab1 WHERE id = '$id'");
$query->execute();
$fetch = $query->fetch(PDO::FETCH_ASSOC);
$img = $fetch['img'];
$online = $fetch['online'];
$name = $fetch['fname'];
?>
<div class="coverimg"></div>
<div class="site">
<div class="users"></div>
    <div id="mypage">
    <div class="first">
        <p id="<?php echo $id ?>">Hello <?php echo $name ?></p>
        <img src="https://jarekwu.beep.pl/img/<?php if ($img) {
    echo $img;
} else {
    echo 'noimg.jpg';
} ?>">
          <form id="logout" action="logout.php">
          <input type="submit" value="Logout" />
          </form>
    </div>
   <?php
include 'chat.php';
?>
   </div>
   <div class="demo">
   <p id="location"></p>
      <p id="region"></p>
      <p id="temperature"></p>
      <p id="pressure"></p>
      <img id="symbol" />
      <p id="desc"></p>
   </div>
   </div>
  <div class="chatWindows"></div>
</body>
</html>
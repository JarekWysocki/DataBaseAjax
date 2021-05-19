<?php
session_start();
if(!isset($_SESSION['id'])){
header('Location: index.php');
}
?>
  <body>
    <div id="demo">
      <button id="get">Get Data</button>
    </div>
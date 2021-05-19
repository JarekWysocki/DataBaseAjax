<?php
require_once 'connect.php';
 $conn = $pdo->prepare("SELECT * FROM comments");
 $conn -> execute();
    while($fetch = $conn->fetchAll(PDO::FETCH_ASSOC)){
        echo json_encode($fetch);
    }
    
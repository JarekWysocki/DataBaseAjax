<?php
require_once 'connect.php';
$query = $pdo->prepare("SELECT id FROM posts ORDER BY id DESC LIMIT 1");
$query ->execute();
$fetch = $query->fetch(PDO::FETCH_ASSOC);
echo $fetch['id'];
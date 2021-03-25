<?php
class FromDatabase {
public function __construct($pdo) {
  $this->pdo = $pdo;
}
function getData() {
    $result = $this->pdo->prepare('SELECT * FROM tab1'); 
    $result->execute();
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function __destruct()
{   
    $this->pdo = null;
}
}
require_once 'connect.php';
$db = new FromDatabase($pdo);
echo json_encode($db->getData());           
?>
 
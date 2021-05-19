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
?>
 
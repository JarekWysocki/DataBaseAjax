<?php
class DataDelete {
    public function __construct($pdo, $thisId) {
        $this->pdo = $pdo;
        $this->thisId = $thisId;
      }
function deleteData() {
$this->pdo->query('DELETE FROM tab1 WHERE id = '.$this->thisId.'');
}
function __destruct()
{   
    $this->pdo = null;
}
}
require_once 'connect.php';
$thisId = $_POST['thisId'];
$db = new DataDelete($pdo, $thisId);
$db->deleteData();
?>
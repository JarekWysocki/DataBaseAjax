<?php
class DataDelete {
    public function __construct($pdo, $thisId) {
        $this->pdo = $pdo;
        $this->thisId = $thisId;        
    }
function getNameImg() {
    $result = $this->pdo->prepare('SELECT img FROM tab1 WHERE id = '.$this->thisId.''); 
    $result->execute();
    return json_encode ($result->fetchAll(PDO::FETCH_ASSOC)[0]{'img'});
}
function deleteData() {
$nameFile = $this->getNameImg();
$nameFile = substr($nameFile, 1, -1);
unlink('img/'.$nameFile);
if($this->pdo->query('DELETE FROM tab1 WHERE id = '.$this->thisId.'')) exit('Deleted');
}
function __destruct()
{   
    $this->pdo = null;
}
}
?>
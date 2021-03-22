<?php
class Salt {
protected $items = ['0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i',
'j','k','l','m','n','o','p','r','s','t','u','w','x','y','q','z','A','B','C','D','E','F','G',
'H','I','J','K','L','M','N','O','P','R','S','T','U','W','Q','X','Y','Z','!','#','%','^','&',
'*','(',')','_','|'];
public function __construct() {
  for ($i = 0; $i < 20; $i++) {
   
  echo $this->items[array_rand($this->items)];
  }
}
}
?>
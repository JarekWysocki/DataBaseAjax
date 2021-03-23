<?php

$host = "mysql01.jarekwu.beep.pl";
$db_user = "jaroslawwysocki";
$db_password = "Agnat2019!";
$db_name = "jarekbaza123";

try
    {
        $pdo = new PDO('mysql:host='. $host .';dbname='.$db_name, $db_user, $db_password);
    }
    catch (PDOException $e)
    {
        exit('Error Connecting To DataBase');
    }

?>
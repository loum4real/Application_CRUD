<?php 
$host = 'localhost';
$dbname = 'appilcationcrud';
$username = 'root';
$password = '';
 try {
    $PDO = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
 }
 catch (PDOException $e) {
echo "Erreur : " .$e->getMessage();
 }

?>

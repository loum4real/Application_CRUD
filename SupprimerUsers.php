<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    include_once "CONFIGDB.php";
    $sql = "DELETE FROM users WHERE id = $id";
    try {
        
        $resultat = $PDO->prepare($sql);
        $resultat->execute();

        header("Location: ListerUsers.php");
        exit(); 
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

}
?>

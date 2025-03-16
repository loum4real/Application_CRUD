<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    include_once "CONFIGDB.php";

    $sql = "DELETE FROM users WHERE id = :id";

    try {
        
        $resultat = $PDO->prepare($sql);
        $resultat->execute([':id' => $id]);

        header("Location: ListerUsers.php");
        exit(); 
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lister Utilisateurs</title>
    <link rel="stylesheet" href="Monstyle.css">
</head>
<body>
    <main>
        <div class="link_container">
            <a class="link" href="AjouterUser.php">Ajouter un Utilisateur</a>
        </div>
<table>
    <thead>
        <?php
        include_once 'CONFIGDB.php';
        $sql = "SELECT * FROM users";
        $resultat = $PDO->query($sql);
         if ($resultat->rowcount() > 0) {

         ?>

        <th>Id</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Login</th>
        <th>Mot de passe</th>
        <th>Profile</th>
        <th>Modifier</th>
        <th>Supprimer</th>
    </thead>
    <tbody>
        <?php 
        while($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
         
        ?>
        <tr>
            <td><?= $ligne['id']?></td>
            <td><?= $ligne['nom']?></td>
            <td><?= $ligne['prenom']?></td>
            <td><?= $ligne['login']?></td>
            <td>**********</td>
            <td> <img src="<?= $ligne['profile'] ?>" alt="Profile" style="width: 50px; height: 50px;"></td>
            <td class="image"><a href="ModifierUsers.php?id=<?= $ligne['id'] ?>"><img src="modifier.png"></a></td>
            <td class="image"><a href="SupprimerUsers.php?id=<?= $ligne['id'] ?>"><img src="supprimer.png"></a></td>
        </tr>
        <?php 
        }
        ?>

    </tbody>
    <?php 
         } else {
            echo "<p class='message'>0 utilisateur présent</p>";
         }
    ?>
</table>

    


</main>

</body>
</html>
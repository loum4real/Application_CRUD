<?php
$id = $_GET['id'];
if (isset($_POST['send'])) {
    if (
        (isset($_POST['id'])) && !empty($_POST['id']) &&
        (isset($_POST['nom'])) && !empty($_POST['nom']) &&
        (isset($_POST['prenom'])) && !empty($_POST['prenom']) &&
        (isset($_POST['login'])) && !empty($_POST['login']) &&
        (isset($_POST['password']) && !empty($_POST['password'])) &&
        (isset($_FILES['profile']) && !empty($_FILES['profile']['name'])) // Vérifier si un fichier a été téléchargé
    ) {
        include_once "CONFIGDB.php";

        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $login = $_POST['login'];
        $password = $_POST['password'];

        // Gestion de l'upload du fichier
        $uploadchemin = 'uploads/'; // Dossier où les images seront stockées
        $uploadFile = $uploadchemin . basename($_FILES['profile']['name']);

        // Déplacer le fichier téléchargé vers le dossier "uploads"
        if (move_uploaded_file($_FILES['profile']['tmp_name'], $uploadFile)) {
            // Hacher le mot de passe
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Mettre à jour les données dans la base de données
            $sql = "UPDATE users SET nom = :nom, prenom = :prenom, login = :login, password = :password, profile = :profile WHERE id = :id";
            try {
                $resultat = $PDO->prepare($sql);
                $resultat->execute([
                    ':id' => $id,
                    ':nom' => $nom,
                    ':prenom' => $prenom,
                    ':login' => $login,
                    ':password' => $hash,  
                    ':profile' => $uploadFile 
                ]);
                header("Location: ListerUsers.php");
                exit();
            } catch (PDOException $e) {
                echo "ERREUR : " . $e->getMessage();
            }
        } else {
            echo "Erreur lors du téléchargement du fichier.";
        }
    } else {
        echo "Tous les champs doivent être remplis.";
    }
}

include_once "CONFIGDB.php";
$sql = "SELECT * FROM users WHERE id = :id";
$resultat = $PDO->prepare($sql);
$resultat->execute([':id' => $id]);
$ligne = $resultat->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateurs</title>
    <link rel="stylesheet" href="Monstyle.css">
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <h1>Modifier un Utilisateur</h1>
        <input type="hidden" name="id" value="<?= $ligne['id']; ?>">
        <input type="text" name="nom" value="<?= $ligne['nom']; ?>" placeholder="nom">
        <input type="text" name="prenom" value="<?= $ligne['prenom']; ?>" placeholder="prenom">
        <input type="text" name="login" value="<?= $ligne['login']; ?>" placeholder="login">
        <input type="password" name="password" placeholder="password">
        <input type="file" name="profile" accept="image/*">
        <input type="submit" value="MODIFIER" name="send" />
        <a class="Link back" href="ListerUsers.php">Annuler</a>
    </form>
</body>
</html>
<?php 
if(isset($_POST['send'])) {
    if(
    (isset($_POST['id'])) && !empty($_POST['id']) &&
    (isset($_POST['nom'])) && !empty($_POST['nom']) &&
    (isset($_POST['prenom'])) && !empty($_POST['prenom']) &&
    (isset($_POST['login'])) && !empty($_POST['login']) && 
    (isset($_POST['password']) && !empty($_POST['password'])) &&
    (isset($_FILES['profile']) && !empty($_FILES['profile']['name']))
    ) {

    include_once "CONFIGDB.php";

    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    $profile = $_FILES['profile'];
    $uploadchemin = 'uploads/'; 
    $uploadFile = $uploadchemin . basename($profile['name']);

 
    if (move_uploaded_file($profile['tmp_name'], $uploadFile)) {

    
    $hash = password_hash($password , PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (id, nom, prenom, login, password, profile) VALUES (:id, :nom, :prenom, :login, :password, :profile)";

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
    } 
    catch (PDOException $e) {
        echo "ERREUR " .$e->getMessage();

    }
} else {
    echo "Erreur lors du téléchargement du fichier.";
}

    } else {
        echo "Tous les champs doivent etre remplis";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Un Utilisateur</title>
    <link rel="stylesheet" href="Monstyle.css">
</head>
<body>
    <h1>Ajouter un Utilisateur</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="id" placeholder="ID">
        <input type="text" name="nom" placeholder="NOM">
        <input type="text" name="prenom" placeholder="Prenom">
        <input type="text" name="login" placeholder="Login">
        <input type="password" name="password" placeholder="Mot de Passe">
        <input type="file" name="profile" accept="image/*">
        <input type="submit" value="Ajouter" name="send">
        <a class="Lien de retour" href="ListerUsers.php">Annuler</a>
    </form>
</body>
</html>
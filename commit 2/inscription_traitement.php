<?php
session_start();
// Vérifier si les champs sont remplis
if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Connexion à la base de données
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "Choupimolly8490.";
    $dbname = "reservationsalles";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Vérifier si le nom d'utilisateur existe déjà
    $checkUsernameSql = "SELECT * FROM utilisateurs WHERE login = '$login'";
    $checkUsernameResult = $conn->query($checkUsernameSql);

    if ($checkUsernameResult->num_rows > 0) {
        // Le nom d'utilisateur est déjà pris
        echo "Ce nom d'utilisateur est déjà utilisé. Veuillez en choisir un autre.";
    } else {
        // Vérifier si les mots de passe correspondent
        if ($password === $confirm_password) {
            // Insertion des données dans la table utilisateurs
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hacher le mot de passe avant de l'insérer
            $insertSql = "INSERT INTO utilisateurs (login, password) VALUES ('$login', '$hashedPassword')";

            if ($conn->query($insertSql) === true) {
                echo "Inscription réussie. Vous pouvez vous connecter.";
                // Redirection vers la page de connexion
                header("Location: connexion.php");
                exit();
            } else {
                echo "Erreur lors de l'inscription : " . $conn->error;
            }
        } else {
            echo "Les mots de passe ne correspondent pas.";
        }
    }

    $conn->close();
} else {
    echo "Veuillez remplir tous les champs du formulaire.";
}
?>

<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    // Rediriger l'utilisateur vers la page de profil (ou toute autre page réservée aux utilisateurs connectés)
    header("Location: profil.php");
    exit();
}

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs sont remplis
    if (!empty($_POST["login"]) && !empty($_POST["password"])) {
        // Connexion à la base de données
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "Choupimolly8490.";
        $dbname = "reservationsalles";

        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

        if ($conn->connect_error) {
            die("La connexion à la base de données a échoué : " . $conn->connect_error);
        }

        $login = $_POST["login"];
        $password = $_POST["password"];

        // Requête pour vérifier l'utilisateur dans la base de données
        $sql = "SELECT * FROM utilisateurs WHERE login = '$login'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];
        
            if (password_verify($password, $hashedPassword)) {
                // Le mot de passe est valide, créer la variable de session et rediriger l'utilisateur
                $_SESSION["logged_in"] = true;
                $_SESSION["user_id"] = $row['id']; // Remplacez 'id' par le nom de la colonne contenant l'ID de l'utilisateur dans votre base de données
                $_SESSION["login"] = $login;
        
                // Redirection vers la page de profil (ou toute autre page réservée aux utilisateurs connectés)
                header("Location: profil.php");
                exit();
            } else {
                echo "Identifiants incorrects. Veuillez réessayer.";
            }
        } else {
            echo "Identifiants incorrects. Veuillez réessayer.";
        }
        

        $conn->close();
    } else {
        echo "Veuillez remplir tous les champs du formulaire.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="connexion.css">
    <title>Connectez vous au Tennis Club</title>
</head>
<body>
    <nav class="navbar">
        <a href class="logo">Tennis Club</a>
        <div class="nav_links">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="planning.php">Planning</a></li>

                <?php
                // Vérifier si l'utilisateur est connecté
                if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
                    // Utilisateur connecté
                    echo '<li><a href="reservation-form.php">Réserver</a></li>';
                    echo '<li><a href="profil.php">Profil</a></li>';
                    echo '<li><a href="logout.php">Déconnexion</a></li>';
                    
                } else {
                    // Utilisateur non connecté
                    echo '<li><a href="inscription.php">Inscription</a></li>';
                    echo '<li><a href="connexion.php">Connexion</a></li>';
                    
                }
                ?>
            </ul>
        </div>
        <img src="./images/menu-btn.png" alt="" class="menu_hamburger">
    </nav>
    <section class="section_1">
        <div class="background">
            <div class="formulaire">
                <h2>CONNEXION</h2> <br>
                <form method="POST" action="connexion.php">
                    <label for="login">Nom d'utilisateur :</label><br>
                    <input type="text" name="login" required><br><br>

                    <label for="password">Mot de passe :</label><br>
                    <input type="password" name="password" required><br><br>

                    <input type="submit" value="Se connecter">
                </form>
            </div>
        </div>
    </section>
</body>
</html>

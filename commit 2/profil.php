<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    // Rediriger l'utilisateur vers la page de connexion (ou toute autre page d'authentification)
    header("Location: connexion.php");
    exit();
}

// Récupérer le login actuel de l'utilisateur depuis la session
$currentLogin = $_SESSION["login"];

// Traitement du formulaire de modification du profil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs sont remplis
    if (!empty($_POST["new_login"]) && !empty($_POST["new_password"]) && !empty($_POST["confirm_password"])) {
        $newLogin = $_POST["new_login"];
        $newPassword = $_POST["new_password"];
        $confirmPassword = $_POST["confirm_password"];

        // Vérifier si les mots de passe correspondent
        if ($newPassword === $confirmPassword) {
            // Connexion à la base de données
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "Choupimolly8490.";
            $dbname = "reservationsalles";

            $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

            if ($conn->connect_error) {
                die("La connexion à la base de données a échoué : " . $conn->connect_error);
            }

            // Mise à jour du login dans la base de données
            $sql = "UPDATE utilisateurs SET login = '$newLogin' WHERE login = '$currentLogin'";
            $conn->query($sql);

            // Vérification de la mise à jour du login
            if ($conn->affected_rows > 0) {
                // Mise à jour réussie, mettre à jour le login dans la session
                $_SESSION["login"] = $newLogin;
                echo "Votre profil a été mis à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour du profil.";
            }

            $conn->close();
        } else {
            echo "Les mots de passe ne correspondent pas.";
        }
    } else {
        echo "Veuillez remplir tous les champs du formulaire.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="profil.css">
    <title>Profil</title>
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
                    <h2>MODIFIER MON PROFIL</h2> <br>
                    <form method="POST" action="profil.php">
                        <label for="current_login">Login actuel :</label><br>
                        <input type="text" id="current_login" value="<?php echo $currentLogin; ?>" disabled><br><br>

                        <label for="new_login">Nouveau login :</label><br>
                        <input type="text" id="new_login" name="new_login" required><br><br>

                        <label for="new_password">Nouveau mot de passe :</label><br>
                        <input type="password" id="new_password" name="new_password" required><br><br>

                        <label for="confirm_password">Confirmer le nouveau mot de passe :</label><br>
                        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

                        <input type="submit" value="Modifier le profil">
                    </form>
                </div>
            </div>
        </section>
    </body>
</html>

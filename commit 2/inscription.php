<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="inscription.css">
    <title>Inscription</title>
</head>
<body>
    <?php 
    session_start();
    ?>

    <nav class="navbar">
        <a href class="logo">Tennis CLub</a>
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
                <h2>INSCRIPTION</h2> <br>
                <form method="POST" action="inscription_traitement.php">
                    <label for="login">Nom d'utilisateur</label><br>
                    <input type="text" name="login" required><br><br>

                    <label for="password">Mot de passe</label><br>
                    <input type="password" name="password" required><br><br>

                    <label for="confirm_password">Confirmer le mot de passe</label><br>
                    <input type="password" name="confirm_password" required><br><br>

                    <input type="submit" value="S'inscrire">
                </form>
            </div>
        </div>
    </section>
</body>
</html>

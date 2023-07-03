<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="accueil.css">
    <title>Tennis Club</title>
</head>
<body>
    <?php 
    session_start();
    ?>

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
            <div class="home">
                <article id="text_home">
                    <h1>Bienvenue</h1>
                    <p>Découvrez une communauté passionnée, des installations de qualité et une expérience tennistique inoubliable. Rejoignez-nous dès maintenant et vivez votre passion du tennis à nos côtés !</p> <br>
                    <a href="connexion.php"><button>Connectez vous</button></a>
                </article>
            </div>
        </div>
    </section>
  

</body>
</html>
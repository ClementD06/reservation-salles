<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="reservation.css">
    <title>Formulaire de réservation</title>
</head>
<body>
<?php 
    session_start();
    ?>
<?php
// Connexion à la base de données
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "Choupimolly8490.";
$dbname = "reservationsalles";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Récupérer les réservations pour la semaine en cours
// Vous pouvez ajuster la logique pour afficher uniquement la semaine en cours selon vos besoins
$currentWeekStart = date("Y-m-d", strtotime('monday this week'));
$currentWeekEnd = date("Y-m-d", strtotime('sunday this week'));

$sql = "SELECT r.titre, r.debut, r.fin, u.login FROM reservations r JOIN utilisateurs u ON r.id_utilisateur = u.id WHERE r.debut >= '$currentWeekStart' AND r.fin <= '$currentWeekEnd'";
$result = $conn->query($sql);

// Créer un tableau pour stocker les réservations par jour
$planning = array();

// Initialiser les jours de la semaine
$days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'vendredi', 'Samedi', 'Dimanche');

// Créer un tableau vide pour chaque jour de la semaine
foreach ($days as $day) {
    $planning[$day] = array();
}

// Remplir le tableau des réservations par jour
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $title = $row["titre"];
        $startTime = date("H:i", strtotime($row["debut"]));
        $endTime = date("H:i", strtotime($row["fin"]));
        $user = $row["login"];

        $dayOfWeek = date("l", strtotime($row["debut"]));
        $planning[$dayOfWeek][] = array('title' => $title, 'startTime' => $startTime, 'endTime' => $endTime, 'user' => $user);
    }
}

$conn->close();
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
            <div class="formulaire">
                    <h2>RESERVER UN COURT</h2> <br>
                    <form method="POST" action="reservation-process.php">

                        <label for="date_debut">Date de début</label><br>
                        <input type="datetime-local" name="date_debut" required><br><br>

                        <label for="date_fin">Date de fin</label><br>
                        <input type="datetime-local" name="date_fin" required><br><br>

                        <label for="titre">Titre</label><br>
                        <input type="text" name="titre" required><br><br>

                        <label for="description">Description</label><br>
                        <textarea name="description" rows="4" cols="50" required></textarea><br><br>

                        <input type="submit" value="Réserver">
                    </form>
            </div>
        </div>
    </section>
</body>
</html>

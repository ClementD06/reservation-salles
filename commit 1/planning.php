<?php
session_start();
// Étape 1 : Vérifier si un jour et une heure ont été sélectionnés
if (isset($_GET['jour']) && isset($_GET['heure'])) {
    $jour_selectionne = $_GET['jour'];
    $heure_selectionnee = $_GET['heure'];
} else {
    // Si aucun jour et aucune heure n'ont été sélectionnés, utiliser les valeurs par défaut de la semaine en cours et une plage horaire de 8h à 19h
    $jour_selectionne = "";
    $heure_selectionnee = "";
}

// Étape 2 : Déterminer la semaine en cours
$premier_jour_semaine = date('Y-m-d', strtotime('this week'));
$dernier_jour_semaine = date('Y-m-d', strtotime('this week +6 days'));

// Étape 3 : Effectuer la requête SQL avec le filtrage par semaine et plage horaire et les valeurs sélectionnées
// Assurez-vous de remplacer les informations de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "Choupimolly8490.";
$dbname = "reservationsalles";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$sql = "SELECT reservations.*, utilisateurs.login FROM reservations INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id WHERE debut >= '$premier_jour_semaine 08:00:00' AND fin <= '$dernier_jour_semaine 19:00:00' ORDER BY debut ASC";
$result = $conn->query($sql);

// Étape 4 : Afficher les résultats
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="planning.css">
    <title>Planning des réservations</title>
    <style>
        /* Votre CSS pour la mise en page du planning */
    </style>
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
                <div class="table">
                    <h1>Planning des réservations</h1>

                    <form method="get" action="planning.php">
                        <label for="jour">Jour :</label>
                        <input type="date" name="jour" value="<?php echo $jour_selectionne; ?>">
                        <label for="heure">Heure :</label>
                        <input type="time" name="heure" value="<?php echo $heure_selectionnee; ?>">
                        <button type="submit">Afficher</button>
                    </form>

                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Heure de début</th>
                            <th>Heure de fin</th>
                            <th>Utilisateur</th>
                            <th>Titre</th>
                            <th>Description</th>
                        </tr>

                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . date('d/m/Y', strtotime($row["debut"])) . "</td>";
                                echo "<td>" . date('H:i', strtotime($row["debut"])) . "</td>";
                                echo "<td>" . date('H:i', strtotime($row["fin"])) . "</td>";
                                echo "<td>" . $row["login"] . "</td>";
                                echo "<td>" . $row["titre"] . "</td>";
                                echo "<td>" . $row["description"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Aucune réservation pour cette semaine dans la plage horaire de 8h à 19h.</td></tr>";
                        }
                        ?>

                    </table>
                </div>
            </div>
        </section>
</body>
</html>

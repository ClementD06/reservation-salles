<?php
// Vérifier si l'utilisateur est connecté
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: connexion.php");
    exit;
}

// Vérifier si l'ID de réservation est présent dans l'URL
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    echo "ID de réservation non spécifié.";
    exit;
}

$reservationId = $_GET["id"];

// Connexion à la base de données
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "Choupimolly8490.";
$dbname = "reservationsalles";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Récupérer les informations de la réservation
$sql = "SELECT r.titre, r.description, r.debut, r.fin, u.login FROM reservations r JOIN utilisateurs u ON r.id_utilisateur = u.id WHERE r.id = $reservationId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $title = $row["titre"];
    $description = $row["description"];
    $startTime = date("H:i", strtotime($row["debut"]));
    $endTime = date("H:i", strtotime($row["fin"]));
    $user = $row["login"];
} else {
    echo "Réservation non trouvée.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="reservation.css">
    <title>Détails de la réservation</title>
</head>
<body>
    <section class="section_1">
        <div class="background">
            <h2>Détails de la réservation</h2>
            <p><strong>Créateur:</strong> <?php echo $user; ?></p>
            <p><strong>Titre:</strong> <?php echo $title; ?></p>
            <p><strong>Description:</strong> <?php echo $description; ?></p>
            <p><strong>Heure de début:</strong> <?php echo $startTime; ?></p>
            <p><strong>Heure de fin:</strong> <?php echo $endTime; ?></p>
        </div>
    </section>
</body>
</html>

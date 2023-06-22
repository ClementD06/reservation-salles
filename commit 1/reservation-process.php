<?php
session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    // Utilisateur connecté
    $user_id = $_SESSION["user_id"]; // Récupérer l'id de l'utilisateur à partir de la variable de session
    if (isset($_POST["titre"]) && isset($_POST["description"]) && isset($_POST["date_debut"]) && isset($_POST["date_fin"])) {
        // Récupérer les valeurs du formulaire
        $titre = $_POST["titre"];
        $description = $_POST["description"];
        $dateDebut = $_POST["date_debut"];
        $dateFin = $_POST["date_fin"];
        $createur = $_SESSION["login"];

        // Connexion à la base de données
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "Choupimolly8490.";
        $dbname = "reservationsalles";

        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

        if ($conn->connect_error) {
            die("La connexion à la base de données a échoué : " . $conn->connect_error);
        }

        // Requête d'insertion de la réservation
        $sql = "INSERT INTO reservations (titre, description, debut, fin, id_utilisateur) VALUES ('$titre', '$description', '$dateDebut', '$dateFin', (SELECT id FROM utilisateurs WHERE login='$createur'))";

        if ($conn->query($sql) === true) {
            echo "La réservation a été créée avec succès.";

            // Redirection vers la page planning.php
            header("Location: planning.php");
            exit();
        } else {
            echo "Une erreur s'est produite lors de la création de la réservation : " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Tous les champs du formulaire doivent être remplis.";
    }
} else {
    echo "Vous devez être connecté pour effectuer une réservation.";
}

?>


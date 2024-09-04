<?php
session_start();
include_once 'db.php';
include_once 'Billet.php';

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = (new Database())->getConnection();
$billet = new Billet($db);

// Vérifier que les données sont envoyées via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assigner les valeurs du formulaire aux variables
    $user_id = $_SESSION['user_id'];
    $spectacle_id = $_POST['spectacle_id'];
    $seats = $_POST['seats'];

    // Trouver la salle associée au spectacle
    $query = $db->prepare("SELECT salle_id FROM spectacles WHERE id = :spectacle_id");
    $query->bindParam(':spectacle_id', $spectacle_id);
    $query->execute();
    $salle_id = $query->fetchColumn();

    // Création d'un nouvel objet Billet
    $billet->user_id = $user_id;
    $billet->spectacle_id = $spectacle_id;
    $billet->salle_id = $salle_id;
    $billet->seats = $seats;

    // Insérer les données dans la base de données
    if ($billet->create()) {
        $success_message = "Réservation réussie !";
    } else {
        $error_message = "Erreur lors de la réservation. Veuillez réessayer.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Réservation - Réservation de Spectacles</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Réservation</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="account.php">Mon Compte</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>
    <main>
        <?php if (isset($success_message)) { ?>
            <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php } ?>
        <a href="index.php">Retour à l'accueil</a>
    </main>
    <footer>
        <p>&copy; 2024 Réservation de Spectacles</p>
    </footer>
</body>

</html>
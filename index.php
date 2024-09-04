<?php
session_start();
include_once 'db.php';
include_once 'Spectacle.php';
include_once 'Salle.php';

$db = (new Database())->getConnection();
$spectacle = new Spectacle($db);
$salle = new Salle($db);

$spectacles = $spectacle->read();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Accueil - Réservation de Spectacles</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Accueil</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="account.php">Mon Compte</a>
            <a href="login.php">Connexion</a>
            <a href="register.php">Inscription</a>
        </nav>
    </header>
    <main>
        <h2>Les Spectacles à Venir</h2>
        <?php while ($row = $spectacles->fetch(PDO::FETCH_ASSOC)) {
            $salle_query = $db->prepare("SELECT name FROM salles WHERE id = :salle_id");
            $salle_query->bindParam(':salle_id', $row['salle_id']);
            $salle_query->execute();
            $salle_name = $salle_query->fetchColumn();
        ?>
            <div class="spectacle">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <p>Date: <?php echo htmlspecialchars($row['date']); ?></p>
                <p>Salle: <?php echo htmlspecialchars($salle_name); ?></p>
                <form action="reserve.php" method="post">
                    <input type="hidden" name="spectacle_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                    <input type="hidden" name="salle_id" value="<?php echo htmlspecialchars($row['salle_id']); ?>">
                    <input type="number" name="seats" min="1" required>
                    <input type="submit" value="Réserver">
                </form>
            </div>
        <?php } ?>
    </main>
    <footer>
        <p>&copy; 2024 Réservation de Spectacles</p>
    </footer>
</body>

</html>
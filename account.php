<?php
session_start();
include_once 'db.php';
include_once 'User.php';
include_once 'Billet.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = (new Database())->getConnection();
$user = new User($db);
$billet = new Billet($db);

$reservations = $billet->getUserReservations($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mon Compte - Réservation de Spectacles</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Mon Compte</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="account.php">Mon Compte</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>
    <main>
        <h2>Mes Réservations</h2>
        <?php if ($reservations->rowCount() > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Spectacle</th>
                        <th>Salle</th>
                        <th>Nombre de Places</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $reservations->fetch(PDO::FETCH_ASSOC)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['spectacle_title']); ?></td>
                            <td><?php echo htmlspecialchars($row['salle_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['seats']); ?></td>
                            <td><?php echo htmlspecialchars($row['spectacle_date']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Aucune réservation trouvée.</p>
        <?php } ?>

        <h2>Inscription d'un Nouvel Utilisateur</h2>
        <form action="account.php" method="post">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" name="register" value="S'inscrire">
        </form>
        <?php if (isset($registration_error) && !empty($registration_error)) { ?>
            <p class="error"><?php echo htmlspecialchars($registration_error); ?></p>
        <?php } ?>
        <?php if (isset($success_message)) { ?>
            <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
        <?php } ?>
    </main>
    <footer>
        <p>&copy; 2024 Réservation de Spectacles</p>
    </footer>
</body>

</html>
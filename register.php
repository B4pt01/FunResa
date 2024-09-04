<?php
session_start();
include_once 'db.php';
include_once 'User.php';

if (isset($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

$db = (new Database())->getConnection();
$user = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user->username = $_POST['username'];
    $user->password = $_POST['password'];
    $user->email = $_POST['email'];

    if ($user->register()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Erreur lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription - Réservation de Spectacles</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Inscription</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="register.php">Inscription</a>
        </nav>
    </header>
    <main>
        <h2>Créez un compte</h2>
        <form action="register.php" method="post">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="S'inscrire">
        </form>
        <?php if (isset($error)) { ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php } ?>
    </main>
    <footer>
        <p>&copy; 2024 Réservation de Spectacles</p>
    </footer>
</body>

</html>
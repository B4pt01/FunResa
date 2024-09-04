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

    if ($user->login()) {
        $_SESSION['user_id'] = $user->id;
        header("Location: account.php");
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe invalide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion - Réservation de Spectacles</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Connexion</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="login.php">Connexion</a>
        </nav>
    </header>
    <main>
        <h2>Connectez-vous</h2>
        <form action="login.php" method="post">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Se Connecter">
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
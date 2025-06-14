<?php
session_start();
require_once '../inclusions/connexion_bd.php';

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $mdp = $_POST['mot_de_passe'] ?? '';

    $stmt = $db->prepare("SELECT * FROM administrateur WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($mdp, $admin['mot_de_passe'])) {
        $_SESSION['admin'] = $admin['id'];
        header('Location: tableau_de_bord.php');
        exit;
    } else {
        $erreur = 'Email ou mot de passe incorrect.';
    }
}
?>
<?php if ($erreur) echo "<p style='color:red;'>$erreur</p>"; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="../ressources/styles/log.css">
</head>
<body class="ad">
    
    <h2 class="conn">Connexion Admin</h2>
    <form method="post">
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Mot de passe</label>
        <input type="password" name="mot_de_passe" required>
        <button type="submit">Se connecter</button>
    </form>
    <a href="../accueil.php" class="ac">Accueil</a>
</body>
</html>
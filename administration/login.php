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

<h2>Connexion Admin</h2>
<?php if ($erreur) echo "<p style='color:red;'>$erreur</p>"; ?>
<form method="post">
    <label>Email :</label>
    <input type="email" name="email" required><br>
    <label>Mot de passe :</label>
    <input type="password" name="mot_de_passe" required><br>
    <button type="submit">Se connecter</button>
</form>
<a href="../accueil.php">← Revenir au page d'acceuil</a>
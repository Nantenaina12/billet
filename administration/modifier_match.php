<?php
require_once 'includes/header.php';
require_once '../inclusions/connexion_bd.php';

$id = $_GET['id'] ?? null;
if (!$id) die("ID manquant.");

$stmt = $db->prepare("SELECT * FROM matchs WHERE id = ?");
$stmt->execute([$id]);
$match = $stmt->fetch();
if (!$match) die("Match introuvable.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("UPDATE matchs SET equipe1=?, equipe2=?, date_heure=?, lieu=?, places_disponibles=?, description=?, prix=? WHERE id=?");
    $stmt->execute([
        $_POST['equipe1'],
        $_POST['equipe2'],
        $_POST['date_heure'],
        $_POST['lieu'],
        $_POST['places_disponibles'],
        $_POST['description'],
        $_POST['prix'],
        $id
    ]);
    header("Location: tableau_de_bord.php");
    exit;
}
?>

<h2>Modifier un match</h2>
<form method="post">
    <input name="equipe1"value="<?= $match['equipe1'] ?>" required><br>
    <input name="equipe2" value="<?= $match['equipe2'] ?>" required><br>
    <input type="datetime-local" name="date_heure" value="<?= str_replace(' ', 'T', $match['date_heure']) ?>" required><br>
    <input name="lieu" value="<?= $match['lieu'] ?>" required><br>
    <input type="number" name="places_disponibles" value="<?= $match['places_disponibles'] ?>" required><br>
    <input type="text" name="description" value="<?= $match['description'] ?>" required><br>
    <input type="number" name="prix" step="0.01" value="<?= $match['prix'] ?>" required><br>
    <button type="submit">Enregistrer</button>
</form>

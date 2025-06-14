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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Match</title>
    <link rel="stylesheet" href="../ressources/styles/modifier_match.css">
</head>
<body>
    <div class="edit-match-container">
        <h2 class="edit-match-title">Modifier un match</h2>
        <form method="post" class="edit-match-form">
            <div class="edit-match-field-group">
                <label>Équipe 1</label>
                <input type="text" class="edit-match-input" name="equipe1" value="<?= htmlspecialchars($match['equipe1']) ?>" required>
            </div>
            
            <div class="edit-match-field-group">
                <label>Équipe 2</label>
                <input type="text" class="edit-match-input" name="equipe2" value="<?= htmlspecialchars($match['equipe2']) ?>" required>
            </div>
            
            <div class="edit-match-field-group">
                <label>Date et Heure</label>
                <input type="datetime-local" class="edit-match-input" name="date_heure" value="<?= str_replace(' ', 'T', $match['date_heure']) ?>" required>
            </div>
            
            <div class="edit-match-field-group">
                <label>Lieu</label>
                <input type="text" class="edit-match-input" name="lieu" value="<?= htmlspecialchars($match['lieu']) ?>" required>
            </div>
            
            <div class="edit-match-field-group">
                <label>Places disponibles</label>
                <input type="number" class="edit-match-input" name="places_disponibles" value="<?= (int)$match['places_disponibles'] ?>" required>
            </div>
            
            <div class="edit-match-field-group">
                <label>Description</label>
                <input type="text" class="edit-match-input" name="description" value="<?= htmlspecialchars($match['description']) ?>">
            </div>
            
            <div class="edit-match-field-group">
                <label>Prix (USD)</label>
                <input type="number" class="edit-match-input" name="prix" step="0.01" value="<?= number_format($match['prix'], 2) ?>" required>
            </div>
            
            <button type="submit" class="edit-match-submit">Enregistrer les modifications</button>
        </form>
    </div>
</body>
</html>
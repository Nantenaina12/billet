<?php
require_once 'includes/header.php';
require_once '../inclusions/connexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("INSERT INTO matchs (equipe1, equipe2, date_heure, lieu, places_disponibles, description, prix) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['equipe1'],
        $_POST['equipe2'],
        $_POST['date_heure'],
        $_POST['lieu'],
        $_POST['places_disponibles'],
        $_POST['description'],
        $_POST['prix']
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
    <title>Ajouter un match</title>
    <link rel="stylesheet" href="../ressources/styles/ajoutmatch.css">
</head>
<body>
    <div class="form-add-match">
        <h2>Ajouter un match</h2>
        <form method="post">
            <div class="form-group">
                <label>Équipe 1 :</label>
                <input type="text" name="equipe1" required>
            </div>
            
            <div class="form-group">
                <label>Équipe 2 :</label>
                <input type="text" name="equipe2" required>
            </div>
            
            <div class="form-group">
                <label>Date :</label>
                <input type="datetime-local" name="date_heure" required>
            </div>
            
            <div class="form-group">
                <label>Lieu :</label>
                <input type="text" name="lieu" required>
            </div>
            
            <div class="form-group">
                <label>Places disponibles :</label>
                <input type="number" name="places_disponibles" required>
            </div>
            
            <div class="form-group">
                <label>Description :</label>
                <input type="text" name="description" required>
            </div>
            
            <div class="form-group">
                <label>Prix :</label>
                <input type="number" step="0.01" name="prix" required>
            </div>
            
            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>
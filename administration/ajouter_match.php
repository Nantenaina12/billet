<?php
require_once 'includes/header.php';
require_once '../inclusions/connexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("INSERT INTO matchs (equipe1, equipe2, date_heure, lieu, places_disponibles, descriptio, prix) VALUES (?, ?, ?, ?, ?, ?,?)");
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

<h2>Ajouter un match</h2>
<form method="post">
    <label>Équipe 1 :</label><input name="equipe1" required><br>
    <label>Équipe 2 :</label><input name="equipe2" required><br>
    <label>Date :</label><input type="datetime-local" name="date_heure" required><br>
    <label>Lieu :</label><input name="lieu" required><br>
    <label>Places disponibles :</label><input type="number" name="places_disponibles" required><br>
    <label>Desription:</label><input type="text" name="description" required><br>
    <label>Prix :</label><input type="number" step="0.01" name="prix" required><br>
    <button type="submit">Ajouter</button>
</form>

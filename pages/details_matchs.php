<?php
// Connexion à la base
require_once '../inclusions/connexion_bd.php';

// Vérifier si un ID est passé en paramètre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Aucun match sélectionné.");
}

$id = (int) $_GET['id'];

// Requête pour récupérer les détails du match
$stmt = $db->prepare("SELECT * FROM matchs WHERE id = ?");
$stmt->execute([$id]);
$match = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$match) {
    die("Match introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Match</title>
    <link rel="stylesheet" href="../ressources/styles/style.css">
</head>
<body>
    <h1>Détails du Match</h1>

    <h2><?= htmlspecialchars($match['equipe1']) ?> vs <?= htmlspecialchars($match['equipe2']) ?></h2>
    <p><strong>Date & heure :</strong> <?= date('d/m/Y H:i', strtotime($match['date_heure'])) ?></p>
    <p><strong>Lieu :</strong> <?= htmlspecialchars($match['lieu']) ?></p>
    <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($match['description'])) ?></p>
    <p><strong>Prix :</strong> <?= $match['prix'] ?> USD</p>
    <p><strong>Places disponibles :</strong> <?= $match['places_disponibles'] ?></p>

    <a href="../reserver.php?id=<?= $match['id'] ?>">
        <button>Réserver un billet</button>
    </a>

    <br><br>
    <a href="../accueil.php">← Retour à la liste des matchs</a>
</body>
</html>

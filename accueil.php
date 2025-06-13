<?php
require_once('inclusions/connexion_bd.php');



// Requête pour récupérer tous les matchs
$matchs = $db->query("SELECT * FROM matchs ORDER BY date_heure ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Billetterie CAN Maroc</title>
    <link rel="stylesheet" href="ressources/styles/style.css">
</head>
<body class="acceuil">
    <nav>
        <img src="ressources/images/Canlogo.png" class="logocan">

        <h1>Matchs disponibles - CAN 2025 </h1>
        <img src="ressources/images/ballon3.jpg" class="ballon">
        <a href="administration/login.php"><img src="ressources/images/admin.png" class="admin"></a>

    </nav>
    <div id="message"></div>


    <?php foreach ($matchs as $match): ?>
        <div class="match">
            <h2><?= htmlspecialchars($match['equipe1']) ?> vs <?= htmlspecialchars($match['equipe2']) ?></h2>
            <p><strong>Date & heure :</strong> <?= date('d/m/Y H:i', strtotime($match['date_heure'])) ?></p>
            <p><strong>Lieu :</strong> <?= htmlspecialchars($match['lieu']) ?></p>
            <p><strong>Prix :</strong> <?= $match['prix'] ?> USD</p>
            <a href="pages/details_matchs.php?id=<?= $match['id'] ?>">Détails</a>
        </div>
        <hr>
    <?php endforeach; ?>
    <script src="ressources/scripts/script.js"></script>
</body>
</html>

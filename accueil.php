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
    <link rel="stylesheet" href="ressources/styles/accueil.css">
</head>
<body class="acceuil">
    <nav>
        <img src="ressources/images/Canlogo.png" class="logocan">

        <h1>Matchs disponibles - CAN 2025 </h1>
        <img src="ressources/images/ballon3.jpg" class="ballon">
        <a href="administration/login.php"><img src="ressources/images/admin.png" class="admin"></a>

    </nav>
    <div id="resultat"></div>
    <div id="message"></div>
    <?php foreach ($matchs as $match): ?>

        <div class="match">

            <div class="teams">
                <div class="drapeau1">
                    <img src="<?= htmlspecialchars($match['team1_flag']) ?>"width="100" height="60">
                    <p><?= htmlspecialchars($match['equipe1']) ?></p>
                </div>
                <p class="para">vs</p>
                <div class="drapeau2">
                    <img src="<?= htmlspecialchars($match['team2_flag']) ?>"width="100" height="60">
                    <p><?= htmlspecialchars($match['equipe2']) ?></p>
                </div>
            
            </div>
            <p><strong>Date & heure :</strong> <?= date('d/m/Y H:i', strtotime($match['date_heure'])) ?></p>
            <p><strong>Lieu :</strong> <?= htmlspecialchars($match['lieu']) ?></p>
            <p><strong>Prix :</strong> <?= number_format($match['prix'], 2) ?> USD</p>
            <a href="pages/details_matchs.php?id=<?= (int)$match['id'] ?>" class="plus">Détails</a>
        </div>
    <?php endforeach; ?>

    <script src="ressources/scripts/script.js"></script>
    <footer>© Orlando 2025 - Tous droits réservés</footer>
</body>
</html>

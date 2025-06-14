<?php
require_once 'includes/header.php';
require_once '../inclusions/connexion_bd.php';

$stmt = $db->query("SELECT * FROM matchs ORDER BY date_heure ASC");
$matchs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - CAN 2025</title>
    <link rel="stylesheet" href="../ressources/styles/bord.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Tableau de bord - CAN 2025</h2>
        
        <div class="action-links">
            <a href="ajouter_match.php"><span>➕</span> Ajouter un match</a>
            <a href="deconnexion.php"><span>🔒</span> Déconnexion</a>
        </div>
        
        <div class="table-responsive">
            <table class="matches-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Équipes</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Places</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($matchs as $index => $match): ?>
                        <tr style="--order: <?= $index ?>">
                            <td><?= $match['id'] ?></td>
                            <td class="team-matchup">
                                <?= htmlspecialchars($match['equipe1']) ?> vs <?= htmlspecialchars($match['equipe2']) ?>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($match['date_heure'])) ?></td>
                            <td><?= htmlspecialchars($match['lieu']) ?></td>
                            <td><?= $match['places_disponibles'] ?></td>
                            <td><?= substr(htmlspecialchars($match['description']), 0, 30) ?><?= strlen($match['description']) > 30 ? '...' : '' ?></td>
                            <td class="price-cell"><?= number_format($match['prix'], 2) ?> USD</td>
                            <td class="action-cell">
                                <a href="modifier_match.php?id=<?= $match['id'] ?>" class="edit-link">✏️ Modifier</a>
                                <a href="supprimer_match.php?id=<?= $match['id'] ?>" 
                                   class="delete-link" 
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce match ?')">🗑️ Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../js/admin-dashboard.js"></script>
</body>
</html>

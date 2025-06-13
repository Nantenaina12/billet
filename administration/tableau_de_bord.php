<?php
require_once 'includes/header.php';
require_once '../inclusions/connexion_bd.php';

$stmt = $db->query("SELECT * FROM matchs ORDER BY date_heure ASC");
$matchs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Tableau de bord</h2>
<p><a href="ajouter_match.php">➕ Ajouter un match</a> | <a href="deconnexion.php">🔒 Déconnexion</a></p>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th><th>Équipes</th><th>Date</th><th>Lieu</th><th>Places</th><th>Description</th><th>Prix</th><th>Actions</th>
    </tr>
    <?php foreach ($matchs as $match): ?>
        <tr>
            <td><?= $match['id'] ?></td>
            <td><?= htmlspecialchars($match['equipe1']) ?> vs <?= htmlspecialchars($match['equipe2']) ?></td>
            <td><?= $match['date_heure'] ?></td>
            <td><?= htmlspecialchars($match['lieu']) ?></td>
            <td><?= $match['places_disponibles'] ?></td>
            <td><?= $match['description'] ?></td>
            <td><?= $match['prix'] ?> USD </td>
            <td>
                <a href="modifier_match.php?id=<?= $match['id'] ?>">✏️ Modifier</a> |
                <a href="supprimer_match.php?id=<?= $match['id'] ?>" onclick="return confirm('Supprimer ce match ?')">🗑️ Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

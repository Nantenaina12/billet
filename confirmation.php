<?php
session_start();
if (!isset($_SESSION['ticket_pdf'], $_SESSION['id_reservation'], $_SESSION['donnees_resa'])) {
    die("Aucune réservation trouvée.");
}

$fichier = $_SESSION['ticket_pdf'];
$donnees = $_SESSION['donnees_resa'];
$chemin_pdf = 'tickets/' . $fichier;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Confirmation de réservation</title>
    <link rel="stylesheet" href="ressources/styles/confirmer.css"
</head>
<body>
    <h2>🎉 Réservation confirmée !</h2>
    <p>Merci pour votre achat. Votre billet est prêt.</p>
    <ul>
        <li>📄 <a href="<?= htmlspecialchars($chemin_pdf) ?>" target="_blank">Télécharger votre billet PDF</a></li>
    </ul>

    <p>💌 Le billet a été envoyé à votre adresse email : <strong><?= htmlspecialchars($donnees['email']) ?></strong></p>
    <a href="accueil.php">Réserver autre match</a>
</body>
</html>

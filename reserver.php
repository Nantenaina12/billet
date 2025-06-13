<?php
session_start();
require_once 'inclusions/connexion_bd.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Match non spécifié.");
}

$id_match = (int) $_GET['id'];

// Récupérer les infos du match
$stmt = $db->prepare("SELECT * FROM matchs WHERE id = ?");
$stmt->execute([$id_match]);
$match = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$match) {
    die("Match introuvable.");
}

$confirmation = "";
$erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $nb_billets = (int) $_POST['nb_billets'];

    if ($nom && $prenom && $email && $telephone && $nb_billets > 0) {
        if ($nb_billets <= $match['places_disponibles']) {
            try {
                $db->beginTransaction();

                // Insertion réservation
                $stmt = $db->prepare("INSERT INTO reservations (id_match, nom, prenom, email, telephone, nb_billets) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$id_match, $nom, $prenom, $email, $telephone, $nb_billets]);

                $stmt->execute([$nb_billets, $id_match]);

                $db->commit();

                // Génération du PDF
                require_once '..pages/ generer_ticket_pdf.php';
                $pdf_data = genererTicketPDF([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'match' => $match['equipe1'] . ' vs ' . $match['equipe2'],
                    'date' => $match['date_heure'],
                    'lieu' => $match['lieu'],
                    'nb_billets' => $nb_billets
                ]);

                $_SESSION['chemin_pdf'] = $pdf_data['chemin_pdf'];
                $_SESSION['nom_pdf'] = $pdf_data['nom_pdf'];
                $confirmation .= "📄 <a href='" . $_SESSION['chemin_pdf'] . "' target='_blank'>Télécharger votre billet PDF</a>";



            } catch (Exception $e) {
                $db->rollBack();
                $erreur = "Erreur lors de la réservation : " . $e->getMessage();
            }
        } else {
            $erreur = "❌ Pas assez de places disponibles.";
        }
    } else {
        $erreur = "❌ Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réserver un billet</title>
    <link rel="stylesheet" href="../ressources/styles/style.css">
</head>
<body>
    <h1>Réservation pour <?= htmlspecialchars($match['equipe1']) ?> vs <?= htmlspecialchars($match['equipe2']) ?></h1>

    <?php if ($confirmation): ?>
        <div style="color: green;"><?= $confirmation ?></div>
    <?php elseif ($erreur): ?>
        <div style="color: red;"><?= $erreur ?></div>
    <?php endif; ?>

    <?php if (!$confirmation): ?>

        <form method="post" action="payer.php">



            <input type="hidden" name="id_match"value="<?= $match['id'] ?>">


            <label>Nom :</label><br>
            <input type="text" name="nom" required><br><br>

            <label>Prénom :</label><br>
            <input type="text" name="prenom" required><br><br>

            <label>Email :</label><br>
            <input type="email" name="email" required><br><br>

            <label>Téléphone :</label><br>
            <input type="text" name="telephone" required><br><br>

            <label>Nombre de billets :</label><br>
            <input type="number" name="nb_billets" min="1" max="1" required><br><br>

            <button type="submit">Payer avec PayPal</button>
    </form>

        
    <?php endif; ?>

    <br><a href="pages/details_matchs.php?id=<?= $match['id'] ?>">← Retour aux détails</a>
</body>
</html>
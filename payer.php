<?php
require_once 'inclusions/connexion_bd.php';
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Accès direct non autorisé');
}

$nom      = trim($_POST['nom']);
$prenom   = trim($_POST['prenom']);
$email    = trim($_POST['email']);
$telephone= trim($_POST['telephone']);
$nb       = (int)$_POST['nb_billets'];
$id       = (int)$_POST['id_match'];

// Récupération des infos du match
$stmt = $db->prepare("SELECT * FROM matchs WHERE id = ?");
$stmt->execute([$id]);
$match = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$match) {
    die('Match introuvable.');
}

$total = $nb * $match['prix'];

// On sauvegarde les données dans la session
$_SESSION['donnees_resa'] = compact('nom','prenom','email','telephone','nb','id');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement PayPal</title>
    <link rel="stylesheet" href="ressources/styles/pay.css">
    <script src="https://www.paypal.com/sdk/js?client-id=<?= PAYPAL_CLIENT_ID ?>&currency=USD"></script>
</head>
<body>
    <h2>Payer <?= number_format($total, 2) ?> USD pour <?= htmlspecialchars($match['equipe1'] . ' vs ' . $match['equipe2']) ?></h2>
    <div id="paypal-button-container"></div>

    <script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?= $total ?>'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                window.location.href = "<?= RETURN_URL ?>?orderID=" + data.orderID;
            });
        },
        onCancel: function() {
            window.location.href = "<?= CANCEL_URL ?>";
        },
        onError: function(err) {
            alert("Erreur PayPal : " + err);
        }
    }).render('#paypal-button-container');
    </script>
</body>
</html>
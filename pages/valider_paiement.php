<?php
require_once '../inclusions/connexion_bd.php';
require_once 'generer_ticket_pdf.php';
require_once '../inclusions/envoi_mail.php'; // ✔️ Ce fichier envoie le mail
session_start();

if (!isset($_SESSION['donnees_resa'])) {
    die("Données de réservation manquantes.");
}

$donnees = $_SESSION['donnees_resa'];

$orderID = $_GET['orderID'] ?? null;
if (!$orderID) die("Identifiant de commande manquant.");

$id_match = (int)$donnees['id'];

$stmt = $db->prepare("SELECT * FROM matchs WHERE id = ?");
$stmt->execute([$id_match]);
$match = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$match) die("Match introuvable.");

$total = $donnees['nb'] * $match['prix'];

try {
    $db->beginTransaction();

    $stmt = $db->prepare("INSERT INTO reservations (nom, prenom, email, telephone, nb_billets, id_match, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $donnees['nom'],
        $donnees['prenom'],
        $donnees['email'],
        $donnees['telephone'],
        $donnees['nb'],
        $id_match,
        $total
    ]);

    $id_reservation = $db->lastInsertId();

    $stmt = $db->prepare("UPDATE matchs SET places_disponibles = places_disponibles - ? WHERE id = ?");
    $stmt->execute([$donnees['nb'], $id_match]);

    $db->commit();

    // Générer le PDF
    $fichier_pdf = generer_ticket_pdf($db, $id_reservation, $donnees, $match, $total);
    $chemin_pdf = __DIR__ . '/../tickets/' . $fichier_pdf;

    // ✅ Envoi du billet au client
    $result = envoyerBilletParEmail(
        $donnees['email'],
        $donnees['prenom'] . ' ' . $donnees['nom'],
        $chemin_pdf
    );

    if ($result !== true) {
        error_log("Erreur email : " . $result);
    }

    $_SESSION['ticket_pdf'] = $fichier_pdf;
    $_SESSION['id_reservation'] = $id_reservation;

    header("Location: ../confirmation.php");
    exit;

} catch (Exception $e) {
    $db->rollBack();
    die("Erreur lors de la réservation : " . $e->getMessage());
}


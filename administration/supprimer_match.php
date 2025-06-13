<?php
require_once 'includes/header.php';
require_once '../inclusions/connexion_bd.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $db->prepare("DELETE FROM matchs WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: tableau_de_bord.php");
exit;

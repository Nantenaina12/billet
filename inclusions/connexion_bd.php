<?php
$hote = 'localhost';        // ou 127.0.0.1
$utilisateur = 'root';      // nom d'utilisateur MySQL (souvent 'root' en local)
$mot_de_passe = '';         // mot de passe (souvent vide en local)
$nom_bd = 'billetterie_can';

try {
    $db = new PDO("mysql:host=$hote;dbname=$nom_bd;charset=utf8", $utilisateur, $mot_de_passe);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>

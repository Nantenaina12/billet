<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

function envoyerBilletParEmail($client_email, $client_nom, $chemin_fichier_pdf) {
    $mail = new PHPMailer(true);

    try {
        // Config serveur Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'nantenainaorlando1@gmail.com';// 👉 Ton adresse Gmail
        $mail->Password   = 'ttsdlkujqkvhpchk'; // 👉 Ton mot de passe ou mot de passe d'application
        $mail->SMTPSecure = 'STARTTLS';
        $mail->Port       = 587;

        // Infos expéditeur
        $mail->setFrom('nantenainaorlando1@gmail.com', 'Billetterie CAN 2025');

        // Destinataire : le client
        $mail->addAddress($client_email, $client_nom);

        // Pièce jointe
        $mail->addAttachment($chemin_fichier_pdf);

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = 'Votre billet pour la CAN 2025';
        $mail->Body    = "<p>Bonjour <strong>$client_nom</strong>,</p>
                          <p>Merci pour votre réservation ! Vous trouverez votre billet en pièce jointe.</p>
                          <p>⚽ Vive la CAN 2025 !</p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Erreur d'envoi de mail : {$mail->ErrorInfo}";
    }
}

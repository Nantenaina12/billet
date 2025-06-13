<?php
require_once __DIR__ . '/../inclusions/fpdf186/fpdf.php';

function generer_ticket_pdf($db, $id_reservation, $donnees, $match, $total) {
    $stmt = $db->prepare("SELECT * FROM reservations WHERE id = ?");
    $stmt->execute([$id_reservation]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reservation) {
        die("Réservation introuvable.");
    }

    $pdf = new FPDF();
    $pdf->AddPage();

    // Logo texte en haut
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->SetTextColor(0, 51, 102);
    $pdf->Cell(0, 15, ' CAN 2025 - Billet Officiel ', 0, 1, 'C');
    $pdf->Ln(5);
    // Encadré du billet
    $pdf->SetDrawColor(0, 51, 102);
    $pdf->SetLineWidth(1);
    $pdf->Rect(10, 30, 190, 100);

    // Infos client
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0);
    $pdf->SetXY(15, 35);
    $pdf->MultiCell(90, 7, utf8_decode("Nom : " . $donnees['nom'] . " " . $donnees['prenom']));
    $pdf->SetX(15);
    $pdf->MultiCell(90, 7, utf8_decode("Email : " . $donnees['email']));
    $pdf->SetX(15);
    $pdf->MultiCell(90, 7, utf8_decode("Téléphone : " . $donnees['telephone']));

    // Infos match
    $pdf->SetXY(110, 35);
    $pdf->MultiCell(90, 7, utf8_decode("Match : " . $match['equipe1'] . " vs " . $match['equipe2']));
    $pdf->SetX(110);
    $pdf->MultiCell(90, 7, utf8_decode("Date & heure : " . $match['date_heure']));
    $pdf->SetX(110);
    $pdf->MultiCell(90, 7, utf8_decode("Terrain : " . $match['lieu']));
    $pdf->SetX(110);
    $pdf->MultiCell(90, 7, utf8_decode("Nombre de billets : " . $donnees['nb']));
    $pdf->SetX(110);
    $pdf->MultiCell(90, 7, utf8_decode("Total payé : " . number_format($total, 2) . " USD"));

    // Footer
    $pdf->SetY(-30);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->SetTextColor(100);
    $pdf->Cell(0, 10, utf8_decode("Merci de présenter ce billet à l'entrée du stade."), 0, 1, 'C');

    $nom_fichier = "ticket_" . $id_reservation . ".pdf";
    $chemin = __DIR__ . '/../tickets/' . $nom_fichier;
    $pdf->Output('F', $chemin); // Sauvegarder dans le dossier

    return $nom_fichier;
}

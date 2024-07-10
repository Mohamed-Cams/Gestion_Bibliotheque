<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'tcpdf/tcpdf.php';

$host = "mysql:host=127.0.0.1;dbname=bibliotheque";
$username = "root";
$password = "";

try {
    $pdo = new PDO($host, $username, $password);

    // Exemple d'exécution d'une requête pour récupérer les livres empruntés
    $query = "SELECT * FROM emprunts";
    $emprunts = $pdo->prepare($query);
    $emprunts->execute();
    $result = $emprunts->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}



// Créer un nouveau document PDF
$pdf = new TCPDF('L', 'mm', 'A3', true, 'UTF-8');
$pdf->SetTitle('Liste des Emprunts');
$pdf->AddPage();
$html = '<h1>Booky: Liste Des Emprunts</h1><br>';
$pdf->writeHTML($html);
// Définir la police et le contenu du PDF
$pdf->SetFont('helvetica', '', 12);

// En-tête du tableau dans le PDF
$pdf->Cell(30, 10, 'ID Emprunt', 1, 0, 'C');
$pdf->Cell(30, 10, 'ID Livre', 1, 0, 'C');
$pdf->Cell(100, 10, 'Email Emprunteur', 1, 0, 'C');
$pdf->Cell(50, 10, 'Date Emprunt', 1, 0, 'C');
$pdf->Cell(50, 10, 'Date Retour Prévue', 1, 0, 'C');
$pdf->Cell(70, 10, 'Date Retour', 1, 0, 'C');
$pdf->Cell(70, 10, 'État', 1, 1, 'C');

// Données des emprunts dans le PDF
foreach ($result as $emprunt) {
    $pdf->Cell(30, 10, $emprunt['id'], 1, 0, 'C');
    $pdf->Cell(30, 10, $emprunt['fk_livre'], 1, 0, 'C');
    $pdf->Cell(100, 10, $emprunt['fk_utilisateur'], 1, 0, 'C');
    $pdf->Cell(50, 10, $emprunt['date_emprunt'], 1, 0, 'C');
    $pdf->Cell(50, 10, $emprunt['date_retour_prevue'], 1, 0, 'C');
    $pdf->Cell(70, 10, $emprunt['date_retour'] ?: 'Non rendu', 1, 0, 'C');

    // Calcul de l'état
    if ($emprunt['date_retour'] === null) {
        $etat = 'Pas encore rendu';
    } elseif ($emprunt['date_retour'] < $emprunt['date_retour_prevue']) {
        $etat = 'Rendu avant délai';
    } elseif ($emprunt['date_retour'] > $emprunt['date_retour_prevue']) {
        $etat = 'Rendu après délai';
    } else {
        $etat = 'Rendu à temps';
    }

    $pdf->Cell(70, 10, $etat, 1, 1, 'C');
}

// Sortie du PDF en tant que téléchargement
$pdf->Output('liste_emprunts.pdf', 'I');

<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Infrastructure\Pdf;

use App\PublicApp\Membership\Domain\DTO\Pdf\MembershipPdf;

readonly class MembershipPdfGenerator
{
    public function generate(MembershipPdf $membershipPdf): string
    {
        $today = $membershipPdf->now->format('d/m/Y');
        $year = $membershipPdf->now->format('Y');

        $pdf = new \TCPDF();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(left: 20, top: 20);
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $pdf->SetFont(family: 'helvetica', style: 'B', size: 16);
        $pdf->Cell(w: 0, h: 10, txt: 'SAINT-OUEN MUSCULATION', ln: 1, align: 'C');
        $pdf->SetFont(family: 'helvetica', size: 11);
        $pdf->Ln(h: 2);
        $pdf->Cell(w: 0, h: 6, txt: "Bulletin d’adhésion – Année {$year}", ln: 1, align: 'C');
        $pdf->Ln(h: 8);

        $pdf->SetFont(family: 'helvetica', style: 'B', size: 11);
        $pdf->Cell(w: 0, h: 6, txt: 'IDENTITÉ DE L’ADHÉRENT', ln: 1);
        $pdf->Ln(h: 2);
        $pdf->SetFont(family: 'helvetica', size: 10);
        $pdf->Cell(w: 50, h: 8, txt: 'Nom et Prénom :', border: 1);
        $pdf->Cell(w: 0, h: 8, txt: $membershipPdf->lastname.' '.$membershipPdf->firstname, border: 1, ln: 1);
        $pdf->Cell(w: 50, h: 8, txt: 'Sexe :', border: 1);
        $pdf->Cell(w: 0, h: 8, txt: $membershipPdf->gender, border: 1, ln: 1);
        $pdf->Cell(w: 50, h: 8, txt: 'Date de naissance :', border: 1);
        $pdf->Cell(w: 0, h: 8, txt: $membershipPdf->birthday, border: 1, ln: 1);
        $pdf->Cell(w: 50, h: 8, txt: 'Téléphone :', border: 1);
        $pdf->Cell(w: 0, h: 8, txt: $membershipPdf->phone, border: 1, ln: 1);
        $pdf->Cell(w: 50, h: 8, txt: 'Adresse :', border: 1);
        $pdf->Cell(w: 0, h: 8, txt: $membershipPdf->address, border: 1, ln: 1);
        $pdf->Ln(h: 8);

        $pdf->SetFont(family: 'helvetica', style: 'B', size: 11);
        $pdf->Cell(w: 0, h: 6, txt: 'CONDITIONS D’ADHÉSION', ln: 1);
        $pdf->Ln(h: 2);
        $pdf->SetFont(family: 'helvetica', size: 10);
        $pdf->MultiCell(w: 0, h: 6, txt:"L’adhésion est valable du 1er janvier {$year} au 31 décembre {$year}.", ishtml: true);
        $pdf->Ln(h: 2);
        $pdf->MultiCell(w: 0, h: 6, txt:'Pour les adhérents âgés de 10 à 16 ans, l’accès est limité aux séances de renforcement musculaire léger et de cardio-training. Toute activité impliquant des charges lourdes ou des exercices complexes est strictement interdite. La présence et la responsabilité d’un adulte accompagnateur sont obligatoires.', ishtml: true);
        $pdf->Ln(h: 2);
        $pdf->MultiCell(w: 0, h: 6, txt:'Pour des raisons d’hygiène et de sécurité, le port de chaussures propres et l’utilisation d’une serviette sont obligatoires à chaque séance.', ishtml: true);
        $pdf->Ln(h: 2);
        $pdf->MultiCell(w: 0, h: 6, txt:'L’adhésion est effective après remise du présent bulletin signé, d’un certificat médical valide couvrant toute la durée de l’adhésion (à défaut, celui-ci devra être renouvelé sous peine de suspension d’accès), ainsi que du règlement de la cotisation annuelle de 50 €.
        Une caution de 10 € est demandée pour le badge magnétique et restituée en cas de non-renouvellement.', ishtml: true);
        $pdf->Ln(h: 8);

        if ($membershipPdf->age < $membershipPdf->majorityAge) {
            $pdf->SetFont(family: 'helvetica', style: 'B', size: 11);
            $pdf->Cell(w: 0, h: 6, txt: 'AUTORISATION DU REPRÉSENTANT LÉGAL', ln: 1);
            $pdf->Ln(h: 2);
            $pdf->SetFont(family: 'helvetica', size: 10);
            $pdf->MultiCell(w: 0, h: 6, txt:"Je soussigné(e) {$membershipPdf->tutorNames}, demeurant au {$membershipPdf->tutorAddress}, représentant légal de {$membershipPdf->firstname} {$membershipPdf->lastname}, autorise ce dernier à fréquenter la salle de musculation de l’association Saint-Ouen Musculation.", ishtml: true);
            $pdf->Ln(h: 6);
        }

        $pdf->SetFont(family: 'helvetica', style: 'B', size: 11);
        $pdf->Cell(w: 0, h: 6, txt: 'ENGAGEMENT ET SIGNATURES', ln: 1);
        $pdf->Ln(h: 2);
        $pdf->SetFont(family: 'helvetica', size: 10);
        $pdf->MultiCell(w: 0, h: 6, txt:'Je reconnais avoir pris connaissance des statuts et du règlement intérieur de l’association et m’engage à les respecter.', ishtml: true);
        $pdf->Ln(h: 10);

        $pdf->Cell(w: 11, h: 6, txt: 'Fait à');
        $pdf->setTextColor(180, 180, 180);
        $pdf->Cell(w: 60, h: 6, txt: '______________________________');
        $pdf->setTextColor(0, 0, 0);
        $pdf->Cell(w: 0, h: 6, txt: ", le {$today}", ln: 1);
        $pdf->Ln(h: 10);
        $pdf->Cell(w: 56, h: 6, txt: 'Signature de l’adhérent :');
        if ($membershipPdf->age < $membershipPdf->majorityAge) {
            $pdf->Cell(w: 56, h: 6, txt: 'Signature du représentant légal :', align: 'C');
        }
        $pdf->Cell(w: 56, h: 6, txt: 'Signature de la direction :', align: 'R');
        $pdf->Ln(h: 16);
        $pdf->setTextColor(180, 180, 180);
        $pdf->Cell(w: 56, h: 6, txt: '____________________');
        if ($membershipPdf->age < $membershipPdf->majorityAge) {
            $pdf->Cell(w: 56, h: 6, txt: '____________________', align: 'C');
        }
        $pdf->Cell(w: 56, h: 6, txt: '____________________', align: 'R');

        return $pdf->Output(name: 'bulletin_adhesion_saint_ouen_musculation.pdf', dest: 'D');
    }
}

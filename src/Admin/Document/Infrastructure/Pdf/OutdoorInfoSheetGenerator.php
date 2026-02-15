<?php

declare(strict_types=1);

namespace App\Admin\Document\Infrastructure\Pdf;

use App\Admin\Document\Domain\DTO\Pdf\OutdoorInfoSheetPdf;

class OutdoorInfoSheetGenerator
{
    public function __construct()
    {
    }

    public function generate(OutdoorInfoSheetPdf $outdoorInfoSheetPdf): string
    {


        $pdf = new \TCPDF();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(left: 10, top: 10);
        $pdf->SetAutoPageBreak(auto: true, margin: 10);
        $pdf->AddPage();

        $pdf->SetFillColor(col1: 15, col2: 15, col3: 15);
        $pdf->Rect(x: 0, y: 0, w: $pdf->getPageWidth(), h: $pdf->getPageHeight(), style: 'F');

        // ---------------- LOGO TEXT ----------------
        $pdf->Image(file: $outdoorInfoSheetPdf->logo, x: 8, y: 5, w: 30, h: 30);

        $pdf->SetFont(family: 'helvetica', style: 'B', size: 28);
        $pdf->SetTextColor(col1: 182, col2: 136, col3: 42);
        $pdf->SetX(40);
        $pdf->Cell(w: 0, txt: 'Les Titans', ln: 2);

        $pdf->SetFont(family: 'helvetica', size: 14);
        $pdf->Cell(w: 0, txt: 'Saint Ouen Musculation', ln: 1);

        $pdf->SetY(40);
        $y = $pdf->GetY();
        $pdf->SetDrawColor(col1: 182, col2: 136, col3: 42);
        $pdf->SetLineWidth(1);
        $pdf->Line(x1: 0, y1: $y, x2: 210, y2: $y);
        $y = $pdf->GetY();

        // ---------------- INFOS ----------------

        // Section
        $borderStyle = ['width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => '0', 'color' => [182, 136, 42]];
        $pdf->RoundedRect(x: 10, y: 50, w: 190, h: 96, r: 1, style: 'DF', border_style: $borderStyle, fill_color: [42, 42, 42]);
        $pdf->RoundedRect(x: 10.5, y: 49.5, w: 190, h: 97, r: 1, round_corner: '1100', style: 'F', fill_color: [42, 42, 42]);
        $pdf->SetFillColor(col1: 42, col2: 42, col3: 42);
        $pdf->SetTextColor(col1: 182, col2: 136, col3: 42);
        $pdf->SetFont(family: 'helvetica', style: 'B', size: 15);
        $pdf->SetXY(x: 15, y: $y + 15);
        $pdf->Cell(w: 0, txt: 'Informations pratiques');
        $y = $pdf->GetY();
        $pdf->SetXY(x: 19, y: $y + 15);

        // Schedules
        $pdf->RoundedRect(x: 15, y: 67, w: 84, h: 75, r: 1, style: 'F', fill_color: [28, 28, 28]);
        $pdf->SetTextColor(col1: 245, col2: 245, col3: 245);
        $pdf->SetFont(family: 'helvetica', style: 'B', size: 12);
        $pdf->Cell(w: 76, txt: 'Horaires', ln: 1);
        $y = $pdf->GetY();
        $pdf->SetXY(x: 19, y: $y + 5);

        $pdf->SetFont(family: 'helvetica', size: 11);
        foreach ($outdoorInfoSheetPdf->schedules->getDays() as $day) {
            $pdf->Cell(w: 38, h: 7, txt: $day->getLabel());
            $pdf->Cell(w: 38, h: 7, txt: $day->getRangeAsString(), ln: 1, align: 'R');
            $pdf->SetX(19);
        }
        $y = $pdf->GetY();
        $pdf->SetXY(x: 19, y: $y + 5);

        $pdf->SetTextColor(col1: 107, col2: 114, col3: 128);
        $pdf->SetFont(family: 'helvetica', style: 'I', size: 9);
        $pdf->Cell(w: 76, txt: 'Sauf jours fériés');

        // QrCode
        $pdf->RoundedRect(x: 105, y: 67, w: 89, h: 75, r: 1, style: 'F', fill_color: [28, 28, 28]);
        $pdf->SetXY(x: 110, y: 70);
        $pdf->SetTextColor(col1: 245, col2: 245, col3: 245);
        $pdf->SetFont(family: 'helvetica', style: 'B', size: 12);
        $pdf->Cell(w: 76, txt: 'Site web', ln: 1);
        $pdf->Image(file: '@'.$outdoorInfoSheetPdf->qrcode, x: 122, y: 83, w: 55);


        // ---------------- MEMBERSHIP ----------------

        // Section
        $borderStyle = ['width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => '0', 'color' => [182, 136, 42]];
        $pdf->RoundedRect(x: 10, y: 156, w: 190, h: 74, r: 1, style: 'DF', border_style: $borderStyle, fill_color: [42, 42, 42]);
        $pdf->RoundedRect(x: 10.5, y: 155.5, w: 190, h: 75, r: 1, round_corner: '1100', style: 'F', fill_color: [42, 42, 42]);
        $pdf->SetFillColor(col1: 42, col2: 42, col3: 42);
        $pdf->SetTextColor(col1: 182, col2: 136, col3: 42);
        $pdf->SetFont(family: 'helvetica', style: 'B', size: 15);
        $pdf->SetXY(x: 15, y: 162);
        $pdf->Cell(w: 0, txt: 'Notre association');
        $y = $pdf->GetY();
        $pdf->SetXY(x: 15, y: $y + 13);

        $pdf->SetTextColor(col1: 245, col2: 245, col3: 245);
        $pdf->SetFont(family: 'helvetica', size: 11);
        $pdf->MultiCell(w: 172, h: 0, txt: 'Les Titans est une association sportive locale dédiée à la pratique de la musculation dans un esprit d’entraide et de respect.', align: '');
        $pdf->Ln(4);
        $pdf->SetX(15);
        $pdf->MultiCell(w: 172, h: 0, txt: 'Nous accueillons débutants comme pratiquants confirmés, avec un objectif simple : permettre à chacun de progresser à son rythme, dans un cadre sérieux et bienveillant.', align: '');
        $pdf->Ln(4);
        $pdf->SetX(15);
        $pdf->MultiCell(w: 172, h: 0, txt: 'La salle est gérée par des passionnés, pour les habitants de la commune et des alentours.', align: '');
        $pdf->Ln(4);
        $pdf->SetX(15);
        $pdf->MultiCell(w: 172, h: 0, txt: 'Retrouvez toutes les informations, modalités d’inscription et moyens de contact sur notre site via le QR code.', align: '');

        // ---------------- PHRASE ACCROCHE ----------------

        $pdf->SetY(-35);
        $pdf->SetTextColor(col1: 146, col2: 146, col3: 146);
        $pdf->SetFont(family: 'helvetica', style: 'I', size: 14);
        $pdf->Cell(w: 0, h: 10, txt: $outdoorInfoSheetPdf->slogan, align: 'C');

        return $pdf->Output(name: 'affiche_extérieure_porte_d_entrée.pdf', dest: 'D');
    }
}

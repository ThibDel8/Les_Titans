<?php

declare(strict_types=1);

namespace App\Service\PDF\Membership;

use TCPDF;
use App\Entity\Membership\Membership;
use Symfony\Contracts\Translation\TranslatorInterface;

class MembershipPdfGenerator
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    public function generate(Membership $membership): string
    {
        $now = new \DateTimeImmutable('now');
        $today = $now->format('d/m/Y');
        $year = $now->format('Y');
        $lastname = $membership->getLastname();
        $firstname = $membership->getFirstname();
        $birthday = $membership->getBirthdate()->format('d/m/Y');
        $gender = $this->translator->trans($membership->getGender()->label());
        $phone = $membership->getPhone();
        $address = $membership->getAddress().' '.$membership->getPostalcode().', '.$membership->getCity();
        $tutorNames = $membership->getTutorFirstname().' '.$membership->getTutorLastname();
        $tutorAddress = $membership->getTutorAddress();

        $pdf = new TCPDF();
        $pdf->setPrintHeader(false);
        $pdf->SetMargins(15, 20, 15);
        $pdf->AddPage();

        $pdf->setFontSize(20);
        $pdf->writeHTML(html: 'SAINT-OUEN MUSCULATION', align: 'C');

        $pdf->setFontSize(14);
        $pdf->writeHTML(html: 'SAISON '.$year, align: 'C');

        $pdf->setFontSize(11);
        $pdf->writeHTML(html: '<i>Bulletin d\'inscription du 1er janvier '.$year.' au 31 décembre </i>'.$year, align: 'C');
        $pdf->writeHTML(html: '<br><br>');

        $pdf->writeHTML(html: '<strong>Nom : </strong>'.$lastname);
        $pdf->writeHTML(html: '<strong>Prénom : </strong>'.$firstname);
        $pdf->writeHTML(html: '<strong>Né(e) le : </strong>'.$birthday);
        $pdf->writeHTML(html: '<strong>Sexe : </strong>'.$gender);
        $pdf->writeHTML(html: '<strong>Téléphone : </strong>'.$phone);
        $pdf->writeHTML(html: '<strong>Adresse : </strong>'.$address);

        $pdf->writeHTML(html: '<br><br>');
        $pdf->writeHTML(html: '<strong><i>RAPPEL</i></strong>', align: 'C');
        $pdf->writeHTML(html: '<br>');

        $pdf->writeHTML(html: "Les jeunes âgés de 10 à 16 ans ont accès uniquement aux séances de renforcement musculaire léger et de cardio-training.
Toute activité impliquant des charges lourdes ou des exercices complexes leur est strictement interdite.
Ils doivent être accompagnés par un adulte, qui en assume l’entière responsabilité.");
        $pdf->writeHTML(html: '<br>');

        $pdf->writeHTML(html: "Pour le respect de l’hygiène et de la sécurité de tous, le port d’une serviette et de chaussures propres est obligatoire à chaque séance.");
        $pdf->writeHTML(html: '<br>');

        $pdf->writeHTML(html: "L’inscription devient effective lors de la remise de ce bulletin dûment complété, accompagné d’un certificat médical autorisant la pratique de la musculation et/ou du cardio-training, ainsi que du règlement de la cotisation annuelle de 50 €.");
        $pdf->writeHTML(html: "Une caution de 10 € est demandée pour le badge magnétique. Cette somme sera restituée en cas de non-renouvellement de l’adhésion.");

        if($membership->getAge() < 18) {
            $pdf->writeHTML(html: '___________________________________________________________________________________');
            $pdf->writeHTML(html: '<br>');
            $pdf->writeHTML(html: "<i>Je soussigné(e) $tutorNames, demeurant au $tutorAddress, agissant en qualité de représentant légal de $firstname $lastname, autorise ce dernier à fréquenter la salle de musculation de l’association Saint-Ouen Musculation.</i>");
            $pdf->writeHTML(html: '<br>');

            $pdf->writeHTML(html: "Le $today");
            $pdf->writeHTML(html: 'Signature du représentant légal "lu et approuvé"');
        }

        $pdf->writeHTML(html: '___________________________________________________________________________________');
        $pdf->writeHTML(html: '<br>');

        $pdf->writeHTML(html: '<i>Je reconnais avoir pris connaissance des statuts et du règlement intérieur de l’association.</i>', align: 'C');
        $pdf->writeHTML(html: '<br>');

        $pdf->writeHTML(html: "Le $today");
        $pdf->writeHTML(html: "Signature de l'adhérent \"lu et approuvé\"");
        $pdf->writeHTML(html: "Signature d'un membre de la direction");

        return $pdf->Output(name: 'adhesion_saint_ouen_musculation.pdf', dest: 'D');
    }
}

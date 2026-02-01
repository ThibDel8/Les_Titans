<?php

declare(strict_types=1);

namespace App\PublicApp\Legals\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HouseRulesController extends AbstractController
{
    #[Route(path: '/house-rules', name: 'app_house_rules', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $breadcrumb = [
            ['label' => 'Accueil', 'path' => $this->generateUrl('app_home')],
            ['label' => 'Règlements', 'path' => null],
        ];

        return $this->render('_partials/_footer/_legals/_house-rules.html.twig', [
            'breadcrumb' => $breadcrumb,
        ]);
    }
}

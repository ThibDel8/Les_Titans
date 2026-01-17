<?php

namespace App\PublicApp\Legals\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LegalNoticesController extends AbstractController
{
    #[Route(path: '/legal-notices', name: 'app_legal_notices', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        return $this->render('_partials/_footer/_legals/_legal-notices.html.twig');
    }
}

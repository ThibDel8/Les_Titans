<?php

namespace App\Controller\Legals;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrivacyPolicyController extends AbstractController
{
    #[Route(path: '/privacy-policy', name: 'app_privacy_policy', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        return $this->render('_partials/_footer/_legals/_privacy-policy.html.twig');
    }
}

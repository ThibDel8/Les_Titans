<?php

namespace App\PublicApp\About\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
    #[Route(path: '/about', name: 'app_about', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        return $this->render('about/about.html.twig');
    }
}

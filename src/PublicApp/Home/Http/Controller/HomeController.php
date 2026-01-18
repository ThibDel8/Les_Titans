<?php

declare(strict_types=1);

namespace App\PublicApp\Home\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'app_home', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        return $this->render('home/index.html.twig');
    }
}

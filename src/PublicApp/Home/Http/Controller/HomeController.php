<?php

declare(strict_types=1);

namespace App\PublicApp\Home\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\PublicApp\Home\Domain\QueryHandler\HomeQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    public function __construct(private HomeQueryHandler $homeQuery)
    {
    }

    #[Route(path: '/', name: 'app_home', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $data = $this->homeQuery->fetch();

        return $this->render('home/index.html.twig', [
            'nbUsers' => $data['nbUsers'],
            'nbUnreadMessages' => $data['nbUnreadMessages'],
            'nbMemberships' => $data['nbMemberships'],
        ]);
    }
}

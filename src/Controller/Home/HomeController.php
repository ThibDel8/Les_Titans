<?php

declare(strict_types=1);

namespace App\Controller\Home;

use App\QueryHandler\Home\HomeQueryHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
            'nbMembers' => $data['nbMembers'],
            'nbUnreadMessages' => $data['nbUnreadMessages'],
            'nbMemberships' => $data['nbMemberships'],
        ]);
    }
}

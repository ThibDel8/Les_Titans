<?php

declare(strict_types=1);

namespace App\PublicApp\Home\Http\Controller;

use App\PublicApp\Home\Domain\Service\OpeningHoursProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    public function __construct(private OpeningHoursProvider $openingHoursProvider)
    {
    }

    #[Route(path: '/', name: 'app_home', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $openingHours = $this->openingHoursProvider->getOpeningHours();

        return $this->render('home/index.html.twig', [
            'openingHours' => $openingHours,
            'isOpenNow' => $openingHours->isOpenNow(),
            'now' => new \DateTimeImmutable(),
        ]);
    }
}

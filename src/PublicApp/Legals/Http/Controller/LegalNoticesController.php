<?php

namespace App\PublicApp\Legals\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\SharedKernel\Domain\QueryHandler\LegalsQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LegalNoticesController extends AbstractController
{
    public function __construct(private LegalsQueryHandler $legalsQuery)
    {
    }

    #[Route(path: '/legal-notices', name: 'app_legal_notices', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $legalsView = $this->legalsQuery->fetch();

        $breadcrumb = [
            ['label' => 'Accueil', 'path' => $this->generateUrl('app_home')],
            ['label' => 'Mentions légales', 'path' => null],
        ];

        return $this->render('_partials/_footer/_legals/_legal-notices.html.twig', [
            'legalsView' => $legalsView,
            'breadcrumb' => $breadcrumb,
        ]);
    }
}

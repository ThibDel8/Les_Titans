<?php

declare(strict_types=1);

namespace App\PublicApp\Legals\Http\Controller;

use App\PublicApp\Legals\Domain\QueryHandler\LegalsQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PrivacyPolicyController extends AbstractController
{
    public function __construct(private readonly LegalsQueryHandler $legalsQuery)
    {
    }

    #[Route(path: '/privacy-policy', name: 'app_privacy_policy', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $legalsView = $this->legalsQuery->fetch();

        $breadcrumb = [
            ['label' => 'Accueil', 'path' => $this->generateUrl('app_home')],
            ['label' => 'Politique de confidentialité', 'path' => null],
        ];

        return $this->render('_partials/_footer/_legals/_privacy-policy.html.twig', [
            'legalsView' => $legalsView,
            'breadcrumb' => $breadcrumb,
        ]);
    }
}

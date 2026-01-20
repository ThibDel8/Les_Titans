<?php

namespace App\PublicApp\Legals\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\SharedKernel\Domain\QueryHandler\LegalsQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrivacyPolicyController extends AbstractController
{
    public function __construct(private LegalsQueryHandler $legalsQuery)
    {
    }

    #[Route(path: '/privacy-policy', name: 'app_privacy_policy', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $legalsView = $this->legalsQuery->fetch();

        return $this->render('_partials/_footer/_legals/_privacy-policy.html.twig', [
            'legalsView' => $legalsView,
        ]);
    }
}

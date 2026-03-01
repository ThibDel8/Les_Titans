<?php

declare(strict_types=1);

namespace App\PublicApp\Legals\Http\Controller;

use App\PublicApp\Legals\Domain\QueryHandler\LegalsQueryHandler;
use App\PublicApp\Legals\Http\Breadcrumb\PublicLegalsBreadcrumbFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LegalNoticesController extends AbstractController
{
    public function __construct(
        private readonly LegalsQueryHandler $legalsQuery,
        private readonly PublicLegalsBreadcrumbFactory $breadcrumbFactory,
    ) {
    }

    #[Route(path: '/legal-notices', name: 'app_legal_notices', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        $legalsView = $this->legalsQuery->fetch();

        return $this->render('legals/legal-notices.html.twig', [
            'legalsView' => $legalsView,
            'breadcrumbs' => $this->breadcrumbFactory->legalNotices(),
        ]);
    }
}

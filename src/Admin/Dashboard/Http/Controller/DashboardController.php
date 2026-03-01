<?php

declare(strict_types=1);

namespace App\Admin\Dashboard\Http\Controller;

use App\Admin\Dashboard\Http\Breadcrumb\AdminDashboardBreadcrumbFactory;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Admin\Dashboard\Domain\QueryHandler\DashboardQueryHandler;

final class DashboardController extends AbstractController
{
    public function __construct(
        private readonly DashboardQueryHandler $dashboardQuery,
        private readonly AdminDashboardBreadcrumbFactory $breadcrumbFactory,
    ) {
    }

    #[Route(path: '/admin/dashboard', name: 'admin_dashboard', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $dataCounter = $this->dashboardQuery->fetch();

        return $this->render('dashboard/index.html.twig', [
            'nbUsers' => $dataCounter->nbUsers,
            'nbMemberships' => $dataCounter->nbMemberships,
            'nbUnreadMessages' => $dataCounter->nbContactMessages,
            'breadcrumbs' => $this->breadcrumbFactory->dashboard(),
        ]);
    }
}

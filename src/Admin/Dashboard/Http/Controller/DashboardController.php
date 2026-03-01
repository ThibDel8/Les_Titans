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

        $dashboardData = $this->dashboardQuery->fetch();

        return $this->render('dashboard/index.html.twig', [
            'nbUsers' => $dashboardData->nbUsers,
            'nbMemberships' => $dashboardData->nbMemberships,
            'nbUnreadMessages' => $dashboardData->nbContactMessages,
            'logs' => $dashboardData->logs,
            'breadcrumbs' => $this->breadcrumbFactory->dashboard(),
        ]);
    }
}

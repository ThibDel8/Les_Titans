<?php

declare(strict_types=1);

namespace App\Admin\Dashboard\Http\Controller;

use App\SharedKernel\Domain\Enum\Role;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Admin\Dashboard\Domain\QueryHandler\DashboardQueryHandler;

final class DashboardController extends AbstractController
{
    public function __construct(private DashboardQueryHandler $dashboardQuery)
    {
    }

    #[Route(path: '/admin/dashboard', name: 'admin_dashboard', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $data = $this->dashboardQuery->fetch();

        return $this->render('dashboard/index.html.twig', [
            'nbUsers' => $data['nbUsers'],
            'nbUnreadMessages' => $data['nbUnreadMessages'],
            'nbMemberships' => $data['nbMemberships'],
        ]);
    }
}

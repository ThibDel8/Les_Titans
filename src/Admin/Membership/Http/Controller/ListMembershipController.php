<?php

declare(strict_types=1);

namespace App\Admin\Membership\Http\Controller;

use App\Admin\Membership\Domain\QueryHandler\ListMembershipQuery;
use App\Admin\Membership\Http\Breadcrumb\AdminMembershipBreadcrumbFactory;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListMembershipController extends AbstractController
{
    public function __construct(
        private readonly ListMembershipQuery $listMembershipQuery,
        private readonly AdminMembershipBreadcrumbFactory $breadcrumbFactory,
    ) {
    }

    #[Route(path: '/admin/memberships', name: 'admin_membership_list', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $memberships = $this->listMembershipQuery->fetch();

        return $this->render('membership/list.html.twig', [
            'memberships' => $memberships,
            'breadcrumbs' => $this->breadcrumbFactory->listMemberships(),
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Admin\Membership\Http\Controller;

use App\Admin\Membership\Domain\QueryHandler\ListMembershipQuery;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListMembershipController extends AbstractController
{
    public function __construct(private readonly ListMembershipQuery $listMembershipQuery)
    {
    }

    #[Route(path: '/admin/memberships', name: 'admin_membership_list', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $memberships = $this->listMembershipQuery->fetch();

        $breadcrumb = [
            ['label' => 'Accueil', 'path' => $this->generateUrl('app_home')],
            ['label' => 'Administration', 'path' => $this->generateUrl('admin_dashboard')],
            ['label' => 'Liste des demandes d\'adhésion', 'path' => null],
        ];

        return $this->render('membership/list.html.twig', [
            'memberships' => $memberships,
            'breadcrumb' => $breadcrumb,
        ]);
    }
}

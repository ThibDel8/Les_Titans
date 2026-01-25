<?php

declare(strict_types=1);

namespace App\Admin\Membership\Http\Controller;

use App\SharedKernel\Domain\Enum\Role;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Admin\Membership\Domain\Handler\MembershipListHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListMembershipController extends AbstractController
{
    public function __construct(private MembershipListHandler $handler)
    {
    }

    #[Route(path: '/admin/memberships/list', name: 'admin_membership_list', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $memberships = $this->handler->handle();

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

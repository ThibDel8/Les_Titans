<?php

declare(strict_types=1);

namespace App\Controller\Membership;

use App\Enum\Security\Role;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Handler\Membership\MembershipListHandler;
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

        return $this->render('membership/list.html.twig', [
            'memberships' => $memberships,
        ]);
    }
}

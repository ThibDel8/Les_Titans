<?php

declare(strict_types=1);

namespace App\Controller\Member;

use App\Enum\Security\Role;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\QueryHandler\Member\MemberListQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ListMemberController extends AbstractController
{
    public function __construct(private MemberListQueryHandler $memberListQueryHandler)
    {
    }

    #[Route(path: '/admin/members/list', name: 'admin_member_list', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Manager->value);

        $data = $this->memberListQueryHandler->fetch();

        return $this->render('members/list.html.twig', [
            'validMembers' => $data['validMembers'],
            'invalidMembers' => $data['invalidMembers'],
        ]);
    }
}

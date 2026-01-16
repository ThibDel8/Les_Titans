<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Enum\Security\Role;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\QueryHandler\User\ListUserQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ListUserController extends AbstractController
{
    public function __construct(private ListUserQueryHandler $listUserQueryHandler)
    {
    }

    #[Route(path: '/admin/users/list', name: 'admin_user_list', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $data = $this->listUserQueryHandler->fetch();

        return $this->render('users/list.html.twig', [
            'validMembers' => $data['validMembers'],
            'invalidMembers' => $data['invalidMembers'],
        ]);
    }
}

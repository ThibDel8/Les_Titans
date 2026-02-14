<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controller\Crud;

use App\Admin\User\Domain\Handler\CreateUserHandler;
use App\MemberApp\Membership\Domain\Entity\Membership;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateUserController extends AbstractController
{
    public function __construct(private readonly CreateUserHandler $createUserHandler)
    {
    }

    #[Route(path: 'admin/users/create/{id}', name: 'admin_user_create', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods: Request::METHOD_POST)]
    public function __invoke(Membership $membership): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $user = $this->createUserHandler->handle($membership);

        if (null === $user) {
            $this->addFlash('error', 'Ce membre existe déjà.');

            return $this->redirectToRoute('admin_membership_read', ['id' => $membership->getId()]);
        }

        $this->addFlash('success', 'Le membre a bien été créé.');

        return $this->redirectToRoute('admin_user_read', ['id' => $user->getId()]);
    }
}

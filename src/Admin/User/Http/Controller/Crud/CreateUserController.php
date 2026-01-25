<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controller\Crud;

use App\SharedKernel\Domain\Enum\Role;
use App\SharedKernel\Membership\Domain\Entity\Membership;
use App\Admin\User\Domain\Handler\CreateUserHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateUserController extends AbstractController
{
    public function __construct(private CreateUserHandler $createUserHandler)
    {
    }

    #[Route(path: 'admin/users/create/{id}', name: 'admin_user_create', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods: Request::METHOD_POST)]
    public function __invoke(Membership $membership): Response
    {
        $this->denyAccessUnlessGranted(Role::Admin->value);

        $user = $this->createUserHandler->handle($membership);

        if (null === $user) {
            $this->addFlash('error', 'Ce membre existe déjà.');
            return $this->redirectToRoute('admin_membership_read', ['id' => $membership->getId()]);
        }

        $this->addFlash('success', 'Le membre a bien été créé avec succès.');

        return $this->redirectToRoute('admin_user_read', ['id' => $user->getId()]);
    }
}

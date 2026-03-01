<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controller\Crud;

use App\Admin\User\Domain\Entity\User;
use App\Admin\User\Domain\Handler\CreateUserHandler;
use App\MemberApp\Membership\Domain\Entity\Membership;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final class CreateUserController extends AbstractController
{
    public function __construct(private readonly CreateUserHandler $createUserHandler)
    {
    }

    #[Route(path: 'admin/users/create/{id}', name: 'admin_user_create', requirements: ['id' => Requirement::UUID_V7], methods: [Request::METHOD_POST])]
    public function __invoke(Membership $membership): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        /** @var User $author */
        $author = $this->getUser();

        $user = $this->createUserHandler->handle($membership, $author);

        if (null === $user) {
            $this->addFlash('error', 'Ce membre existe déjà.');

            return $this->redirectToRoute('admin_membership_read', ['id' => $membership->getId()]);
        }

        $this->addFlash('success', 'Le membre a bien été créé.');

        return $this->redirectToRoute('admin_user_read', ['id' => $user->getId()]);
    }
}

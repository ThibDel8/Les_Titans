<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controller\Crud;

use App\Admin\User\Domain\Entity\User;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Admin\User\Domain\Handler\DeleteUserHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Requirement\Requirement;

final class DeleteUserController extends AbstractController
{
    public function __construct(private readonly DeleteUserHandler $deleteUserHandler)
    {
    }

    #[Route(path: '/admin/user/{id}/delete', name: 'admin_user_delete', requirements: ['id' => Requirement::UUID_V4], methods: [Request::METHOD_POST])]
    public function __invoke(User $user): Response
    {
        $this->denyAccessUnlessGranted(Role::VicePresident->value);

        $this->deleteUserHandler->handle($user);
        $this->addFlash('success', 'La membre a bien été supprimé.');

        return $this->redirectToRoute('admin_user_list');
    }
}

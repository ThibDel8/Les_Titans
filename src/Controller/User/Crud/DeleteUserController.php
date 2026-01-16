<?php

declare(strict_types=1);

namespace App\Controller\User\Crud;

use App\Enum\Security\Role;
use App\Entity\Security\User;
use App\Handler\User\DeleteUserHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteUserController extends AbstractController
{
    public function __construct(private DeleteUserHandler $deleteUserHandler)
    {
    }

    #[Route(path: '/admin/user/{id}/delete', name: 'admin_user_delete', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:Request::METHOD_POST)]
    public function __invoke(User $user): Response
    {
        $this->denyAccessUnlessGranted(Role::VicePresident->value);

        $this->deleteUserHandler->handle($user);
        $this->addFlash('success', 'La membre a bien été supprimé.');

        return $this->redirectToRoute('admin_user_list');
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\User\Crud;

use App\Enum\Security\Role;
use App\Entity\Member\Member;
use App\Handler\User\CreateUserHandler;
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
    public function __invoke(Member $member): Response
    {
        $this->denyAccessUnlessGranted(Role::Admin->value);

        $success = $this->createUserHandler->handle($member);

        if ($success) {
            $this->addFlash('success', 'L\'utilisateur a bien été créé.');
        } else {
            $this->addFlash('error', 'L\'utilisateur existe déjà.');
        }

        return $this->redirectToRoute('admin_user_list');
    }
}

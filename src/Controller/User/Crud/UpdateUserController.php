<?php

declare(strict_types=1);

namespace App\Controller\User\Crud;

use App\Enum\Security\Role;
use App\Entity\Security\User;
use App\Form\User\UpdateUserType;
use App\DTO\Request\User\UserRequest;
use App\Handler\User\UpdateUserHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UpdateUserController extends AbstractController
{
    public function __construct(private UpdateUserHandler $updateUserHandler)
    {
    }

    #[Route(path: '/admin/users/{id}/update', name: 'admin_user_update', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:[Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(User $user, Request $request): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $userRequest = UserRequest::fromEntity($user);

        $form = $this->createForm(UpdateUserType::class, $userRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateUserHandler->handle($user, $userRequest);
            $this->addFlash('success', 'Le profil a été mis à jour avec succès.');

            return $this->redirectToRoute('admin_user_read', ['id' => $user->getId()]);
        }

        return $this->render('members/crud/update.html.twig', [
            'member' => $user,
            'form' => $form,
        ]);
    }
}

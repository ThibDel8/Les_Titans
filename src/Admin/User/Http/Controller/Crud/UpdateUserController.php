<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controller\Crud;

use App\SharedKernel\Domain\Enum\Role;
use App\Admin\User\Domain\Entity\User;
use App\Admin\User\Http\Form\UpdateUserType;
use App\Admin\User\Domain\DTO\Request\UserRequest;
use App\Admin\User\Domain\Handler\UpdateUserHandler;
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

        return $this->render('users/crud/update.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}

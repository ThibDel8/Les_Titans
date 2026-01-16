<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controller\Crud;

use App\SharedKernel\Domain\Enum\Role;
use App\Admin\User\Domain\Entity\User;
use App\Admin\User\Http\Form\UserAccessBadgeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Admin\User\Domain\DTO\Request\UserAccessBadgeRequest;
use App\Admin\User\Domain\Handler\CreateAccessBadgeNumberHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ReadUserController extends AbstractController
{
    public function __construct(private CreateAccessBadgeNumberHandler $createAccessBadgeNumberHandler)
    {
    }

    #[Route(path: '/admin/users/{id}', name: 'admin_user_read', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:[Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(User $user, Request $request): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $userAccessBadgeRequest = UserAccessBadgeRequest::fromEntity($user);

        $form = $this->createForm(UserAccessBadgeType::class, $userAccessBadgeRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createAccessBadgeNumberHandler->handle($user, $userAccessBadgeRequest);
            $this->addFlash('success', 'Le numéro de badge a été enregistrée avec succès.');

            return $this->redirectToRoute('admin_user_read', ['id' => $user->getId()]);
        }

        return $this->render('users/crud/read.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}

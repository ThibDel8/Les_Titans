<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Enum\Security\Role;
use App\Entity\Security\User;
use App\Handler\User\RenewUserHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class RenewUserController extends AbstractController
{
    public function __construct(private RenewUserHandler $renewUserHandler)
    {
    }

    #[Route(path: '/admin/users/{id}/renew', name: 'admin_user_renew', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:Request::METHOD_POST)]
    public function __invoke(User $user): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $this->renewUserHandler->handle($user);
        $this->addFlash('success', 'L\'adhésion de ce membre a été renouvelée avec succès.');

        return $this->redirectToRoute('admin_user_read', ['id' => $user->getId()]);
    }
}

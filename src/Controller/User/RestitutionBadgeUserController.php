<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Enum\Security\Role;
use App\Entity\Security\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Handler\User\RestitutionBadgeUserHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class RestitutionBadgeUserController extends AbstractController
{
    public function __construct(private RestitutionBadgeUserHandler $restitutionBadgeUserHandler)
    {
    }

    #[Route(path: '/admin/users/{id}/restitution', name: 'admin_user_restitution', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:Request::METHOD_POST)]
    public function __invoke(User $user): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $this->restitutionBadgeUserHandler->handle($user);
        $this->addFlash('success', 'La restitution de la caution et la réception du badge ont été validées avec succès.');

        return $this->redirectToRoute('admin_user_read', ['id' => $user->getId()]);
    }
}

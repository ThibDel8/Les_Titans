<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controller;

use App\SharedKernel\Domain\Enum\Role;
use App\Admin\User\Domain\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Admin\User\Domain\Handler\RestitutionBadgeUserHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Requirement\Requirement;

final class RestitutionBadgeUserController extends AbstractController
{
    public function __construct(private readonly RestitutionBadgeUserHandler $restitutionBadgeUserHandler)
    {
    }

    #[Route(path: '/admin/users/{id}/restitution', name: 'admin_user_restitution', requirements: ['id' => Requirement::UUID_V4], methods: Request::METHOD_POST)]
    public function __invoke(User $user): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $this->restitutionBadgeUserHandler->handle($user);
        $this->addFlash('success', 'La restitution de la caution et la réception du badge ont été validées avec succès.');

        return $this->redirectToRoute('admin_user_read', ['id' => $user->getId()]);
    }
}

<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controller;

use App\SharedKernel\Domain\Enum\Role;
use App\Admin\User\Domain\Entity\User;
use App\Admin\User\Domain\Handler\RenewUserHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Requirement\Requirement;

final class RenewUserController extends AbstractController
{
    public function __construct(private readonly RenewUserHandler $renewUserHandler)
    {
    }

    #[Route(path: '/admin/users/{id}/renew', name: 'admin_user_renew', requirements: ['id' => Requirement::UUID_V4], methods: Request::METHOD_POST)]
    public function __invoke(User $user): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $this->renewUserHandler->handle($user);
        $this->addFlash('success', 'L\'adhésion de ce membre a été renouvelée avec succès.');

        return $this->redirectToRoute('admin_user_read', ['id' => $user->getId()]);
    }
}

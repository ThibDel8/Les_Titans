<?php

declare(strict_types=1);

namespace App\Admin\Membership\Http\Controller\Crud;

use App\SharedKernel\Domain\Enum\Role;
use App\SharedKernel\Membership\Domain\Entity\Membership;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Admin\Membership\Domain\Handler\DeleteMembershipHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteMembershipController extends AbstractController
{
    public function __construct(private DeleteMembershipHandler $deleteMembershipHandler)
    {
    }

    #[Route(path: '/admin/memberships/{id}/delete', name: 'admin_membership_delete', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:[Request::METHOD_POST])]
    public function __invoke(Membership $membership): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $this->deleteMembershipHandler->handle($membership);

        $this->addFlash('success', 'La demande d\'adhésion a bien été supprimée.');

        return $this->redirectToRoute('admin_membership_list');
    }
}

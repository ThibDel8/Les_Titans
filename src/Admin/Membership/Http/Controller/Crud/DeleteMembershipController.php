<?php

declare(strict_types=1);

namespace App\Admin\Membership\Http\Controller\Crud;

use App\Admin\Membership\Domain\Handler\DeleteMembershipHandler;
use App\MemberApp\Membership\Domain\Entity\Membership;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class DeleteMembershipController extends AbstractController
{
    public function __construct(private readonly DeleteMembershipHandler $deleteMembershipHandler)
    {
    }

    #[Route(path: '/admin/memberships/{id}/delete', name: 'admin_membership_delete', requirements: ['id' => Requirement::UUID_V4], methods: Request::METHOD_POST)]
    public function __invoke(Membership $membership): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $this->deleteMembershipHandler->handle($membership);

        $this->addFlash('success', 'La demande d\'adhésion a bien été supprimée.');

        return $this->redirectToRoute('admin_membership_list');
    }
}

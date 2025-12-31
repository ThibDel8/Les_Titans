<?php

declare(strict_types=1);

namespace App\Controller\Member\Crud;

use App\Enum\Security\Role;
use App\Entity\Membership\Membership;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Handler\Member\CreateMemberHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateMemberController extends AbstractController
{
    public function __construct(private CreateMemberHandler $createMemberHandler)
    {
    }

    #[Route(path: '/admin/member/create/{id}', name: 'admin_member_create', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:Request::METHOD_POST)]
    public function __invoke(Membership $membership): Response
    {
        $this->denyAccessUnlessGranted(Role::Manager->value);

        $this->createMemberHandler->handle($membership);

        $this->addFlash('success', 'La demande d\'adhésion a bien été acceptée et le nouveau membre a bien été créé.');

        return $this->redirectToRoute('admin_membership_list');
    }
}

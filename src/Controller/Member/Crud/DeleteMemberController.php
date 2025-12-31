<?php

declare(strict_types=1);

namespace App\Controller\Member\Crud;

use App\Enum\Security\Role;
use App\Entity\Member\Member;
use App\Handler\Member\DeleteMemberHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteMemberController extends AbstractController
{
    public function __construct(private DeleteMemberHandler $deleteMemberHandler)
    {
    }

    #[Route(path: '/admin/member/{id}/delete', name: 'admin_member_delete', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:Request::METHOD_POST)]
    public function __invoke(Member $member): Response
    {
        $this->denyAccessUnlessGranted(Role::Manager->value);

        $this->deleteMemberHandler->handle($member);

        $this->addFlash('success', 'La membre a bien été supprimé.');

        return $this->redirectToRoute('admin_member_list');
    }
}

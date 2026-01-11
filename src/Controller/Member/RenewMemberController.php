<?php

declare(strict_types=1);

namespace App\Controller\Member;

use App\Enum\Security\Role;
use App\Entity\Member\Member;
use App\Handler\Member\RenewMemberHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class RenewMemberController extends AbstractController
{
    public function __construct(private RenewMemberHandler $renewMemberHandler)
    {
    }

    #[Route(path: '/admin/members/{id}/renew', name: 'admin_member_renew', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:Request::METHOD_POST)]
    public function __invoke(Member $member): Response
    {
        $this->denyAccessUnlessGranted(Role::Manager->value);

        $this->renewMemberHandler->handle($member);

        $this->addFlash('success', 'L\'adhésion de ce membre a été renouvelée avec succès.');

        return $this->redirectToRoute('admin_member_read', ['id' => $member->getId()]);
    }
}

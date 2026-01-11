<?php

declare(strict_types=1);

namespace App\Controller\Member;

use App\Enum\Security\Role;
use App\Entity\Member\Member;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Handler\Member\RestitutionBadgeMemberHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class RestitutionBadgeMemberController extends AbstractController
{
    public function __construct(private RestitutionBadgeMemberHandler $restitutionBadgeMemberHandler)
    {
    }

    #[Route(path: '/admin/members/{id}/restitution', name: 'admin_member_restitution', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:Request::METHOD_POST)]
    public function __invoke(Member $member): Response
    {
        $this->denyAccessUnlessGranted(Role::Manager->value);

        $this->restitutionBadgeMemberHandler->handle($member);

        $this->addFlash('success', 'La restitution de la caution et la réception du badge ont été validées avec succès.');

        return $this->redirectToRoute('admin_member_read', ['id' => $member->getId()]);
    }
}

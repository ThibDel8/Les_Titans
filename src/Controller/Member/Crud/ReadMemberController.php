<?php

declare(strict_types=1);

namespace App\Controller\Member\Crud;

use App\Enum\Security\Role;
use App\Entity\Member\Member;
use App\Form\Member\MemberAccessBadgeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\DTO\Request\Member\MemberAccessBadgeRequest;
use App\Handler\Member\CreateAccessBadgeNumberHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ReadMemberController extends AbstractController
{
    public function __construct(private CreateAccessBadgeNumberHandler $createAccessBadgeNumberHandler)
    {
    }

    #[Route(path: '/admin/members/{id}', name: 'admin_member_read', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:[Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Member $member, Request $request): Response
    {
        $this->denyAccessUnlessGranted(Role::Manager->value);

        $memberAccessBadgeRequest = MemberAccessBadgeRequest::fromEntity($member);

        $form = $this->createForm(MemberAccessBadgeType::class, $memberAccessBadgeRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createAccessBadgeNumberHandler->handle($member, $memberAccessBadgeRequest);

            $this->addFlash('success', 'Le numéro de badge a été enregistrée avec succès.');

            return $this->redirectToRoute('admin_member_read', ['id' => $member->getId()]);
        }

        return $this->render('members/crud/read.html.twig', [
            'member' => $member,
            'form' => $form,
        ]);
    }
}

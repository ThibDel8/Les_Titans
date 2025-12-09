<?php

declare(strict_types=1);

namespace App\Controller\Member\Crud;

use App\Enum\Security\Role;
use App\Entity\Member\Member;
use App\Form\Member\UpdateMemberType;
use App\DTO\Request\Member\MemberRequest;
use App\Handler\Member\UpdateMemberHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UpdateMemberController extends AbstractController
{
    public function __construct(private UpdateMemberHandler $updateMemberHandler)
    {
    }

    #[Route(path: '/admin/members/{id}/update', name: 'admin_member_update', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:[Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Member $member, Request $request): Response
    {
        $this->denyAccessUnlessGranted(Role::Manager->value);

        $memberRequest = MemberRequest::fromEntity($member);

        $form = $this->createForm(UpdateMemberType::class, $memberRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateMemberHandler->handle($member, $memberRequest);

            $this->addFlash('success', 'Le profil a été mis à jour avec succès.');

            return $this->redirectToRoute('admin_member_read', ['id' => $member->getId()]);
        }

        return $this->render('members/crud/update.html.twig', [
            'member' => $member,
            'form' => $form,
        ]);
    }
}

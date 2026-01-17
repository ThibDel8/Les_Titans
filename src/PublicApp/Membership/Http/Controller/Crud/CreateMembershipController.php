<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Http\Controller\Crud;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\PublicApp\Membership\Http\Form\MembershipCreationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\PublicApp\Membership\Domain\Handler\MembershipCreateHandler;
use App\PublicApp\Membership\Domain\DTO\Request\MembershipCreationRequest;

class CreateMembershipController extends AbstractController
{
    public function __construct(private MembershipCreateHandler $createMembershipHandler)
    {
    }

    #[Route(path: '/memberships/create', name: 'app_membership_create', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Request $request): Response
    {
        $membershipCreationRequest = new MembershipCreationRequest();

        $form = $this->createForm(MembershipCreationType::class, $membershipCreationRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $membership = $this->createMembershipHandler->handle($membershipCreationRequest);

            $this->addFlash('success', 'La demande d’adhésion a été enregistrée avec succès.');

            return $this->redirectToRoute('app_membership_pending', ['id' => $membership->getId()]);
        }

        return $this->render('membership/crud/create.html.twig', [
            'form' => $form,
        ]);
    }
}

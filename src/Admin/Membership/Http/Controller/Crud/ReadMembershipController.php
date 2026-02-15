<?php

declare(strict_types=1);

namespace App\Admin\Membership\Http\Controller\Crud;

use App\Admin\Membership\Domain\DTO\Request\ValidateMembershipRequest;
use App\Admin\Membership\Domain\Handler\ValidateMembershipHandler;
use App\Admin\Membership\Http\Form\ValidateMembershipType;
use App\MemberApp\Membership\Domain\Entity\Membership;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReadMembershipController extends AbstractController
{
    public function __construct(
        private readonly int $annualFee,
        private readonly int $accessBadgeDeposit,
        private readonly ValidateMembershipHandler $validateMembershipHandler,
    ) {
    }

    #[Route(path: '/admin/memberships/{id}', name: 'admin_membership_read', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:[Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Membership $membership, Request $request): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $membershipValidationRequest = ValidateMembershipRequest::fromEntity($membership);

        $form = $this->createForm(ValidateMembershipType::class, $membershipValidationRequest, [
            'annual_fee' => $this->annualFee,
            'badge_deposit' => $this->accessBadgeDeposit,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->validateMembershipHandler->handle($membership, $membershipValidationRequest);

            if ($membership->hasValidRegistration()) {
                $this->addFlash('info', 'La demande d\'adhésion est maintenant valide. Elle peut être Acceptée.');
            } else {
                $this->addFlash('success', 'La modification de cette demande d\'adhésion a été enregistrée avec succès.');
            }

            return $this->redirectToRoute('admin_membership_read', ['id' => $membership->getId()]);
        }

        $breadcrumb = [
            ['label' => 'Accueil', 'path' => $this->generateUrl('app_home')],
            ['label' => 'Administration', 'path' => $this->generateUrl('admin_dashboard')],
            ['label' => 'Liste des demandes d\'adhésion', 'path' => $this->generateUrl('admin_membership_list')],
            ['label' => $membership->getFirstname().' '.$membership->getLastname(), 'path' => null],
        ];

        return $this->render('membership/crud/read.html.twig', [
            'membership' => $membership,
            'form' => $form,
            'breadcrumb' => $breadcrumb,
        ]);
    }
}

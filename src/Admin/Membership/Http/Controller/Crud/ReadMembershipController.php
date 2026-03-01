<?php

declare(strict_types=1);

namespace App\Admin\Membership\Http\Controller\Crud;

use App\Admin\Membership\Domain\DTO\Request\ValidateMembershipRequest;
use App\Admin\Membership\Domain\Handler\ValidateMembershipHandler;
use App\Admin\Membership\Http\Breadcrumb\AdminMembershipBreadcrumbFactory;
use App\Admin\Membership\Http\Form\ValidateMembershipType;
use App\MemberApp\Membership\Domain\Entity\Membership;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final class ReadMembershipController extends AbstractController
{
    public function __construct(
        private readonly int $annualFee,
        private readonly int $accessBadgeDeposit,
        private readonly AdminMembershipBreadcrumbFactory $breadcrumbFactory,
        private readonly ValidateMembershipHandler $validateMembershipHandler,
    ) {
    }

    #[Route(path: '/admin/memberships/{id}', name: 'admin_membership_read', requirements: ['id' => Requirement::UUID_V4], methods:[Request::METHOD_GET, Request::METHOD_POST])]
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
                $this->addFlash('success', 'La modification de cette demande d\'adhésion a bien été enregistrée.');
            }

            return $this->redirectToRoute('admin_membership_read', ['id' => $membership->getId()]);
        }

        return $this->render('membership/crud/read.html.twig', [
            'membership' => $membership,
            'form' => $form,
            'breadcrumbs' => $this->breadcrumbFactory->readMembership($membership),
        ]);
    }
}

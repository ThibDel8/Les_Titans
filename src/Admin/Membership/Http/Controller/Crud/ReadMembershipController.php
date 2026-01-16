<?php

declare(strict_types=1);

namespace App\Admin\Membership\Http\Controller\Crud;

use App\SharedKernel\Domain\Enum\Role;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\SharedKernel\Membership\Domain\Entity\Membership;
use App\Admin\Membership\Http\Form\MembershipValidationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Admin\Membership\Domain\Handler\MembershipValidationHandler;
use App\Admin\Membership\Domain\DTO\Request\MembershipValidationRequest;

class ReadMembershipController extends AbstractController
{
    public function __construct(private MembershipValidationHandler $handler)
    {
    }

    #[Route(path: '/admin/memberships/{id}', name: 'admin_membership_read', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:[Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Membership $membership, Request $request): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $membershipValidationRequest = MembershipValidationRequest::fromEntity($membership);

        $form = $this->createForm(MembershipValidationType::class, $membershipValidationRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handler->handle($membership, $membershipValidationRequest);

            if ($membership->hasValidRegistration()) {
                $this->addFlash('info', 'La demande d\'adhésion est maintenant valide. Elle peut être Acceptée.');
            } else {
                $this->addFlash('success', 'La modification de cette demande d\'adhésion a été enregistrée avec succès.');
            }

            return $this->redirectToRoute('admin_membership_read', ['id' => $membership->getId()]);
        }

        return $this->render('membership/crud/read.html.twig', [
            'membership' => $membership,
            'form' => $form,
        ]);
    }
}

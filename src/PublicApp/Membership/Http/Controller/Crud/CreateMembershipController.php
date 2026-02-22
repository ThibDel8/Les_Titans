<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Http\Controller\Crud;

use App\PublicApp\Membership\Http\Breadcrumb\PublicMembershipBreadcrumbFactory;
use App\SharedKernel\Domain\Const\Regex;
use Random\RandomException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\PublicApp\Membership\Http\Form\MembershipCreationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\PublicApp\Membership\Domain\Handler\CreateMembershipHandler;
use App\PublicApp\Membership\Domain\DTO\Request\MembershipCreationRequest;

final class CreateMembershipController extends AbstractController
{
    public function __construct(
        private readonly CreateMembershipHandler $createMembershipHandler,
        private readonly PublicMembershipBreadcrumbFactory $breadcrumbFactory,
    ) {
    }

    /**
     * @throws TransportExceptionInterface|RandomException
     */
    #[Route(path: '/memberships/create', name: 'app_membership_create', requirements: ['id' => Regex::UUID_V4], methods: [Request::METHOD_GET, Request::METHOD_POST])]
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
            'breadcrumbs' => $this->breadcrumbFactory->createMembership(),
        ]);
    }
}

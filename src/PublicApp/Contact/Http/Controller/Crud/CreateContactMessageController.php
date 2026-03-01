<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Http\Controller\Crud;

use App\PublicApp\Contact\Domain\DTO\Request\ContactMessageCreationRequest;
use App\PublicApp\Contact\Domain\Handler\CreateContactMessageHandler;
use App\PublicApp\Contact\Domain\QueryHandler\CreateContactMessageQueryHandler;
use App\PublicApp\Contact\Http\Breadcrumb\PublicContactBreadcrumbFactory;
use App\PublicApp\Contact\Http\Form\ContactMessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class CreateContactMessageController extends AbstractController
{
    public function __construct(
        private readonly CreateContactMessageHandler $createMessageHandler,
        private readonly PublicContactBreadcrumbFactory $breadcrumbFactory,
        private readonly CreateContactMessageQueryHandler $createMessageQuery,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route(path: '/contact', name: 'app_contact', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Request $request): Response
    {
        $messageRequest = ContactMessageCreationRequest::create(email: $this->getUser()?->getUserIdentifier());

        $boardMembers = $this->createMessageQuery->fetch();

        $form = $this->createForm(ContactMessageType::class, $messageRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createMessageHandler->handle($messageRequest);

            $this->addFlash('success', 'Votre message a bien été envoyé.');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/crud/create.html.twig', [
            'form' => $form,
            'boardMembers' => $boardMembers,
            'breadcrumbs' => $this->breadcrumbFactory->createContactMessage(),
        ]);
    }
}

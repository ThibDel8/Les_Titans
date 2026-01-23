<?php

declare(strict_types=1);

namespace App\Contact\Http\Controller\Crud;

use App\Contact\Http\Form\ContactMessageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Contact\Domain\Handler\CreateContactMessageHandler;
use App\Contact\Domain\DTO\Request\ContactMessageCreationRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Contact\Domain\QueryHandler\CreateContactMessageQueryHandler;

final class CreateContactMessageController extends AbstractController
{
    public function __construct(
        private CreateContactMessageHandler $createMessageHandler,
        private CreateContactMessageQueryHandler $createMessageQuery,
        )
    {
    }

    #[Route(path: '/contact', name: 'app_contact', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Request $request): Response
    {
        $messageRequest = new ContactMessageCreationRequest();

        $boardMembers = $this->createMessageQuery->fetch();

        $form = $this->createForm(ContactMessageType::class, $messageRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createMessageHandler->handle($messageRequest);

            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/crud/create.html.twig', [
            'form' => $form,
            'boardMembers' => $boardMembers,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Http\Controller\Crud;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\PublicApp\Contact\Http\Form\ContactType;
use App\PublicApp\Contact\Domain\Handler\CreateMessageHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\PublicApp\Contact\Domain\DTO\Request\MessageCreationRequest;
use App\PublicApp\Contact\Domain\QueryHandler\CreateMessageQueryHandler;

final class CreateMessageController extends AbstractController
{
    public function __construct(
        private CreateMessageHandler $createMessageHandler,
        private CreateMessageQueryHandler $createMessageQuery,
        )
    {
    }

    #[Route(path: '/contact', name: 'app_contact', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Request $request): Response
    {
        $messageRequest = new MessageCreationRequest();

        $boardMembers = $this->createMessageQuery->fetch();

        $form = $this->createForm(ContactType::class, $messageRequest);
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

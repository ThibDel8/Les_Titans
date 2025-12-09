<?php

declare(strict_types=1);

namespace App\Controller\Contact;

use App\Form\Contact\ContactType;
use App\Handler\Contact\CreateMessageHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\DTO\Request\Contact\MessageCreationRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ContactController extends AbstractController
{
    public function __construct(private CreateMessageHandler $createMessageHandler)
    {
    }

    #[Route(path: '/contact', name: 'app_contact', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Request $request): Response
    {
        $messageRequest = new MessageCreationRequest();

        $form = $this->createForm(ContactType::class, $messageRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createMessageHandler->handle($messageRequest);

            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}

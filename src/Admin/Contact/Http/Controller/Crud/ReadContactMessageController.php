<?php

declare(strict_types=1);

namespace App\Admin\Contact\Http\Controller\Crud;

use App\Admin\User\Domain\Entity\User;
use App\SharedKernel\Domain\Enum\Role;
use App\Contact\Domain\Entity\ContactMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Admin\Contact\Http\Form\AnswerContactMessageType;
use App\Admin\Contact\Domain\Handler\ReadContactMessageHandler;
use App\Admin\Contact\Domain\Handler\AnswerContactMessageHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Admin\Contact\Domain\DTO\Request\AnswerContactMessageRequest;

final class ReadContactMessageController extends AbstractController
{
    public function __construct(
        private ReadContactMessageHandler $readContactMessageHandler,
        private AnswerContactMessageHandler $answerContactMessageHandler,
    ) {
    }

    #[Route(path: '/contact-messages/{id}/read', name: 'admin_contact_message_read', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(ContactMessage $contactMessage, Request $request): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        /** @var User $user */
        $user = $this->getUser();

        $answerContactMessageRequest = AnswerContactMessageRequest::fromEntity($contactMessage);

        $form = $this->createForm(AnswerContactMessageType::class, $answerContactMessageRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->answerContactMessageHandler->handle($contactMessage, $answerContactMessageRequest, $user);
            $this->addFlash('success', 'Le message a bien été envoyé.');

            return $this->redirectToRoute('admin_contact_message_read', ['id' => $contactMessage->getId()]);
        }

        $this->readContactMessageHandler->handle($contactMessage, $user);

        $breadcrumb = [
            ['label' => 'Accueil', 'path' => $this->generateUrl('app_home')],
            ['label' => 'Administration', 'path' => $this->generateUrl('admin_dashboard')],
            ['label' => 'Liste des messages', 'path' => $this->generateUrl('admin_contact_message_list')],
            ['label' => 'Message', 'path' => null],
        ];

        return $this->render('contact/crud/read.html.twig', [
            'message' => $contactMessage,
            'form' => $form,
            'breadcrumb' => $breadcrumb,
        ]);
    }
}

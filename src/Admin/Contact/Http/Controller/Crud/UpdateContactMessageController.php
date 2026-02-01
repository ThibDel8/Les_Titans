<?php

declare(strict_types=1);

namespace App\Admin\Contact\Http\Controller\Crud;

use App\Admin\Contact\Domain\Handler\UpdateContactMessageHandler;
use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UpdateContactMessageController extends AbstractController
{
    public function __construct(private readonly UpdateContactMessageHandler $updateContactMessageHandler) {
    }

    #[Route(path: '/admin/contact-messages/{id}/unread', name: 'admin_contact_message_unread', methods: Request::METHOD_POST)]
    public function __invoke(ContactMessage $contactMessage): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $this->updateContactMessageHandler->handle($contactMessage);
        $this->addFlash('success', 'Le message a bien été enregistré comme "Non lu".');

        return $this->redirectToRoute('admin_contact_message_list');
    }
}

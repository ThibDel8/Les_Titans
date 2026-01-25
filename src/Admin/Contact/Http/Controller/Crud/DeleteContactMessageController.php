<?php

declare(strict_types=1);

namespace App\Admin\Contact\Http\Controller\Crud;

use App\SharedKernel\Domain\Enum\Role;
use App\Contact\Domain\Entity\ContactMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Admin\Contact\Domain\Handler\DeleteContactMessageHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteContactMessageController extends AbstractController
{
    public function __construct(private DeleteContactMessageHandler $deleteContactMessageHandler)
    {
    }

    #[Route(path: '/admin/contact-messages/{id}/delete', name: 'admin_contact_message_delete', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:[Request::METHOD_POST])]
    public function __invoke(ContactMessage $contactMessage): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $this->deleteContactMessageHandler->handle($contactMessage);

        $this->addFlash('success', 'Le message a bien été supprimé.');

        return $this->redirectToRoute('admin_contact_message_list');
    }
}

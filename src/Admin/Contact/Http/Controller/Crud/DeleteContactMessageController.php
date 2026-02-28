<?php

declare(strict_types=1);

namespace App\Admin\Contact\Http\Controller\Crud;

use App\Admin\Contact\Domain\Handler\DeleteContactMessageHandler;
use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class DeleteContactMessageController extends AbstractController
{
    public function __construct(private readonly DeleteContactMessageHandler $deleteContactMessageHandler)
    {
    }

    #[Route(path: '/admin/contact-messages/{id}/delete', name: 'admin_contact_message_delete', requirements: ['id' => Requirement::UUID_V4], methods: Request::METHOD_POST)]
    public function __invoke(ContactMessage $contactMessage): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $this->deleteContactMessageHandler->handle($contactMessage);

        $this->addFlash('success', 'Le message a bien été supprimé.');

        return $this->redirectToRoute('admin_contact_message_list');
    }
}

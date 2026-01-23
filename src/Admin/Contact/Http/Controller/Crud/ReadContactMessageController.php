<?php

declare(strict_types=1);

namespace App\Admin\Contact\Http\Controller\Crud;

use App\Contact\Domain\Entity\ContactMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ReadContactMessageController extends AbstractController
{

    #[Route(path: '/contact-messages/{id}/read', name: 'admin_contact_message_read', methods: Request::METHOD_GET)]
    public function __invoke(ContactMessage $contactMessage): Response
    {
        return $this->render('contact/crud/read.html.twig', [
            'message' => $contactMessage,
        ]);
    }
}

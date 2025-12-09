<?php

declare(strict_types=1);

namespace App\Controller\Contact\Crud;

use App\Entity\Contact\Message;
use App\Handler\Contact\ReadMessageHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ReadMessageController extends AbstractController
{
    public function __construct(private ReadMessageHandler $readMessageHandler)
    {
    }

    #[Route(path: '/messages/{id}', name: 'admin_message_read', methods: Request::METHOD_GET)]
    public function __invoke(Message $message): Response
    {
        $message = $this->readMessageHandler->handle($message);

        return $this->render('contact/crud/read.html.twig', [
            'message' => $message,
        ]);
    }
}

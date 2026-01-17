<?php

declare(strict_types=1);

namespace App\Admin\Contact\Http\Controller\Crud;

use App\SharedKernel\Contact\Domain\Entity\Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Admin\Contact\Domain\Handler\ReadMessageHandler;
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

<?php

declare(strict_types=1);

namespace App\Controller\Contact;

use App\QueryHandler\Contact\ListMessageQueryHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ListMessageController extends AbstractController
{
    public function __construct(private ListMessageQueryHandler $listMessageHandler)
    {
    }

    #[Route(path: '/admin/messages/list', name: 'admin_message_list', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $messages = $this->listMessageHandler->fetch();

        return $this->render('contact/list.html.twig', [
            'messages' => $messages,
        ]);
    }
}

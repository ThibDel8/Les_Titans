<?php

declare(strict_types=1);

namespace App\Admin\Contact\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Admin\Contact\Domain\QueryHandler\ListContactMessageQueryHandler;

final class ListContactMessageController extends AbstractController
{
    public function __construct(private ListContactMessageQueryHandler $listContactMessageQuery)
    {
    }

    #[Route(path: '/contact-messages', name: 'admin_contact_message_list', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $messages = $this->listContactMessageQuery->fetch();

        $breadcrumb = [
            ['label' => 'Accueil', 'path' => $this->generateUrl('app_home')],
            ['label' => 'Administration', 'path' => $this->generateUrl('admin_dashboard')],
            ['label' => 'Messages', 'path' => null],
        ];

        return $this->render('contact/list.html.twig', [
            'messages' => $messages,
            'breadcrumb' => $breadcrumb,
        ]);
    }
}

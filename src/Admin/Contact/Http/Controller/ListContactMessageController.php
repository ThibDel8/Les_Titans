<?php

declare(strict_types=1);

namespace App\Admin\Contact\Http\Controller;

use App\Admin\Contact\Http\Breadcrumb\AdminContactBreadcrumbFactory;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Admin\Contact\Domain\QueryHandler\ListContactMessageQueryHandler;

final class ListContactMessageController extends AbstractController
{
    public function __construct(
        private readonly AdminContactBreadcrumbFactory $breadcrumbFactory,
        private readonly ListContactMessageQueryHandler $listContactMessageQuery,
    ) {
    }

    #[Route(path: '/admin/contact-messages', name: 'admin_contact_message_list', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $messages = $this->listContactMessageQuery->fetch();

        return $this->render('contact/list.html.twig', [
            'messages' => $messages,
            'breadcrumbs' => $this->breadcrumbFactory->listContactMessage(),
        ]);
    }
}

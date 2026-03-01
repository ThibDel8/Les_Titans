<?php

declare(strict_types=1);

namespace App\Admin\Document\Http\Controller;

use App\Admin\Document\Http\Breadcrumb\DocumentBreadcrumbFactory;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListDocumentController extends AbstractController
{
    public function __construct(private readonly DocumentBreadcrumbFactory $breadcrumbFactory)
    {
    }

    #[Route(path: '/admin/documents', name: 'admin_document_list', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        return $this->render('documents/list.html.twig', [
            'breadcrumbs' => $this->breadcrumbFactory->adminDocuments(),
        ]);
    }
}

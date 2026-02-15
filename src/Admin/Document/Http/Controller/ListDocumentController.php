<?php

declare(strict_types=1);

namespace App\Admin\Document\Http\Controller;

use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListDocumentController extends AbstractController
{
    #[Route(path: '/admin/documents', name: 'admin_document_list', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $breadcrumb = [
            ['label' => 'Accueil', 'path' => $this->generateUrl('app_home')],
            ['label' => 'Administration', 'path' => $this->generateUrl('admin_dashboard')],
            ['label' => 'Documents', 'path' => null],
        ];

        return $this->render('documents/list.html.twig', [
            'breadcrumb' => $breadcrumb,
        ]);
    }
}

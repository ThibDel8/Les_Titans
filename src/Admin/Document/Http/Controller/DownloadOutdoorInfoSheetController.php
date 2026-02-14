<?php

declare(strict_types=1);

namespace App\Admin\Document\Http\Controller;

use App\Admin\Document\Domain\QueryHandler\OutdoorInfoSheetQuery;
use App\Admin\Document\Infrastructure\Pdf\OutdoorInfoSheetGenerator;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DownloadOutdoorInfoSheetController extends AbstractController
{
    public function __construct(
        private readonly OutdoorInfoSheetQuery $outdoorInfoSheetQuery,
        private readonly OutdoorInfoSheetGenerator $outdoorInfoSheetGenerator,
    ) {
    }

    #[Route(path: '/documents/download-outdoor-info-sheet', name: 'admin_document_download_outdoor_info_sheet', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Secretary->value);

        $data = $this->outdoorInfoSheetQuery->fetch();
        $pdf = $this->outdoorInfoSheetGenerator->generate($data);

        return new Response(
            content: $pdf,
            status: Response::HTTP_OK,
            headers: [
                'Content-Type' => 'application/pdf',
            ],
        );
    }
}

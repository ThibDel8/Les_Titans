<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Http\Controller;

use App\MemberApp\Membership\Domain\Entity\Membership;
use App\PublicApp\Membership\Domain\Service\PDF\MembershipPdfGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;

class DownloadMembershipController extends AbstractController
{
    public function __construct(private readonly MembershipPdfGenerator $membershipPdfGenerator)
    {
    }

    #[Route(path: '/memberships/{id}/download', name: 'app_membership_download', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods: Request::METHOD_GET)]
    public function __invoke(Membership $membership): StreamedResponse
    {
        return new StreamedResponse(
            callbackOrChunks: function () use ($membership) {
                echo $this->membershipPdfGenerator->generate($membership);
            },
            status: Response::HTTP_OK,
            headers: [
                'Content-Type' => 'application/pdf',
            ]
        );
    }
}

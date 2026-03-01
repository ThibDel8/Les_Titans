<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Http\Controller;

use App\MemberApp\Membership\Domain\Entity\Membership;
use App\PublicApp\Membership\Domain\QueryHandler\MembershipPdfQuery;
use App\PublicApp\Membership\Infrastructure\Pdf\MembershipPdfGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final class DownloadMembershipController extends AbstractController
{
    public function __construct(
        private readonly MembershipPdfQuery $membershipPdfQuery,
        private readonly MembershipPdfGenerator $membershipPdfGenerator,
    ) {
    }

    #[Route(path: '/memberships/{id}/download', name: 'app_membership_download', requirements: ['id' => Requirement::UUID_V4], methods: [Request::METHOD_GET])]
    public function __invoke(Membership $membership): Response
    {
        $data = $this->membershipPdfQuery->fetch($membership);

        return new Response(
            content: $this->membershipPdfGenerator->generate($data),
            headers: [
                'Content-Type' => 'application/pdf',
            ]
        );
    }
}

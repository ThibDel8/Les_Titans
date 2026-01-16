<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\SharedKernel\Membership\Domain\Entity\Membership;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\PublicApp\Membership\Domain\Service\PDF\MembershipPdfGenerator;

class DownloadMembershipController extends AbstractController
{
    public function __construct(private MembershipPdfGenerator $membershipPdfGenerator)
    {
    }

    #[Route(path: '/memberships/{id}/download', name: 'app_membership_download', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods: Request::METHOD_GET)]
    public function __invoke(Membership $membership): Response
    {
        return new Response($this->membershipPdfGenerator->generate($membership));
    }
}

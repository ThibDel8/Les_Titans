<?php

declare(strict_types=1);

namespace App\Controller\Membership;

use App\Entity\Membership\Membership;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\PDF\Membership\MembershipPdfGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

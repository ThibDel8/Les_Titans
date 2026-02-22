<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Http\Controller;

use App\MemberApp\Membership\Domain\Entity\Membership;
use App\PublicApp\Membership\Http\Breadcrumb\PublicMembershipBreadcrumbFactory;
use App\SharedKernel\Domain\Const\Regex;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PendingMembershipController extends AbstractController
{
    public function __construct(private readonly PublicMembershipBreadcrumbFactory $breadcrumbFactory)
    {
    }

    #[Route(path: '/memberships/{id}/pending', name: 'app_membership_pending', requirements: ['id' => Regex::UUID_V4], methods: Request::METHOD_GET)]
    public function __invoke(Membership $membership): Response
    {
        return $this->render('membership/pending.html.twig', [
            'membership' => $membership,
            'breadcrumbs' => $this->breadcrumbFactory->pendingMembership(),
        ]);
    }
}

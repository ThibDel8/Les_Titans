<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Http\Controller;

use App\SharedKernel\Membership\Domain\Entity\Membership;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PendingMembershipController extends AbstractController
{
    #[Route(path: '/memberships/{id}/pending', name: 'app_membership_pending', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods: Request::METHOD_GET)]
    public function __invoke(Membership $membership): Response
    {
        return $this->render('membership/pending.html.twig', [
            'membership' => $membership,
        ]);
    }
}

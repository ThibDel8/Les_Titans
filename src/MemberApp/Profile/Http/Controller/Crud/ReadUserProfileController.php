<?php

declare(strict_types=1);

namespace App\MemberApp\Profile\Http\Controller\Crud;

use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReadUserProfileController extends AbstractController
{
    #[Route(path: '/profile', name: 'app_profile_read', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Member->value);

        $breadcrumb = [
            ['label' => 'Accueil', 'path' => $this->generateUrl('app_home')],
            ['label' => 'Profil', 'path' => null],
        ];

        return $this->render('profile/crud/read.html.twig', [
            'breadcrumb' => $breadcrumb,
        ]);
    }
}

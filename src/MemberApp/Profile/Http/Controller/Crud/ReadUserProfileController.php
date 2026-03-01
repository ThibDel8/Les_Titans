<?php

declare(strict_types=1);

namespace App\MemberApp\Profile\Http\Controller\Crud;

use App\MemberApp\Profile\Http\Breadcrumb\MemberProfileBreadcrumbFactory;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReadUserProfileController extends AbstractController
{
    public function __construct(private readonly MemberProfileBreadcrumbFactory $breadcrumbFactory)
    {
    }

    #[Route(path: '/profile', name: 'app_profile_read', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Member->value);

        return $this->render('profile/crud/read.html.twig', [
            'breadcrumbs' => $this->breadcrumbFactory->createProfile(),
        ]);
    }
}
